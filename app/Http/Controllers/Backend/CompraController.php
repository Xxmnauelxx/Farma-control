<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Estado;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompraRealizada;

class CompraController extends Controller
{
    public function vista_compra()
    {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Ejecutar la consulta SQL
        $compras = DB::table('compras as c')->select(DB::raw("CONCAT(c.id, ' | ', c.codigo) as codigo"), 'c.id', 'c.fecha_compra', 'c.fecha_entrega', 'c.total', 'e.nombre as estado', 'p.nombre as proveedor')->join('estado_pago as e', 'e.id', '=', 'c.id_estado_pago')->join('proveedores as p', 'p.id', '=', 'c.id_proveedor')->get();

        $estado = Estado::all();
        //  dd($compras);

        return view('admin.compra.index', compact('usuario', 'nombre', 'tipo', 'compras', 'estado'));
    }

    public function llenar_producto()
    {
        // Paso 1: Obtener productos con sus relaciones
        // Usamos el modelo Producto y cargamos las relaciones: laboratorio, tipoProducto, presentacion
        // Solo traemos los productos cuyo estado sea 'Activo' y los ordenamos alfabéticamente por nombre
        $productos = Producto::with(['laboratorio', 'tipoProducto', 'presentacion'])
            ->where('estado', 'Activo') // Filtramos por el estado 'Activo'
            ->orderBy('nombre', 'ASC') // Ordenamos los productos alfabéticamente por el nombre
            ->get(); // Ejecutamos la consulta y obtenemos los resultados

        // Paso 2: Crear un array para almacenar los datos formateados
        // Inicializamos un array vacío donde vamos a almacenar los productos formateados
        $json = [];

        // Paso 3: Recorrer los productos y formatear los datos
        // Usamos un ciclo foreach para recorrer cada producto
        foreach ($productos as $producto) {
            // En cada iteración, formateamos los datos de cada producto
            // Concatenamos los datos necesarios con el separador ' | ' y lo agregamos al array $json
            $json[] = [
                'nombre' => $producto->id.
                    ' | '. // ID del producto
                    $producto->nombre.
                    ' | '. // Nombre del producto
                    $producto->concentracion.
                    ' | '. // Concentración del producto
                    $producto->adicional.
                    ' | '. // Información adicional
                    $producto->laboratorio->nombre.
                    ' | '. // Nombre del laboratorio (relación)
                    $producto->presentacion->nombre, // Nombre de la presentación (relación)
            ];
        }

        // Paso 4: Retornar los datos como respuesta JSON
        // Finalmente, devolvemos el array $json como respuesta en formato JSON
        return response()->json($json);
    }

    public function rellenar_estados()
    {
        // Obtener los estados de pago
        $estados = Estado::all(); // O la lógica que uses para obtener los estados

        // Devolver los estados como respuesta JSON
        return response()->json($estados);
    }

    public function rellenar_proveedores()
    {
        // Obtener todos los proveedores
        $proveedores = Proveedor::all(); // O la lógica que uses para obtener los proveedores

        // Devolver los proveedores como respuesta JSON
        return response()->json($proveedores);
    }

