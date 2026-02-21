<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'medidas';


     public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_unidad'); // Relación inversa con los lotes
    }
}
