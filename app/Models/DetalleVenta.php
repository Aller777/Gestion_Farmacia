<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    // Definición de las relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class); // Relación con el modelo Venta
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class); // Relación con el modelo Producto
    }

    // Si quieres permitir que la fecha se almacene de forma automática
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
