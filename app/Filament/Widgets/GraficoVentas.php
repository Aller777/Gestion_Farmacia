<?php

namespace App\Filament\Widgets;
use Illuminate\Support\Facades\DB;

use Filament\Widgets\Widget;
use App\Models\Venta; // Asegúrate de importar el modelo Venta

class GraficoVentas extends Widget
{
    protected static string $view = 'filament.widgets.grafico-ventas'; // La vista donde se muestra el gráfico

    public $labels;
    public $data;

    public function mount()
    {
        // Obtén los datos de las ventas agrupados por mes
        $ventas = Venta::selectRaw('MONTH(fecha_venta) as mes, SUM(total) as total')  // Usa 'fecha_venta' en lugar de 'fecha'
            ->groupBy(DB::raw('MONTH(fecha_venta)'))  // Cambia 'fecha' por 'fecha_venta'
            ->get();

        // Pasa los datos a las propiedades del widget
        $this->labels = $ventas->pluck('mes');
        $this->data = $ventas->pluck('total');
    }
}
