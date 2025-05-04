<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Producto;

class CreateVenta extends CreateRecord
{
    
    protected static string $resource = VentaResource::class;

    protected function afterCreate(): void
    {
        foreach ($this->record->productos as $item) {
            $producto = Producto::find($item['producto_id']);
            if ($producto) {
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
        }
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
