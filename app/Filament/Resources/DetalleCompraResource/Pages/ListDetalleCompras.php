<?php

namespace App\Filament\Resources\DetalleCompraResource\Pages;

use App\Filament\Resources\DetalleCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetalleCompras extends ListRecords
{
    protected static string $resource = DetalleCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
