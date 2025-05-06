<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteHistorialProducto extends Model
{
    use HasFactory;

    protected $table = 'cliente_historial_productos'; // Define la tabla en la base de datos

    protected $fillable = [
        'cliente_id',
        'producto',
        'frecuencia',
        'cantidad',
    ];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

   

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
