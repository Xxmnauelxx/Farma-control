<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    use HasFactory;

    protected $table = 'venta_producto';
    protected $fillable = ['precio', 'cantidad', 'subtotal', 'id_producto', 'id_venta'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
