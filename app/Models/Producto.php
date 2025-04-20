<?php

namespace App\Models;
use Filament\Notifications\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'fecha_vencimiento',
        'categoria_id',
        'proveedor_id',
    ];

    // Relación con la tabla 'categoria'
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación con la tabla 'proveedor'
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Si quieres permitir que la fecha se almacene de forma automática
    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_vencimiento',
    ];

// En el modelo Producto
public function verificarStockBajo()
{
    // Verificamos si el stock es igual o menor al stock mínimo
    if ($this->stock <= $this->stock_minimo) {
        // Si el stock está bajo, puedes regresar un mensaje de advertencia
        return "El producto {$this->nombre} tiene stock casi agotado. Solo quedan {$this->stock} unidades.";
    }

    // Si no está bajo, simplemente regresamos null o un mensaje vacío
    return null;
}


// En el modelo Producto (Producto.php)
public function isStockBajo()
{
    return $this->stock <= $this->stock_minimo;
}

}
