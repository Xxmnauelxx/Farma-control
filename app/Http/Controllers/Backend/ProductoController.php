<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Adicional;
use App\Models\Laboratorio;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Models\Tipo;
use App\Models\TipoProducto;
use Auth;
use DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use File;
use Illuminate\Http\Request;
use Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductosExport;

class ProductoController extends Controller
{
    // Función que muestra la vista para la gestión de productos
    public function vistaproducto()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Obtiene todos los registros de los modelos relacionados
        $tipospr = TipoProducto::all(); // Modelos de tipos de productos
        $laboratorios = Laboratorio::all(); // Modelos de laboratorios
        $presentaciones = Presentacion::all(); // Modelos de presentaciones
        $adiconal = Adicional::all();

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.productos.index', compact('usuario', 'nombre', 'tipo', 'tipospr', 'laboratorios', 'presentaciones', 'adiconal'));
    }

    // Función que maneja la creación de nuevos productos
    public function crear_productos(Request $request)
    {
        // Valida los datos que se envían en el formulario
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'concentracion' => 'nullable|string|max:255',
            'adicional' => 'nullable|string|max:255',
            'precio' => 'required|numeric',
            'laboratorio' => 'required|integer|exists:laboratorios,id',
            'id_adicional' => 'required|integer|exists:adicionales,id',
            'tipo' => 'required|integer|exists:tipos,id',
            'presentacion' => 'required|integer|exists:presentaciones,id',
        ]);

        // Verifica si ya existe un producto con el mismo nombre, laboratorio, tipo y presentación
        $productoExistente = Producto::where('nombre', $validatedData['nombre_producto'])
            ->where('id_lab', $validatedData['laboratorio'])
            ->where('id_tip_prod', $validatedData['tipo'])
            ->where('id_present', $validatedData['presentacion'])
            ->first();

        // Si el producto ya existe, devuelve un error
        if ($productoExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya existe un producto con el mismo nombre, laboratorio, tipo y presentación.',
            ], 400);
        }

        // Si no existe el producto, lo crea
        $producto = new Producto();
        $producto->nombre = $validatedData['nombre_producto'];
        $producto->concentracion = $validatedData['concentracion'];
        $producto->id_adicional = $validatedData['id_adicional'];
        $producto->precio = $validatedData['precio'];
        $producto->id_lab = $validatedData['laboratorio'];
        $producto->id_tip_prod = $validatedData['tipo'];
        $producto->id_present = $validatedData['presentacion'];

        // Guarda el nuevo producto en la base de datos
        $producto->save();

        // Retorna una respuesta exitosa en formato JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Producto creado correctamente',
        ]);
    }

    // Función para buscar productos según una consulta
    public function buscar_productos(Request $request)
    {
        // Obtiene el valor de la consulta enviada en la solicitud
        $consulta = $request->input('consulta');

        // Prepara la consulta para buscar productos activos
        $query = Producto::with(['laboratorio', 'tipoProducto', 'presentacion', 'adicional'])
            ->where('estado', 'Activo'); // Solo productos activos

        //dd($query);

        // Si se proporcionó una consulta, filtra los productos por nombre
        if (!empty($consulta)) {
            $query->where('nombre', 'like', '%' . $consulta . '%');
        } else {
            // Si no se proporciona consulta, ordena por nombre
            $query->orderBy('nombre');
        }

        // Limita los resultados a 25 productos
        $productos = $query->limit(25)->get();

        // Mapea los resultados para que la respuesta sea más fácil de usar en el frontend
        $productosResponse = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'concentracion' => $producto->concentracion,
                'precio' => $producto->precio,
                'stock' => $producto->obtenerStock() > 0 ? $producto->obtenerStock() : 'Sin lotes',  // Asegúrate de que haya un campo de stock en el modelo
                'laboratorio' => $producto->laboratorio->nombre,  // Accede al nombre del laboratorio
                'adicional' => $producto->adicional?->nombre ?? 'Sin asignar',  // Accede al nombre del laboratorio
                'adicional_id' => $producto->id_adicional,  // Accede al nombre del laboratorio
                'tipo' => $producto->tipoProducto->nombre,  // Accede al nombre del tipo de producto
                'presentacion' => $producto->presentacion->nombre,  // Accede al nombre de la presentación
                'laboratorio_id' => $producto->id_lab,
                'tipo_id' => $producto->id_tip_prod,
                'presentacion_id' => $producto->id_present,
                'avatar' => $producto->avatar && file_exists(public_path('storage/producto/' . $producto->avatar))
                    ? asset('storage/producto/' . $producto->avatar)
                    : asset('img/producto_default.jpeg'),

            ];
        });

        // Devuelve la respuesta en formato JSON con los productos encontrados
        return response()->json($productosResponse);
    }

    public function cambiar_avatar(Request $request)
    {
        // Validar el archivo
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el producto
        $producto = Producto::find($request->input('id-logo-prod'));

        if ($producto) {
            // Guardar la nueva imagen
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = 'producto/' . $filename; // Ruta donde se almacenará la imagen

                // Verificar que el directorio exista y crearlo si no existe
                $directory = storage_path('app/public/producto');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Crear el directorio si no existe
                }

                // Elimina la imagen antigua si existe
                if ($producto->avatar) {
                    Storage::delete('public/producto/' . $producto->avatar);
                }

                // Guardar la nueva imagen en el directorio 'producto' dentro de 'storage/app/public'
                $file->storeAs('public/producto', $filename);

                // Actualizar el campo 'avatar' en la base de datos
                $producto->avatar = $filename;
                $producto->save();

                // Retornar una respuesta JSON con la nueva ruta de la imagen
                return response()->json([
                    'alert' => 'edit',
                    'ruta' => asset('storage/producto/' . $filename),
                ]);
            }
        }

        // Retornar un error si el producto no se encuentra
        return response()->json([
            'alert' => 'error',
        ], 400);
    }

    public function editar_productos(Request $request)
    {
        $producto = Producto::find($request->id_edit_prod);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        $producto->update([
            'nombre' => $request->edit_nombre,
            'concentracion' => $request->edit_concentracion,
            'id_adicional' => $request->edit_adicional,
            'precio' => $request->edit_precio,
            'id_lab' => $request->edit_laboratorio,
            'id_tip_prod' => $request->edit_tipo,
            'id_present' => $request->edit_presentacion,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado correctamente.',
        ]);
    }

    public function eliminar_producto($id)
    {
        // Verificar si el producto tiene lotes activos
        $lotesActivos = DB::table('lote')
            ->where('id_producto', $id)
            ->where('estado', 'Activo')
            ->exists(); // Retorna true si hay lotes activos

        if ($lotesActivos) {
            // Si hay lotes activos, no se puede borrar
            return response()->json('noborrado');
        }

        // Actualizar el estado del producto a 'I'
        $actualizado = DB::table('productos')
            ->where('id', $id)
            ->update(['estado' => 'Inactivo']);

        if ($actualizado) {
            return response()->json('borrado');
        }

        return response()->json('noborrado');
    }

    public function reporte_productos_pdf(Request $request)
    {
        try {
            // Obtener el contenido del logo
            $logoContent = file_get_contents(public_path('img/logo.jpg'));
            $bg = file_get_contents(public_path('img/dimension.png'));
            // Convertir el logo a base64
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoContent);
            $bg1 = 'data:image/png;base64,' . base64_encode($bg);

            // Consulta para obtener productos con su stock
            $productos = DB::table('productos as p')
                ->join('laboratorios as l', 'p.id_lab', '=', 'l.id')
                ->join('tipos_productos as tp', 'p.id_tip_prod', '=', 'tp.id')
                ->join('presentaciones as pr', 'p.id_present', '=', 'pr.id')
                ->leftJoin('lote as lo', function ($join) {
                    $join->on('p.id', '=', 'lo.id_producto')
                        ->where('lo.estado', '=', 'Activo'); // Solo lotes activos
                })
                ->select(
                    'p.id',
                    'p.nombre',
                    'p.concentracion',
                    'p.adicional',
                    'p.precio',
                    'l.nombre as laboratorio',
                    'tp.nombre as tipo',
                    'pr.nombre as presentacion',
                    'p.avatar',
                    DB::raw('COALESCE(SUM(lo.cantidad_lote), 0) as stock') // Obtiene el stock
                )
                ->groupBy(
                    'p.id',
                    'p.nombre',
                    'p.concentracion',
                    'p.adicional',
                    'p.precio',
                    'l.nombre',
                    'tp.nombre',
                    'pr.nombre',
                    'p.avatar'
                )
                ->orderBy('p.nombre', 'ASC')
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
            $pdf = view('admin.report.productos', compact('logoBase64', 'bg1', 'productos'))->render(); // Agregado ->render() para obtener el HTML

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($pdf);

            // Configurar el tamaño del papel y la orientación
            $dompdf->setPaper('letter', 'portrait');

            // Renderizar el PDF
            $dompdf->render();

            // Enviar el PDF como respuesta que se abre en el navegador
            return $dompdf->stream('Reporte.pdf', [
                'Attachment' => 0, // Esto asegura que el PDF se abre en el navegador y no se descarga
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reporte_productos_excel(Request $request)
    {
        return Excel::download(new ProductosExport, 'reporte_productos.xlsx');
    }
}
