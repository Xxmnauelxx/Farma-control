<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaProducto;
use Auth;
use DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VentaRealizada;
use App\Models\User;

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
                'adicional' => $producto->adicional->nombre ?? 'No disponible',
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
            'pago' => 'required|numeric',
            'vuelto' => 'required|numeric',
            'total' => 'required|numeric',
            'cliente' => 'nullable|string',
            'cliente1' => 'nullable|string',
            'productos' => 'required|array',
        ]);


        $pago = $request->pago;
        $vuelto = $request->vuelto;
        $total = $request->total;
        $cliente = $request->cliente;
        $cliente1 = $request->cliente1;
        $productos = $request->productos;
        $vendedor = auth()->user()->id; // Usuario autenticado

        DB::beginTransaction();

        try {
            // Crear la venta
            $venta = Venta::create([
                'pago' => $pago,
                'vuelto' => $vuelto,
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
        $logoContent = file_get_contents(public_path('img/logo2.png'));
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
            'factura' => $venta->id,
            'pago' => $venta->pago,
            'vuelto' => $venta->vuelto,
            'cliente' => optional($venta->cliente)->nombre ?? 'CLIENTE CONTADO', // Asume que tienes una relación con Cliente
            'total' => $total,
            'productos' => $productos,
            'logo_url' => $logoBase64,
            'nombre_negocio' => 'FARMACIA FARMA-CONTROL',
            'regimen' => 'REGIMEN CUOTA FIJA',
            'ruc' => '123456789',
            'aut' => 'DGI AFC-ARC-SLR-001-09-2025',
            'direccion_negocio' => 'CONTADO',
            'telefono_negocio' => '939-631-427',
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

        // Venta diaria del vendedor con estado 'Facturado'
        $venta_dia_vendedor = DB::table('venta')
            ->where('vendedor', $id_usuario)
            ->whereDate('created_at', today()) // Cambiar 'fecha' por 'created_at'
            ->where('estado', 'Facturado') // Filtrar por el estado 'Facturado'
            ->sum('total');

        // Venta diaria con estado 'Facturado'
        $venta_diaria = DB::table('venta')
            ->whereDate('created_at', today()) // Cambiar 'fecha' por 'created_at'
            ->where('estado', 'Facturado') // Filtrar por el estado 'Facturado'
            ->sum('total');

        // Venta mensual con estado 'Facturado'
        $venta_mensual = DB::table('venta')
            ->whereYear('created_at', date('Y')) // Cambiar 'fecha' por 'created_at'
            ->whereMonth('created_at', date('m')) // Cambiar 'fecha' por 'created_at'
            ->where('estado', 'Facturado') // Filtrar por el estado 'Facturado'
            ->sum('total');

        // Venta anual con estado 'Facturado'
        $venta_anual = DB::table('venta')
            ->whereYear('created_at', date('Y')) // Cambiar 'fecha' por 'created_at'
            ->where('estado', 'Facturado') // Filtrar por el estado 'Facturado'
            ->sum('total');

        $costo_mensual = DB::table('detalle_venta')
            ->join('venta', 'detalle_venta.id_det_venta', '=', 'venta.id')
            ->join('lote', 'detalle_venta.id_det_lote', '=', 'lote.id')
            ->whereYear('venta.created_at', date('Y')) // Especificar la tabla 'venta'
            ->whereMonth('venta.created_at', date('m')) // Especificar la tabla 'venta'
            ->where('venta.estado', 'Facturado') // Filtrar por el estado 'Facturado' en la tabla venta
            ->where('detalle_venta.estado', 'Facturado') // Filtrar por el estado 'Facturado' en la tabla detalle_venta
            ->sum(DB::raw('det_cantidad * precio_compra'));

        // Ganancia mensual solo si la venta es 'Facturado'
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

    public function listar_ventas(Request $request)
    {
        // Obtener las ventas desde la base de datos
        $ventas = Venta::with('cliente', 'usuario') // Asegúrate de que 'cliente' y 'usuario' están definidos correctamente
            ->select('id', 'created_at', 'total', 'vendedor', 'id_cliente', 'estado')
            ->get();

        $data = [];
        foreach ($ventas as $venta) {
            // Procesar cada venta para obtener los datos del cliente y vendedor
            $cliente = $venta->cliente ? $venta->cliente->nombre . ' ' . $venta->cliente->apellidos : 'Sin Cliente';
            $dni = $venta->cliente ? $venta->cliente->dni : 'Sin DNI';
            $estado = $venta->estado;
            $vendedor = $venta->usuario ? $venta->usuario->nombre_us . ' ' . $venta->usuario->apellidos_us : 'Sin Vendedor';

            $data[] = [
                'codigo' => $venta->id,
                'fecha' => $venta->created_at,
                'cliente' => $cliente,
                'dni' => $dni,
                'total' => $venta->total,
                'estado' => $estado,
                'vendedor' => $venta->usuario->name,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function imprimir_venta($id)
    {
        try {
            // Obtener el contenido del logo
            $logoContent = file_get_contents(public_path('img/logo2.png'));
            $bg = file_get_contents(public_path('img/dimension.png'));
            // Convertir el logo a base64
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoContent);
            $bg1 = 'data:image/png;base64,' . base64_encode($bg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo cargar la imagen del logo.');
        }

        $venta = DB::table('venta')
            ->leftJoin('users', 'venta.vendedor', '=', 'users.id') // Unir con la tabla 'users' para obtener el nombre del vendedor
            ->leftJoin('clientes', 'venta.id_cliente', '=', 'clientes.id') // Unir con la tabla 'clientes' para obtener el nombre y el 'dni'
            ->select(
                'venta.id as id',
                'venta.created_at as fecha',
                DB::raw('IFNULL(clientes.nombre, "Cliente no registrado") as cliente'), // Si no hay cliente, muestra "Cliente no registrado"
                'venta.id_cliente',
                DB::raw('IFNULL(clientes.dni, "") as dni'), // Si no hay cliente, no muestra DNI
                'venta.total',
                'venta.estado', // Añadir el estado de la venta
                DB::raw('CONCAT(users.name) as vendedor'), // Concatenar el nombre del vendedor
            )
            ->where('venta.id', $id)
            ->first();

        // Consulta de los productos relacionados a esta venta
        $productos = DB::table('venta_producto')
            ->join('productos', 'venta_producto.id_producto', '=', 'productos.id')
            ->join('laboratorios', 'productos.id_lab', '=', 'laboratorios.id')
            ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id')
            ->join('adicionales', 'productos.id_adicional', '=', 'adicionales.id')
            ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id')
            ->select(
                'venta_producto.precio',
                'venta_producto.cantidad',
                'productos.nombre as producto',
                'productos.concentracion',
                'adicionales.nombre as adicional',
                'laboratorios.nombre as laboratorio',
                'presentaciones.nombre as presentacion',
                'tipos_productos.nombre as tipo',
                'venta_producto.subtotal'
            )->where('venta_producto.id_venta', $id)->get();


        $total = $venta->total; // Aquí obtienes directamente el total de la venta

        // Calcular IGV (15%)
        $igv = $total * 0.15;

        // Total con IGV
        $totalConIgv = $total + $igv;

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
        $pdf = view('admin.report.venta', compact('logoBase64', 'venta', 'productos', 'bg1', 'total', 'igv', 'totalConIgv'))->render(); // Agregado ->render() para obtener el HTML

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($pdf);

        // Configurar el tamaño del papel y la orientación
        $dompdf->setPaper('letter', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Enviar el PDF como respuesta que se abre en el navegador
        return $dompdf->stream("Venta_{$id}.pdf", [
            'Attachment' => 0, // Esto asegura que el PDF se abre en el navegador y no se descarga
        ]);
    }

    public function ver_venta($id)
    {
        $venta = DB::table('venta')
            ->leftJoin('users', 'venta.vendedor', '=', 'users.id') // Unir con la tabla 'users' para obtener el nombre del vendedor
            ->leftJoin('clientes', 'venta.id_cliente', '=', 'clientes.id') // Unir con la tabla 'clientes' para obtener el nombre y el 'dni'
            ->select(
                'venta.id as id',
                'venta.created_at as fecha',
                DB::raw('IFNULL(clientes.nombre, "Cliente no registrado") as cliente'), // Si no hay cliente, muestra "Cliente no registrado"
                'venta.id_cliente',
                DB::raw('IFNULL(clientes.dni, "") as dni'), // Si no hay cliente, no muestra DNI
                'venta.total',
                DB::raw('CONCAT(users.name) as vendedor'), // Concatenar el nombre del vendedor
            )
            ->where('venta.id', $id)
            ->first();

        // Consulta de los productos relacionados a esta venta
        $productos = DB::table('venta_producto')
            ->join('productos', 'venta_producto.id_producto', '=', 'productos.id')
            ->join('laboratorios', 'productos.id_lab', '=', 'laboratorios.id')
            ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id')
            ->join('adicionales', 'productos.id_adicional', '=', 'adicionales.id')
            ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id')
            ->select(
                'venta_producto.precio',
                'venta_producto.cantidad',
                'productos.nombre as producto',
                'productos.concentracion',
                'adicionales.nombre as adicional',
                'laboratorios.nombre as laboratorio',
                'presentaciones.nombre as presentacion',
                'tipos_productos.nombre as tipo',
                'venta_producto.subtotal'
            )->where('venta_producto.id_venta', $id)->get();

        // Preparar la respuesta
        return response()->json([
            'venta' => $venta,
            'detalles' => $productos,
        ]);
    }

    public function borrar_venta($id)
    {
        // Obtener el ID del usuario autenticado
        $id_usuario = auth()->user()->id;
        $tipo_usuario = auth()->user()->id_tipo; // Asegurar que este campo existe en la base de datos

        // Iniciar una transacción en la base de datos
        DB::beginTransaction();

        try {
            // Si el usuario es Root (tipo_usuario = 1), puede cancelar cualquier venta
            if ($tipo_usuario == 1) {
                $this->procesarCancelacion($id);
            }
            // Si el usuario es Supervisor (tipo_usuario = 3)
            elseif ($tipo_usuario == 3) {
                // Obtener la venta junto con los datos del usuario que la realizó
                $venta = Venta::where('id', $id)->with('usuario')->first();

                // Si la venta existe y fue realizada por un Farmacéutico (tipo_usuario = 2)
                if ($venta && $venta->usuario->id_tipo == 2) {
                    $this->procesarCancelacion($id);
                } else {
                    return response()->json(
                        [
                            'status' => 'nodeltete',
                            'message' => 'No tienes permisos para cancelar esta venta',
                        ],
                        403,
                    );
                }
            }
            // Si el usuario es Farmacéutico (tipo_usuario = 2) u otro, no puede cancelar ventas
            else {
                return response()->json(
                    [
                        'status' => 'nodeltete',
                        'message' => 'No tienes permisos para cancelar esta venta',
                    ],
                    403,
                );
            }

            // Confirmar la transacción si todo salió bien
            DB::commit();

            return response()->json([
                'status' => 'cancelled',
                'message' => 'Venta cancelada y stock restaurado correctamente.',
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error, deshacer los cambios en la base de datos
            DB::rollBack();

            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    private function procesarCancelacion($id)
    {
        // Obtener la venta y sus detalles
        $venta = Venta::findOrFail($id);
        $detalles = DetalleVenta::where('id_det_venta', $id)->get();

        foreach ($detalles as $detalle) {
            // Verificar si el lote existe antes de actualizarlo
            $lote = Lote::find($detalle->id_det_lote);

            if ($lote) {
                // Incrementar la cantidad en el lote
                $lote->increment('cantidad_lote', $detalle->det_cantidad);

                // Asegurar que el lote no esté en estado inactivo o vencido
                if ($lote->estado !== 'Activo') {
                    $lote->update(['estado' => 'Activo']); // Reactivar el lote si estaba inactivo
                }
            } else {
                \Log::error("Lote no encontrado para el detalle de venta ID: {$detalle->id}");
            }

            // Marcar el detalle de venta como cancelado
            $detalle->update(['estado' => 'cancelado']);
        }

        // Marcar la venta como cancelada
        $venta->update(['estado' => 'cancelado']);
    }

    public function mas_consulta(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.venta.consulta', compact('usuario', 'nombre', 'tipo'));
    }

    public function vendedorMes()
    {
        $vendedores = Venta::selectRaw('CONCAT(users.name) AS vendedor_nombre, SUM(total) AS cantidad')
            ->join('users', 'venta.vendedor', '=', 'users.id') // Unimos con la tabla `users`
            ->whereMonth('venta.created_at', date('m')) // Filtramos por el mes actual
            ->whereYear('venta.created_at', date('Y')) // Filtramos por el año actual
            ->where('venta.estado', 'Facturado') // Filtra solo las ventas facturadas
            ->groupBy('venta.vendedor')
            ->orderByDesc('cantidad')
            ->limit(3)
            ->get();

        return response()->json($vendedores);
    }

    public function venta_mes()
    {
        $ventas = Venta::selectRaw('MONTH(created_at) as mes, SUM(total) as cantidad')
            ->whereYear('created_at', date('Y'))
            ->where('estado', 'Facturado') // Filtra solo las ventas facturadas
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json($ventas);
    }

    public function ventas_anual()
    {
        // Año actual
        $ventasActual = DB::table('venta')
            ->selectRaw('MONTH(created_at) as mes, SUM(total) AS cantidad')
            ->whereYear('created_at', now()->year) // Filtra el año actual
            ->where('estado', 'Facturado') // Solo ventas facturadas
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Año anterior
        $ventasAnterior = DB::table('venta')
            ->selectRaw('MONTH(created_at) as mes, SUM(total) AS cantidad')
            ->whereYear('created_at', now()->subYear()->year) // Filtra el año anterior
            ->where('estado', 'Facturado')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Retornar ambos conjuntos de datos en un solo JSON
        return response()->json([
            'actual' => $ventasActual,
            'anterior' => $ventasAnterior,
        ]);
    }

    public function producto_mas_vendido()
    {
        $productos = DB::table('venta')
            ->join('venta_producto', 'venta.id', '=', 'venta_producto.id_venta')
            ->join('productos', 'productos.id', '=', 'venta_producto.id_producto')
            ->select(
                'productos.nombre',
                'productos.concentracion',
                'productos.adicional',
                DB::raw('SUM(venta_producto.cantidad) as total')
            )
            ->whereYear('venta.created_at', DB::raw('YEAR(CURDATE())')) // Usando created_at
            ->whereMonth('venta.created_at', DB::raw('MONTH(CURDATE())')) // Usando created_at
            ->groupBy('venta_producto.id_producto')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json($productos);
    }

    public function cliente_mes()
    {
        $clientes = DB::table('venta')
            ->join('clientes', 'clientes.id', '=', 'venta.id_cliente')
            ->select(
                DB::raw("CONCAT(clientes.nombre, ' ', clientes.apellidos) AS cliente_nombre"),
                DB::raw('SUM(venta.total) AS cantidad')
            )
            ->whereYear('venta.created_at', DB::raw('YEAR(CURDATE())'))
            ->whereMonth('venta.created_at', DB::raw('MONTH(CURDATE())'))
            ->groupBy('clientes.id')
            ->orderByDesc('cantidad')
            ->limit(3)
            ->get();

        return response()->json($clientes);
    }



    //crear parte de venta separado a un modulo

    public function crear_venta()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }
        return view('admin.venta.crear_venta', compact('nombre', 'tipo', 'usuario'));
    }
}
