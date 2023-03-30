<?php

namespace App\Validations;

trait validacionesProductos
{
    /* Reglas de validación general */
    private $validacionesGenerales = [
        'required' => 'El campo :attribute es requerido',
        'max' => 'El campo :attribute no debe ser mayor a :max caracteres',
        'min' => 'El campo :attribute no debe ser menor a :max caracteres',
        'numeric' => 'El campo :attribute debe ser un número',
        'required' => 'El campo :attribute es requerido',
        'unique' => 'El campo :attribute ya existe',
        'email' => 'El campo :attribute debe ser un correo electrónico',
        'confirmed' => 'El atributo :attribute no coincide con la confirmación',
        'date' => 'El campo :attribute debe ser fecha',
    ];

    private $validacionSubmitProducto = [
        'Nombre_Producto' => 'required|max:50',
        'Descripción_Producto' => 'required|max:500',
        'Precio_Producto' => 'required|numeric',
        'Stock_Producto' => 'required|numeric',
        'Fecha_Ingreso' => 'required|date'
    ];
}
