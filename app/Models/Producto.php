<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria',
        'vendedor',
        'unidad_de_medida',
        'descripcion',
        'precio',
        'cantidad',
    ];


}
