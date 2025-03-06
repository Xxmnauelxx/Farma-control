<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Auth;
use DB;
use File;
use Storage;
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

        // Devuelve la vista para mostrar los productos, pasando datos como el usuario y los registros adicionales
        return view('admin.venta.index', compact('usuario', 'nombre', 'tipo'));
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
}
