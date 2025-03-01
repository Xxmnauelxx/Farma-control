<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $consulta = $request->input('consulta', '');

        // Obtener la fecha actual
        $fecha_actual = Carbon::now('America/Managua');

        // Consulta con Eloquent o Query Builder
        $lotes = DB::table('lote as l')
            ->join('compras', 'l.id_compra', '=', 'compra.id')
            ->join('proveedores', 'proveedor.id', '=', 'compra.id_proveedor')
            ->join('productos', 'productos.id', '=', 'l.id_producto')
            ->join('laboratorios', 'productos.prod_lab', '=', 'laboratorio.id_laboratorio')
            ->join('tipos_productos', 'productos.prod_tip', '=', 'tipo_producto.id_tip_prod')
            ->join('presentaciones', 'productos.prod_pre', '=', 'presentacion.id_presentacion')
            ->select(
                'l.id as id_lote',
                DB::raw("CONCAT(l.id, ' | ', l.codigo) as codigo"),
                'l.cantidad_lote',
                'l.vencimiento',
                'productos.concentracion',
                'productos.adicional',
                'productos.nombre as prod_nom',
                'laboratorio.nombre as lab_nom',
                'tipo_producto.nombre as tip_nom',
                'presentacion.nombre as pre_nom',
                'proveedor.nombre as proveedor',
                'productos.avatar as logo'
            )
            ->where('l.estado', 'A')
            ->when(!empty($consulta), function ($query) use ($consulta) {
                return $query->where('productos.nombre', 'LIKE', "%$consulta%");
            })
            ->orderBy('productos.nombre')
            ->limit(25)
            ->get();

        $json = [];

        foreach ($lotes as $lote) {
            $vencimiento = Carbon::parse($lote->vencimiento);
            $diferencia = $vencimiento->diff($fecha_actual);

            $anio = $diferencia->y;
            $mes = $diferencia->m;
            $dia = $diferencia->d;
            $hora = $diferencia->h;
            $verificado = $diferencia->invert;

            $estado = 'light';

            if ($verificado == 0) {
                $estado = 'danger';
                $anio *= -1;
                $mes *= -1;
                $dia *= -1;
                $hora *= -1;
            } elseif ($mes <= 3 && $anio == 0) {
                $estado = 'warning';
            }

            $json[] = [
                'id' => $lote->id_lote,
                'codigo' => $lote->codigo,
                'nombre' => $lote->prod_nom,
                'concentracion' => $lote->concentracion,
                'adicional' => $lote->adicional,
                'vencimiento' => $lote->vencimiento,
                'proveedor' => $lote->proveedor,
                'stock' => $lote->cantidad_lote,
                'laboratorio' => $lote->lab_nom,
                'tipo' => $lote->tip_nom,
                'presentacion' => $lote->pre_nom,
                'avatar' => asset('img/producto/' . $lote->logo),
                'anio' => $anio,
                'mes' => $mes,
                'dia' => $dia,
                'hora' => $hora,
                'estado' => $estado,
                'invert' => $verificado,
            ];
        }

        return response()->json($json);
      }
}
