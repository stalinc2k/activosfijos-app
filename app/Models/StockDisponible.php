<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDisponible extends Model
{
   protected $table = 'view_stock_disponible';

    public $timestamps = false;

    protected $fillable = [
        'CodPro',
        'Serial_number',
        'Activo',
        'stock',
        'entradas',
        'dev',
        'entrega',
        'bajas',
        'marca',
    ];
}
