<?php

namespace App\Filament\Widgets;

use App\Models\Proveedor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ResumenProveedores extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total de Proveedores', Proveedor::count())
                ->description('Cantidad registrada actualmente')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            // Proveedores con stock bajo
            Card::make('Proveedores con Stock Bajo', Proveedor::whereHas('productos', function ($query) {
                $query->where('stock', '<', 10); // Ajusta el valor según tu lógica de stock bajo
            })->count())
                ->description('Proveedores con productos en stock bajo')
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger'),

            // Proveedores con productos registrados
            Card::make('Proveedores con Productos', Proveedor::has('productos')->count())
                ->description('Proveedores que tienen productos registrados')
                ->color('success'),
        ];
    }
}
