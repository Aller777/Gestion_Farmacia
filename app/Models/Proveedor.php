<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'ruc',
        'direccion',
        'telefono',
        'email',
    ];

    // Si quieres permitir que la fecha se almacene de forma automática
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id');  // Asegúrate de que 'proveedor_id' es el campo en la tabla 'productos' que referencia a 'proveedores'
    }
}
