<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ResumenProductos extends BaseWidget
{
    protected function getCards(): array
    {
        // Obtener los productos con stock bajo
        $productosConStockBajo = Producto::where('stock', '<', 10)->get();

        // Crear una cadena con los nombres de los productos con stock bajo
        $productosNombres = $productosConStockBajo->pluck('nombre')->implode(', ');

        return [
            // Total de productos
            Card::make('Total de Productos', Producto::count())
                ->description('Cantidad total de productos registrados.')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            // Productos con stock bajo
            Card::make('Productos con Stock Bajo', $productosNombres)
                ->description('Productos con stock inferior a 10 unidades.')
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger'),

            // Productos creados en el último mes
            Card::make('Productos Creados en el Último Mes', Producto::where('created_at', '>=', now()->subMonth())->count())
                ->description('Productos creados en el último mes.')
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),
        ];
    }
}

