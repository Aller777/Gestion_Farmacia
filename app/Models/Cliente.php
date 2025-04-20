<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'dni',
        'direccion',
        'telefono',
    ];

    // Si quieres permitir que la fecha se almacene de forma automática
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