    public function crear_compra(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'productosString' => 'required|string',
            'descripcionString' => 'required|string',
        ]);

        // Decodificar los productos y la descripción
        $descripcion = json_decode($request->descripcionString);
        $productos = json_decode($request->productosString);

        // Crear la compra
        $compra = Compra::create([
            'codigo' => $descripcion->codigo,
            'fecha_compra' => $descripcion->fecha_compra,
            'fecha_entrega' => $descripcion->fecha_entrega,
            'total' => $descripcion->total,
            'id_estado_pago' => $descripcion->estado,
            'id_proveedor' => $descripcion->proveedor,
        ]);

        // Obtener el ID de la última compra
        $id_compra = $compra->id;

        // Insertar los lotes relacionados con los productos
        foreach ($productos as $prod) {
            Lote::create([
                'codigo' => $prod->codigo,
                'cantidad' => $prod->cantidad,
                'cantidad_lote' => $prod->cantidad,
                'vencimiento' => $prod->vencimiento,
                'precio_compra' => $prod->precioCompra,
                'id_compra' => $id_compra,
                'id_producto' => $prod->id,
            ]);
        }



        return response()->json('add');
    }

    public function extraer_lote_compra($id)
    {
        // Obtener la compra con los lotes relacionados
        $compra = Compra::with('lotes.producto')->find($id);

        if (! $compra) {
            return response()->json(['success' => false]);
        }

        // Recopilar los detalles de la compra
        $compra_data = [
            'codigo' => $compra->codigo,
            'fecha_compra' => $compra->fecha_compra,
            'fecha_entrega' => $compra->fecha_entrega,
            'estado' => $compra->estadoPago->nombre,
            'proveedor' => $compra->proveedor->nombre,
            'total' => $compra->total,
        ];

        // Recopilar los detalles de los lotes y productos
        $lotes_data = [];
        foreach ($compra->lotes as $lote) {
            $lotes_data[] = [
                'codigo' => $lote->codigo,
                'cantidad' => $lote->cantidad,
                'vencimiento' => $lote->vencimiento,
                'precio_compra' => $lote->precio_compra,
                'producto' => $lote->producto->nombre, // Relacionado con producto
                'laboratorio' => $lote->producto->laboratorio,
                'presentacion' => $lote->producto->presentacion,
                'tipo' => $lote->producto->tipoProducto,
            ];
        }

        return response()->json([
            'success' => true,
            'compra' => $compra_data,
            'lotes' => $lotes_data,
        ]);
    }

    public function extraer_estados($id)
    {
        $compra = Compra::find($id); // Buscar la compra por ID

        if ($compra) {
            return response()->json([
                'success' => true,
                'estado' => $compra->id_estado_pago, // Enviar estado como respuesta JSON
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function cambiarEstado(Request $request)
    {
        // ✅ Paso 1: Validar los datos recibidos del formulario
        // Se asegura de que el campo 'estado_edit' esté presente y no esté vacío.
        // Esto evita errores si el usuario envía el formulario sin seleccionar un estado.
        $request->validate([
            'estado_edit' => 'required', // Se podría agregar 'exists:estados,id' para validar si existe en la BD.
        ]);

        // ✅ Paso 2: Buscar el registro en la base de datos
        // Se busca en la tabla `compras` el registro cuyo `id` coincida con el que se envió desde el formulario.
        // Esto es clave porque solo podemos actualizar el estado de un registro existente.
        $registro = compra::find($request->id);

        // ✅ Paso 3: Verificar si el registro existe
        // Si no se encuentra el registro en la base de datos, se devuelve un mensaje de error
        // y se redirige a la misma página sin realizar cambios.
        if (! $registro) {
            return back()->with('error', 'Registro no encontrado.');
        }

        // ✅ Paso 4: Actualizar el estado del registro
        // Se asigna el nuevo estado seleccionado en el formulario al campo `id_estado_pago`
        // que representa el estado de la compra en la base de datos.
        $registro->id_estado_pago = $request->estado_edit;

        // ✅ Paso 5: Guardar los cambios en la base de datos
        // Luego de modificar el estado, se guarda el registro actualizado.
        $registro->save();

        // ✅ Paso 6: Redirigir con un mensaje de éxito
        // Si todo el proceso se ejecutó correctamente, se redirige de nuevo a la página anterior
        // con un mensaje de éxito que indica que el estado fue actualizado correctamente.
        return back()->with('success', 'Estado actualizado correctamente.');
    }

    public function imprimir_compra($id)
    {

        try {
            // Obtener el contenido del logo
            $logoContent = file_get_contents(public_path('img/logo2.png'));
            $bg = file_get_contents(public_path('img/dimension.png'));
            // Convertir el logo a base64
            $logoBase64 = 'data:image/jpeg;base64,'.base64_encode($logoContent);
            $bg1 = 'data:image/png;base64,'.base64_encode($bg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo cargar la imagen del logo.');
        }

        // Obtener los datos de la compra
        $compra = Compra::selectRaw("
                CONCAT(compras.id, ' | ', compras.codigo) as codigo,
                compras.fecha_compra,
                compras.fecha_entrega,
                compras.total,
                estado_pago.nombre as estado,
                proveedores.nombre as proveedor,
                proveedores.telefono,
                proveedores.correo,
                proveedores.direccion,
                proveedores.avatar
            ")
            ->join('estado_pago', 'estado_pago.id', '=', 'compras.id_estado_pago')
            ->join('proveedores', 'proveedores.id', '=', 'compras.id_proveedor')
            ->where('compras.id', $id)
            ->firstOrFail();

        // Si no se encuentra la compra, retornar error
        if (! $compra) {
            return response()->json(['error' => 'Compra no encontrada'], 404);
        }

        // Obtener los lotes de la compra
        $lotes = Lote::where('id_compra', $id)
            ->join('productos', 'lote.id_producto', '=', 'productos.id')
            ->join('laboratorios', 'productos.id_lab', '=', 'laboratorios.id')
            ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id')
            ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id')
            ->select([
                'lote.codigo',
                'lote.cantidad',
                'lote.vencimiento',
                'lote.precio_compra',
                'productos.nombre as producto',
                'productos.concentracion',
                'productos.adicional',
                'laboratorios.nombre as laboratorio',
                'tipos_productos.nombre as tipo',
                'presentaciones.nombre as presentacion',
            ])
            ->get();

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
        $pdf = view('admin.report.compra', compact(
            'logoBase64',
            'compra',
            'lotes',
            'bg1'
            // 'nombreUsuario',
            // 'nombreServidor',
            // 'fechaYHora'
        ))->render();  // Agregado ->render() para obtener el HTML

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($pdf);

        // Configurar el tamaño del papel y la orientación
        $dompdf->setPaper('letter', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Enviar el PDF como respuesta que se abre en el navegador
        return $dompdf->stream('compra.pdf', [
            'Attachment' => 0,  // Esto asegura que el PDF se abre en el navegador y no se descarga
        ]);

    }
}
