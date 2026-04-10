<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'view_asignaciones';
    public $incrementing = false;
    protected $keyType = 'string'; // o 'int' si usas ROW_NUMBER
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'Documento',
        'Serial_number',
        'Activo',
        'Asignado_at',
        'Marca',
    ];
}
