<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected
        $table = 'productos',
        $fillable = [
            'Nombre_Producto',
            'Descripción_Producto',
            'Precio_Producto',
            'Stock_Producto',
            'Fecha_Ingreso'
        ];
}
