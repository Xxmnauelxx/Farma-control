<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $fillable = ['total', 'vendedor', 'id_cliente','cliente_no_reg','estado'];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_det_venta');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'vendedor');
    }
}
