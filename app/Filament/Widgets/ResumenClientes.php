<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Cliente;

class ResumenClientes extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('👥 Total de Clientes', Cliente::count()) 
                ->description('Cantidad total registrados.')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary')
                ->chart([5, 8, 12, 15, 18, 20, 22]),

            Stat::make('🗓️ Hoy Registrados', Cliente::whereDate('created_at', now()->toDateString())->count())
                ->description('Clientes nuevos hoy.')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success')
                ->chart([0, 1, 1, 2, 3, 5, 6]),

            Stat::make('📈 Último Mes', Cliente::where('created_at', '>=', now()->subMonth())->count())
                ->description('Clientes en los últimos 30 días.')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning')
                ->chart([4, 6, 7, 8, 10, 12, 14]),
        ];
    }
}
