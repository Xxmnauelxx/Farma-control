<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
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
            ->join('tipos_productos', 'productos.id_tip_prod', '=', 'tipos_productos.id') // Se une con la tabla "tipos_productos" para obtener el tipo de producto
            ->join('presentaciones', 'productos.id_present', '=', 'presentaciones.id') // Se une con la tabla "presentaciones" para obtener la presentación del producto
            ->select(
                'l.id as id_lote', // Se selecciona el ID del lote
                DB::raw("CONCAT(l.id, ' | ', l.codigo) as codigo"), // Se concatena el ID y el código del lote
                'l.cantidad_lote', // Se selecciona la cantidad de productos en el lote
                'l.vencimiento', // Se selecciona la fecha de vencimiento del lote
                'productos.concentracion', // Se selecciona la concentración del producto
                'productos.adicional', // Se selecciona información adicional del producto
                'productos.nombre as prod_nom', // Se selecciona el nombre del producto
                'laboratorios.nombre as lab_nom', // Se selecciona el nombre del laboratorio
                'tipos_productos.nombre as tip_nom', // Se selecciona el tipo de producto
                'presentaciones.nombre as pre_nom', // Se selecciona la presentación del producto
                'proveedores.nombre as proveedor', // Se selecciona el nombre del proveedor
                'productos.avatar as logo', // Se selecciona la imagen del producto
            )
            ->where('l.estado', 'Activo') // Se filtran solo los lotes con estado "Activo"
            ->when(!empty($consulta), function ($query) use ($consulta) {
                return $query->where('productos.nombre', 'LIKE', "%$consulta%"); // Si hay una consulta, se filtra por el nombre del producto
            })
            ->orderBy('productos.nombre') // Se ordenan los resultados por el nombre del producto
            ->limit(25) // Se limita la consulta a 25 resultados
            ->get(); // Se ejecuta la consulta y se obtienen los resultados

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
                'adicional' => $lote->adicional, // Información adicional
                'vencimiento' => $lote->vencimiento, // Fecha de vencimiento
                'proveedor' => $lote->proveedor, // Proveedor del producto
                'stock' => $lote->cantidad_lote, // Cantidad disponible en el lote
                'laboratorio' => $lote->lab_nom, // Laboratorio del producto
                'tipo' => $lote->tip_nom, // Tipo del producto
                'presentacion' => $lote->pre_nom, // Presentación del producto
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

}
