<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Lote;
use App\Models\VentaProducto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Auth;
use DB;
use File;
use Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function proceso_compra(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        $cliente = Cliente::where('estado', 'activo')->get();

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.venta.index', compact('usuario', 'nombre', 'tipo', 'cliente'));
    }

    public function buscar_prod_compra(Request $request)
    {
        $producto = Producto::find($request->id);

        if ($producto) {
            $cantidad = $request->cantidad ?? 1; // Si no se envía cantidad, se asume 1
            $stock = $producto->obtenerStock();
            $stock = $stock > 0 ? $stock : 'Sin lotes';
            $subtotal = $producto->precio * $cantidad;

            return response()->json([
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'concentracion' => $producto->concentracion,
                'adicional' => $producto->adicional,
                'laboratorio' => $producto->laboratorio->nombre ?? 'No disponible',
                'presentacion' => $producto->presentacion->nombre ?? 'No disponible',
                'stock' => $stock,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json(['error' => 'Producto no encontrado'], 404);
    }

    public function enviar_venta(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'cliente' => 'nullable|string',
            'cliente1' => 'nullable|string',
            'productos' => 'required|array',
        ]);

        $total = $request->total;
        $cliente = $request->cliente;
        $cliente1 = $request->cliente1;
        $productos = $request->productos;
        $vendedor = auth()->user()->id; // Usuario autenticado

        DB::beginTransaction();

        try {
            // Crear la venta
            $venta = Venta::create([
                'total' => $total,
                'vendedor' => $vendedor,
                'id_cliente' => $cliente,
                'cliente_no_reg' => $cliente1,
            ]);

            foreach ($productos as $prod) {
                $cantidadRestante = $prod['cantidad'];
                $productoId = $prod['id'];
                $precio = $prod['precio'];
                $subtotal = $cantidadRestante * $precio;

                // Buscar lotes activos del producto
                $lotes = Lote::where('id_producto', $productoId)->where('estado', 'Activo')->orderBy('vencimiento', 'asc')->get();

                if ($lotes->isEmpty()) {
                    throw new \Exception("No hay stock suficiente para el producto ID: $productoId");
                }

                foreach ($lotes as $lote) {
                    if ($cantidadRestante <= 0) {
                        break; // Si ya completamos la venta, salimos del bucle
                    }

                    $cantidadAConsumir = min($cantidadRestante, $lote->cantidad_lote);
                    $proveedor = $lote->compra->id_proveedor; // Relación entre lote y compra

                    // Registrar detalle de la venta
                    DetalleVenta::create([
                        'det_cantidad' => $cantidadAConsumir,
                        'det_vencimiento' => $lote->vencimiento,
                        'id_det_lote' => $lote->id,
                        'id_det_prod' => $productoId,
                        'lote_id_prov' => $proveedor,
                        'id_det_venta' => $venta->id,
                    ]);

                    // Actualizar stock del lote
                    $lote->cantidad_lote -= $cantidadAConsumir;
                    if ($lote->cantidad_lote <= 0) {
                        $lote->estado = 'Inactivo'; // Desactivar lote si se agota
                    }
                    $lote->save();

                    $cantidadRestante -= $cantidadAConsumir;
                }

                if ($cantidadRestante > 0) {
                    throw new \Exception("Stock insuficiente para completar la venta del producto ID: $productoId");
                }

                // Registrar el producto en venta_producto
                VentaProducto::create([
                    'precio' => $precio,
                    'cantidad' => $prod['cantidad'],
                    'subtotal' => $subtotal,
                    'id_producto' => $productoId,
                    'id_venta' => $venta->id,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Venta registrada con éxito', 'id' => $venta->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generar_boucher($id)
    {
        $logoContent = file_get_contents(public_path('img/logo.png'));
        // Convertir el logo a base64
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);

        // Obtener la venta
        $venta = Venta::findOrFail($id);

        // Obtener los productos de la venta mediante la relación con VentaProducto
        $productos = VentaProducto::where('id_venta', $id)->with('producto')->get();
        //dd($productos); // Descomentar para ver los datos del boucher
        // Calcular el total sumando los subtotales de cada producto
        $total = $productos->sum(function ($producto) {
            return $producto->precio * $producto->cantidad;
        });

        // Obtener la fecha actual para el footer
        $fechaImpresion = now()->format('d/m/Y H:i:s');

        // Obtener el usuario autenticado
        $usuarioGenerador = auth()->user()->name;

        // Preparar los datos para el boucher
        $datosBoucher = [
            'fecha' => $venta->created_at->format('d/m/Y H:i:s'),
            'cliente' => optional($venta->cliente)->nombre ?? 'Cliente desconocido', // Asume que tienes una relación con Cliente
            'total' => $total,
            'productos' => $productos,
            'logo_url' => $logoBase64,
            'nombre_negocio' => 'Supermercado XYZ',
            'direccion_negocio' => 'Calle Ficticia, Ciudad',
            'telefono_negocio' => '123-456-789',
            'fecha_impresion' => $fechaImpresion, // Fecha de impresión
            'usuario_generador' => $usuarioGenerador, // Usuario que generó la venta
        ];

        // Configurar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('debugKeepTemp', false);

        $dompdf = new Dompdf($options);

        // Generar la vista para el PDF
        $pdf = view('admin.venta.boucher', $datosBoucher)->render(); // Agregado ->render() para obtener el HTML

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($pdf);

        // Configurar el tamaño del papel para un boucher de supermercado (80mm x 200mm)
        $dompdf->setPaper([0, 0, 300, 600], 'portrait'); // [Ancho, Alto] en milímetros

        // Renderizar el PDF
        $dompdf->render();

        return $dompdf->stream('boucher_venta_.pdf', [
            'Attachment' => 0, // Esto asegura que el PDF se abre en el navegador y no se descarga
        ]);
    }

    public function vistaVentas(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.venta.listaventa', compact('usuario', 'nombre', 'tipo'));
    }

    public function ver_consulta(Request $request)
    {
        // Suponiendo que el id_usuario es proporcionado en la sesión o es parte de la solicitud
        $id_usuario = auth()->id(); // o puedes usar cualquier otro método para obtener el id_usuario

        // Realizar las consultas en la base de datos
        $venta_dia_vendedor = DB::table('venta')
            ->where('vendedor', $id_usuario)
            ->whereDate('created_at', today()) // Cambiar 'fecha' por 'created_at'
            ->sum('total');

        $venta_diaria = DB::table('venta')
            ->whereDate('created_at', today()) // Cambiar 'fecha' por 'created_at'
            ->sum('total');

        $venta_mensual = DB::table('venta')
            ->whereYear('created_at', date('Y')) // Cambiar 'fecha' por 'created_at'
            ->whereMonth('created_at', date('m')) // Cambiar 'fecha' por 'created_at'
            ->sum('total');

        $venta_anual = DB::table('venta')
            ->whereYear('created_at', date('Y')) // Cambiar 'fecha' por 'created_at'
            ->sum('total');

        $costo_mensual = DB::table('detalle_venta')
            ->join('venta', 'detalle_venta.id_det_venta', '=', 'venta.id')
            ->join('lote', 'detalle_venta.id_det_lote', '=', 'lote.id')
            ->whereYear('venta.created_at', date('Y')) // Especificar la tabla 'venta'
            ->whereMonth('venta.created_at', date('m')) // Especificar la tabla 'venta'
            ->sum(DB::raw('det_cantidad * precio_compra'));

        $ganancia_mensual = $venta_mensual - $costo_mensual;

        // Devolver los resultados en formato JSON
        return response()->json([
            'venta_dia_vendedor' => $venta_dia_vendedor,
            'venta_diaria' => $venta_diaria,
            'venta_mensual' => $venta_mensual,
            'venta_anual' => $venta_anual,
            'ganancia_mensual' => $ganancia_mensual,
        ]);
    }
}
