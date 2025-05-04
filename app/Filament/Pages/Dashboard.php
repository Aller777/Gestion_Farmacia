<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as Page;
use App\Filament\Widgets\ResumenProveedores;
use App\Filament\Widgets\ResumenProductos;
use App\Filament\Widgets\ResumenVentas;
use App\Filament\Widgets\ResumenClientes;
use App\Filament\Widgets\GraficoVentas; 
class Dashboard extends Page
{
    // Otros métodos y propiedades...

    public function getHeaderWidgets(): array
    {
        return [
            // Los widgets se devolverán en un arreglo para ser gestionados en la vista
            ResumenVentas::class,
            ResumenProveedores::class,
            ResumenClientes::class,
            ResumenProductos::class,
            GraficoVentas::class, 
            
        ];
    }

    // Método opcional si quieres agregar más secciones al dashboard.
    public function getContentWidgets(): array
    {
        return [
            // Aquí puedes agregar widgets adicionales si es necesario
        ];
    }




    
}
