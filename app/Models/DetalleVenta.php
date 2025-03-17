<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';
    protected $fillable = [
        'det_cantidad',
        'det_vencimiento',
        'id_det_lote',
        'id_det_prod',
        'lote_id_prov',
        'id_det_venta',
        'estado'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_det_venta');
    }
}
