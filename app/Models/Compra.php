<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'proveedor_id',
        'user_id',
        'fecha_compra',
        'nombre',
        'descripcion',
    ];

    // Definición de las relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class); // Relación con el modelo Proveedor
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Relación con el modelo User
    }

    // Si quieres permitir que la fecha se almacene de forma automática
    protected $dates = [
        'fecha_compra',
        'created_at',
        'updated_at',
    ];
}
