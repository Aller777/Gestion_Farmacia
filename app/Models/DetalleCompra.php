<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    // Definición de las relaciones
    public function compra()
    {
        return $this->belongsTo(Compra::class); // Relación con el modelo Compra
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class); // Relación con el modelo Producto
    }

    // Si quieres permitir que las fechas se almacenen automáticamente
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
