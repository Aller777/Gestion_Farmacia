<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Models\Venta;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '🛒 GESTIÓN DE VENTAS';
    protected static ?string $navigationLabel = 'Nuestras Ventas';
    protected static ?string $pluralModelLabel = 'LISTA DE VENTAS';
    protected static ?string $modelLabel = 'Venta';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos de la Venta')
                ->columns(2)
                ->schema([
                    Select::make('cliente_id')
                        ->label('Cliente')
                        ->relationship('cliente', 'nombre')
                        ->searchable()
                        ->nullable(),

                    Select::make('user_id')
                        ->label('Vendedor')
                        ->relationship('user', 'name')
                        // ->searchable()
                        ->required(),
                    DateTimePicker::make('fecha_venta')
                        ->label('Fecha de Venta')
                        ->required(),

                    TextInput::make('total')
                        ->label('Total General')
                        ->numeric()
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->afterStateHydrated(function (callable $set, callable $get) {
                            $productos = $get('productos') ?? [];
                            $total = collect($productos)->sum(fn($item) => ($item['precio'] ?? 0) * ($item['cantidad'] ?? 0));
                            $set('total', $total);
                        }),
                ]),

            Forms\Components\Section::make('Productos')
                ->description('Agrega los productos vendidos en esta venta')
                ->schema([
                    Repeater::make('productos')
                        ->label('Lista de productos')
                        ->columns(4)
                        ->schema([
                            Select::make('producto_id')
                                ->label('Producto')
                                ->options(Producto::all()->pluck('nombre', 'id'))
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $producto = Producto::find($state);
                                    if ($producto) {
                                        $set('precio', $producto->precio_venta);
                                    }
                                })
                                ->required(),

                            TextInput::make('precio')
                                ->label('Precio Unitario')
                                ->numeric()
                                ->disabled()
                                ->reactive()
                                ->required(),

                            TextInput::make('cantidad')
                                ->label('Cantidad')
                                ->numeric()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, callable $get) {
                                    $precio = $get('precio') ?? 0;
                                    $cantidad = $get('cantidad') ?? 0;
                                    $set('subtotal', $precio * $cantidad);
                                })
                                ->required(),

                            TextInput::make('subtotal')
                                ->label('Subtotal')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),
                        ])
                        ->minItems(1)
                        ->maxItems(10)
                        ->defaultItems(1)
                        ->required()
                        ->afterStateUpdated(function (callable $set, $state) {
                            $total = collect($state)->sum(fn($item) => ($item['precio'] ?? 0) * ($item['cantidad'] ?? 0));
                            $set('total', $total);
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->iconColor('primary')
                    ->description('Nombre del cliente'),

                TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-user-circle')
                    ->iconColor('info')
                    ->description('Atendido por'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('PEN')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-currency-dollar')
                    ->iconColor('success'),

                TextColumn::make('productos')
                    ->label('Productos')
                    ->getStateUsing(fn($record) => implode(', ', array_map(
                        fn($producto) => Producto::find($producto['producto_id'])->nombre,
                        is_array($record->productos) ? $record->productos : json_decode($record->productos, true)
                    )))
                    ->wrap()
                    ->searchable()
                    ->icon('heroicon-o-cube')
                    ->iconColor('warning')
                    ->tooltip('Listado de productos vendidos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->tooltip('Ver detalles'),

                Action::make('Exportar')
                    ->label('Exportar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->action(function (Venta $record) {
                        $productos = [];
                        foreach ($record->productos as $producto) {
                            $productoModelo = Producto::find($producto['producto_id']);
                            $productos[] = [
                                'nombre' => $productoModelo->nombre,
                                'cantidad' => $producto['cantidad'],
                            ];
                        }

                        $pdf = Pdf::loadView('pdf.venta', [
                            'venta' => $record,
                            'productos' => $productos,
                        ]);

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'venta_' . $record->id . '.pdf'
                        );
                    }),
            ])
            ->defaultSort('fecha_venta', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
