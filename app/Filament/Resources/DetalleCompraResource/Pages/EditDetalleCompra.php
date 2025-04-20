<?php

namespace App\Filament\Resources\DetalleCompraResource\Pages;

use App\Filament\Resources\DetalleCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetalleCompra extends EditRecord
{
    protected static string $resource = DetalleCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
