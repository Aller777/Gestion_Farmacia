<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'user_id',
        // 'producto_id',
        'productos',
        // 'cantidad',
        'fecha_venta',
        'total',
    ];

    protected $casts = [
        'productos' => 'array',
        'fecha_venta' => 'datetime',
    ];

//     public function productos()
// {
//     return $this->belongsToMany(Producto::class);
// }

    // Relación con el cliente (puede ser null)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el usuario que hizo la venta
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
{
    return $this->belongsToMany(Producto::class, 'venta_producto')->withPivot('cantidad');
}

public function render()
{
    $ventasData = Venta::selectRaw('MONTH(fecha) as month, SUM(total) as total')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

    $chart = [
        'labels' => $ventasData->pluck('month')->toArray(),
        'data' => $ventasData->pluck('total')->toArray(),
    ];

    return view('tu-vista', compact('chart'));
}

}
