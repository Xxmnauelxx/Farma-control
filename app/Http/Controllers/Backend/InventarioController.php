<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;
use Auth;
use DB;
use File;
use Storage;
use Carbon\Carbon;

class InventarioController extends Controller
{
    // Función que muestra la vista para la gestión de productos
    public function vistainventario()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene información del usuario autenticado
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $tipo = $usuario->tipo->nombre;
        }

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.inventario.index', compact('usuario', 'nombre', 'tipo'));
    }

    // Función para buscar productos según una consulta
    public function buscar_lotes(Request $request)
    {
        // Obtener la consulta enviada desde el frontend, si no hay consulta, se usa una cadena vacía
        $consulta = $request->input('consulta', '');

        // Obtener la fecha actual con la zona horaria de Managua
        $fecha_actual = Carbon::now('America/Managua');

        // Realizamos la consulta a la base de datos utilizando Query Builder
        $lotes = DB::table('lote as l') // Se trabaja con la tabla "lote", alias "l"
            ->join('compras', 'l.id_compra', '=', 'compras.id') // Se une con la tabla "compras" para obtener la compra de cada lote
            ->join('proveedores', 'proveedores.id', '=', 'compras.id_proveedor') // Se une con la tabla "proveedores" para obtener los datos del proveedor
            ->join('productos', 'productos.id', '=', 'l.id_producto') // Se une con la tabla "productos" para obtener información del producto
            ->join('laboratorios', 'productos.id_lab', '=', 'laboratorios.id') // Se une con la tabla "laboratorios" para obtener el nombre del laboratorio
            ->join('adicionales', 'productos.id_adicional', '=', 'adicionales.id') // Se une con la tabla "laboratorios" para obtener el nombre del laboratorio
            ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id') // Se une con la tabla "tipos_productos" para obtener el tipo de producto
            ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id') // Se une con la tabla "presentaciones" para obtener la presentación del producto
            ->join('medidas', 'l.id_unidad', '=', 'medidas.id') // Se une con la tabla "presentaciones" para obtener la presentación del producto
            ->select(
                'l.id as id_lote', // Se selecciona el ID del lote
                DB::raw("CONCAT(l.id, ' | ', l.codigo) as codigo"), // Se concatena el ID y el código del lote
                'l.cantidad_lote', // Se selecciona la cantidad de productos en el lote
                'l.vencimiento', // Se selecciona la fecha de vencimiento del lote
                'productos.concentracion', // Se selecciona la concentración del producto
                'adicionales.nombre as adicional', // Se selecciona información adicional del producto
                'productos.nombre as prod_nom', // Se selecciona el nombre del producto
                'laboratorios.nombre as lab_nom', // Se selecciona el nombre del laboratorio
                'tipos_productos.nombre as tip_nom', // Se selecciona el tipo de producto
                'presentaciones.nombre as pre_nom', // Se selecciona la presentación del producto
                'proveedores.nombre as proveedor', // Se selecciona el nombre del proveedor
                'productos.avatar as logo', // Se selecciona la imagen del producto
                'medidas.nombre as unidad'
            )
            ->where('l.estado', 'Activo') // Se filtran solo los lotes con estado "Activo"
            ->when(!empty($consulta), function ($query) use ($consulta) {
                return $query->where('productos.nombre', 'LIKE', "%$consulta%"); // Si hay una consulta, se filtra por el nombre del producto
            })
            ->orderBy('productos.nombre') // Se ordenan los resultados por el nombre del producto
            ->limit(25) // Se limita la consulta a 25 resultados
            ->get(); // Se ejecuta la consulta y se obtienen los resultados

        //dd($lotes);

        // Se inicializa un array vacío para almacenar los lotes en formato JSON
        $json = [];

        // Se recorren los resultados de la consulta
        foreach ($lotes as $lote) {
            // Se obtiene la fecha de vencimiento del lote y se convierte en un objeto Carbon
            $vencimiento = Carbon::parse($lote->vencimiento);

            // Se calcula la diferencia entre la fecha actual y la fecha de vencimiento
            $diferencia = $vencimiento->diff($fecha_actual);

            // Se extraen los valores de la diferencia en años, meses, días y horas
            $anio = $diferencia->y;
            $mes = $diferencia->m;
            $dia = $diferencia->d;
            $hora = $diferencia->h;

            // Se verifica si el lote ya venció (invert = 1 significa que la fecha de vencimiento es menor a la actual)
            $verificado = $diferencia->invert;

            // Se establece un estado por defecto como "success" (verde - sin problemas)
            $estado = 'success';

            // Si el lote ya venció, se cambia el estado a "danger" (rojo - vencido)
            if ($verificado == 0) {
                $estado = 'danger';

                // Se convierten los valores en negativos para indicar el tiempo vencido
                $anio *= -1;
                $mes *= -1;
                $dia *= -1;
                $hora *= -1;
            }
            // Si faltan 3 meses o menos para vencer y el año es el mismo, se marca como "warning" (amarillo - próximo a vencer)
            elseif ($mes <= 3 && $anio == 0) {
                $estado = 'warning';
            }

            // Se construye el array de respuesta con la información del lote
            $json[] = [
                'id' => $lote->id_lote, // ID del lote
                'codigo' => $lote->codigo, // Código del lote
                'nombre' => $lote->prod_nom, // Nombre del producto
                'concentracion' => $lote->concentracion, // Concentración del producto
                'adicional' => $lote->adicional ?? 'Sin asignar', // Información adicional
                'vencimiento' => $lote->vencimiento, // Fecha de vencimiento
                'proveedor' => $lote->proveedor, // Proveedor del producto
                'stock' => $lote->cantidad_lote, // Cantidad disponible en el lote
                'laboratorio' => $lote->lab_nom, // Laboratorio del producto
                'tipo' => $lote->tip_nom, // Tipo del producto
                'presentacion' => $lote->pre_nom, // Presentación del producto
                'unidad'=>$lote->unidad,
                'avatar' =>
                    $lote->logo && file_exists(public_path('storage/producto/' . $lote->logo))
                        ? asset('storage/producto/' . $lote->logo) // Se usa la imagen del producto si existe en el almacenamiento
                        : asset('img/producto_default.jpeg'), // Si no hay imagen, se usa una imagen por defecto
                'anio' => $anio, // Años restantes o vencidos
                'mes' => $mes, // Meses restantes o vencidos
                'dia' => $dia, // Días restantes o vencidos
                'hora' => $hora, // Horas restantes o vencidas
                'estado' => $estado, // Estado del lote (success, warning, danger)
                'invert' => $verificado, // Indica si el lote ya venció
            ];

            //dd($json);
        }

        // Se devuelve la respuesta en formato JSON para que el frontend la procese
        return response()->json($json);
    }

    public function agregar_stock(Request $request)
    {
        //dd($request->all());
        // Validar los datos del formulario
        $request->validate([
            'id_lote_prod' => 'required',
            'stock' => 'required|integer|min:1',
        ]);

        // Obtener el lote desde la base de datos
        $lote = Lote::find($request->id_lote_prod);

        // Aumentar el stock con la cantidad ingresada
        $lote->cantidad_lote += $request->stock;
        $lote->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Stock agregado correctamente.');
    }

    public function borrar_lote($id)
    {
        // Obtener el lote desde la base de datos
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json('noborrado'); // Lote no encontrado
        }

        // Cambiar el estado a "I" (Inactivo)
        $lote->estado = 'Inactivo';
        $resultado = $lote->save(); // Guarda los cambios

        // Retornar respuesta según el resultado
        return response()->json($resultado ? 'borrado' : 'noborrado');
    }

    public function lotes_riesgo()
    {
        // Obtener la fecha actual con la zona horaria de Managua
        $fecha_actual = Carbon::now('America/Managua');

        // Obtener los lotes que tienen vencimiento y están activos
        $lotes = Lote::with(['producto', 'producto.laboratorio', 'producto.tipoProducto', 'producto.presentacion', 'compra.proveedor'])
            ->where('estado', 'Activo') // Solo lotes activos
            ->get();

        //dd($lotes);
        // Inicializar el arreglo que almacenará los lotes en riesgo
        $json = [];

        // Iterar sobre cada lote
        foreach ($lotes as $lote) {
            // Verificar si el lote tiene fecha de vencimiento
            if ($lote->vencimiento) {
                // Convertir la fecha de vencimiento en un objeto Carbon
                $vencimiento = Carbon::parse($lote->vencimiento);
                // Calcular la diferencia entre la fecha actual y la fecha de vencimiento
                $diferencia = $vencimiento->diff($fecha_actual);

                // Obtener años, meses, días y horas de la diferencia
                $anio = $diferencia->y;
                $mes = $diferencia->m;
                $dia = $diferencia->d;
                $hora = $diferencia->h;

                // Determinar si el lote ya venció (invert = 1 significa que la fecha de vencimiento es menor a la actual)
                $verificado = $diferencia->invert;

                // Establecer el estado por defecto
                $estado = 'ligth';

                // Cambiar el estado si el lote ya venció
                if ($verificado == 0) {
                    $estado = 'danger';
                    $anio = $anio * -1;
                    $mes = $mes * -1;
                    $dia = $dia * -1;
                    $hora = $hora * -1;
                } elseif ($mes <= 3 && $anio == 0) {
                    $estado = 'warning';
                }

                // Solo agregar los lotes con estado 'danger' o 'warning' al arreglo de resultados
                if ($estado == 'danger' || $estado == 'warning') {
                    $json[] = [
                        'id' => $lote->id, // ID del lote
                        'nombre' => $lote->producto->nombre, // Nombre del producto
                        'concentracion' => $lote->producto->concentracion, // Concentración del producto
                        'adicional' => $lote->producto->adicional, // Información adicional del producto
                        'vencimiento' => $lote->vencimiento, // Fecha de vencimiento
                        'proveedor' => $lote->compra->proveedor->nombre, // Nombre del proveedor
                        'stock' => $lote->cantidad_lote, // Cantidad disponible en el lote
                        'laboratorio' => $lote->producto->laboratorio->nombre, // Nombre del laboratorio
                        'tipo' => $lote->producto->tipoProducto->nombre, // Tipo del producto
                        'presentacion' => $lote->producto->presentacion->nombre, // Presentación del producto
                        'avatar' => $lote->producto->avatar ? asset('storage/producto/' . $lote->producto->avatar) : asset('img/producto_default.jpeg'), // Imagen del producto
                        'mes' => $mes, // Meses restantes o vencidos
                        'dia' => $dia, // Días restantes o vencidos
                        'hora' => $hora, // Horas restantes o vencidas
                        'estado' => $estado, // Estado del lote (danger, warning, light)
                        'invert' => $verificado, // Indica si el lote ya venció
                    ];
                }
            }
        }

        // Retornar los lotes en formato JSON
        return response()->json($json);
    }

    public function buscar_prod($id)
    {
        $producto = Producto::select('productos.id as id_productos',
         'productos.nombre',
         'productos.concentracion',
         'productos.adicional',
         'productos.precio',
         'laboratorios.nombre as laboratorio',
         'tipos_productos.nombre as tipo',
         'presentaciones.nombre as presentacion',
         'productos.avatar',
         'productos.id_lab',
         'productos.id_tip_prod',
         'productos.id_present')
         ->join('laboratorios', 'productos.id_lab', '=', 'laboratorios.id')
         ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id')
         ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id')
         ->where('productos.id', $id)->first();

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Obtener el stock del producto
        $stock = $producto->obtenerStock($producto->id_productos);

        // Formatear el JSON de respuesta
        return response()->json([
            'id' => $producto->id_productos,
            'nombre' => $producto->nombre,
            'concentracion' => $producto->concentracion,
            'adicional' => $producto->adicional,
            'precio' => $producto->precio,
            'stock' => $stock,
            'laboratorio' => $producto->laboratorio,
            'tipo' => $producto->tipo,
            'presentacion' => $producto->presentacion,
            'laboratorio_id' => $producto->prod_lab,
            'tipo_id' => $producto->prod_tip,
            'presentacion_id' => $producto->prod_pre,
            'avatar' => asset('img/producto/' . $producto->avatar),
        ]);
    }
}
