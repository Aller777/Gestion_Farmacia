<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Notifications\Notification;

class ResumenProductos extends BaseWidget
{
    protected function getCards(): array
    {
        $productosConStockBajo = Producto::where('stock', '<', 10)->get();
        $productosNombres = $productosConStockBajo->pluck('nombre')->implode(', ');

        // Verificar si ya hemos mostrado la notificación 5 veces
        if ($productosConStockBajo->count() > 0 && session('stock_notification_count', 0) < 5) {
            Notification::make()
                ->title('¡Stock Bajo Detectado!')
                ->body("Productos con stock bajo: $productosNombres")
                ->icon('heroicon-o-exclamation-circle')
                ->danger()
                ->persistent()
                ->send();

            // Incrementar el contador de notificaciones
            session()->put('stock_notification_count', session('stock_notification_count', 0) + 1);
        }

        return [
            Card::make('Total de Productos', Producto::count())
                ->description('Cantidad total de productos registrados.')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Card::make('Productos con Stock Bajo', $productosConStockBajo->count() . ' producto(s)')
                ->description('⚠️ ' . $productosNombres)
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger'),

            Card::make('Productos Creados en el Último Mes', Producto::where('created_at', '>=', now()->subMonth())->count())
                ->description('Productos creados en el último mes.')
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),
        ];
    }
}

