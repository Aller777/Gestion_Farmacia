<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'estado',
        'descripcion',
    ];

    // Si quieres permitir que las fechas se almacenen automáticamente
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
