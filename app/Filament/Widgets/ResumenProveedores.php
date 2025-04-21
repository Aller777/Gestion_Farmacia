<?php

namespace App\Filament\Widgets;

use App\Models\Proveedor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ResumenProveedores extends BaseWidget
{
    protected function getCards(): array
    {
        // Obtener los proveedores con productos con stock bajo
        $proveedoresConStockBajo = Proveedor::whereHas('productos', function ($query) {
            $query->where('stock', '<', 10); // Ajusta el valor según tu lógica de stock bajo
        })->get();

        // Crear una cadena con los nombres de los proveedores que tienen productos con stock bajo
        $proveedoresNombres = $proveedoresConStockBajo->pluck('nombre')->implode(', ');

        return [
            Card::make('Total de Proveedores', Proveedor::count())
                ->description('Cantidad registrada actualmente')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            // Proveedores con productos con stock bajo
            Card::make('Proveedores con Stock Bajo', $proveedoresNombres)
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

