<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = ['nombre', 'concentracion', 'adicional', 'precio', 'id_lab', 'id_tip_prod', 'id_present', 'id_adicional', 'estado'];

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'id_lab');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'id_tip_prod');
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class, 'id_present');
    }

    public function adicional()
    {
        return $this->belongsTo(Adicional::class, 'id_adicional');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_producto'); // Relación inversa con los lotes
    }




    public function obtenerStock()
    {
        return Lote::where('id_producto', $this->id)->where('estado', 'Activo')->sum('cantidad_lote');
    }

    
    public function obtenerStockUnidad()
    {
        return $this->unidad?->nombre ?? 'Sin unidad';
    }

}
