<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Venta;
use Carbon\Carbon;

class ResumenVentas extends BaseWidget
{
    protected function getStats(): array
    {
        // Datos generales
        $totalVentas = Venta::count();
        $totalMonto = Venta::sum('total');

        // Ventas de hoy
        $ventasHoy = Venta::whereDate('created_at', now()->toDateString())->count();
        $promedio = $ventasHoy > 0 ? $totalMonto / $ventasHoy : 0;

        // Últimos 14 días para un gráfico más curvo y notorio
        $ventasPorDia = [];
        $montosPorDia = [];
        $promedioDiario = [];

        for ($i = 13; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i)->toDateString();

            $ventas = Venta::whereDate('created_at', $fecha)->count();
            $monto = Venta::whereDate('created_at', $fecha)->sum('total');
            $prom = $ventas > 0 ? $monto / $ventas : 0;

            $ventasPorDia[] = $ventas;
            $montosPorDia[] = round($monto, 2);
            $promedioDiario[] = round($prom, 2);
        }

        return [
            Stat::make('🛍 Total de Ventas', $totalVentas)
                ->description('Últimos 14 días de actividad 🗓️')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary')
                ->chart($ventasPorDia),

            Stat::make('💰 Monto Total', 'S/ ' . number_format($totalMonto, 2))
                ->description('Ventas acumuladas 💵')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success')
                ->chart($montosPorDia),

            Stat::make('📊 Promedio Diario', 'S/ ' . number_format($promedio, 2))
                ->description('Promedio x venta hoy 📈')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning')
                ->chart($promedioDiario),
        ];
    }
}
