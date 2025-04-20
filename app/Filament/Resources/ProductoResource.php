<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '📦 GESTIÓN DE PRODUCTOS';
    protected static ?string $navigationLabel = 'Productos en stock';
    protected static ?string $pluralModelLabel = 'LISTA DE PRODUCTOS';
    protected static ?string $modelLabel = 'Producto';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del producto')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre del producto')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Precios y stock')
                    ->schema([
                        Forms\Components\TextInput::make('precio_compra')
                            ->label('Precio de compra')
                            ->required()
                            ->numeric()
                            ->prefix('S/'),

                        Forms\Components\TextInput::make('precio_venta')
                            ->label('Precio de venta')
                            ->required()
                            ->numeric()
                            ->prefix('S/'),

                        Forms\Components\TextInput::make('stock')
                            ->label('Stock actual')
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('stock_minimo')
                            ->label('Stock mínimo')
                            ->required()
                            ->numeric()
                            ->default(5),

                        Forms\Components\DatePicker::make('fecha_vencimiento')
                            ->label('Fecha de vencimiento')
                            ->suffixIcon('heroicon-o-calendar'),
                    ])->columns(3),

                Forms\Components\Section::make('Relaciones')
                    ->schema([
                        Forms\Components\Select::make('categoria_id')
                            ->label('Categoría')
                            ->relationship('categoria', 'nombre')
                            ->required(),

                        Forms\Components\Select::make('proveedor_id')
                            ->label('Proveedor')
                            ->relationship('proveedor', 'nombre')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Producto')
                    ->searchable()
                    ->icon('heroicon-o-cube')
                    ->iconColor('info')
                    ->description('Nombre del producto')
                    ->wrap(),
    
                Tables\Columns\TextColumn::make('precio_compra')
                    ->label('Compra')
                    ->money('PEN')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-arrow-down')
                    ->iconColor('danger')
                    ->description('Precio de compra del producto'),
    
                Tables\Columns\TextColumn::make('precio_venta')
                    ->label('Venta')
                    ->money('PEN')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-arrow-up')
                    ->iconColor('success')
                    ->description('Precio de venta del producto'),
    
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-archive-box')
                    ->iconColor('primary')
                    ->description('Cantidad en stock disponible'),
    
                Tables\Columns\TextColumn::make('stock_minimo')
                    ->label('Mínimo')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-exclamation-circle')
                    ->iconColor('warning')
                    ->description('Stock mínimo permitido'),
    
                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->label('Vence')
                    ->date()
                    ->sortable()
                    ->icon('heroicon-o-calendar-days')
                    ->iconColor('danger')
                    ->description('Fecha de vencimiento'),
    
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-tag')
                    ->iconColor('info')
                    ->description('Categoría del producto'),
    
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-truck')
                    ->iconColor('secondary')
                    ->description('Proveedor del producto'),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->description('Fecha de creación'),
    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-arrow-path')
                    ->iconColor('gray')
                    ->description('Última actualización'),
            ])
    
    
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Agrega filtros si lo necesitas
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->tooltip('Ver detalles'),
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Eliminar seleccionados'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
