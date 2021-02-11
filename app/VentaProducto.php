<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    protected $fillable = [
        'venta_id', 'producto_id', 'precio',
    ];
}
