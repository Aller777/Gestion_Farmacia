<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompraResource\Pages;
use App\Filament\Resources\CompraResource\RelationManagers;
use App\Models\Compra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '🧾 GESTIÓN DE COMPRAS';
    protected static ?string $navigationLabel = 'Nuestras Compras';
    protected static ?string $pluralModelLabel = 'NUESTRAS COMPRAS';
    protected static ?string $modelLabel = 'Compra';

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\Section::make('Información de la compra')
            ->description('Completa los detalles principales de esta compra.')
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('proveedor_id')
                        ->relationship('proveedor', 'nombre')
                        ->label('Proveedor')
                        ->required(),

                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Registrado por')
                        ->required(),

                    Forms\Components\DatePicker::make('fecha_compra')
                        ->label('Fecha de compra')
                        ->required(),
                ]),
            ])
            ->columns(1)
            ->collapsible(),

        Forms\Components\Section::make('Detalles del contenido')
            ->description('Lista de productos y descripción adicional.')
            ->schema([
                Forms\Components\Textarea::make('nombre')
                    ->label('Listado de productos')
                    ->placeholder("- Producto 1\n- Producto 2\n- Porducto 3")
                    ->rows(5)
                    ->required()
                    ->maxLength(1000),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción adicional')
                    ->rows(4)
                    ->maxLength(65535),
            ])
            ->columns(1)
            ->collapsible(),
    ]);

    }
    
    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('proveedor.nombre')
                ->label('Proveedor')
                ->icon('heroicon-o-truck')
                ->iconColor('secondary')
                ->searchable()
                ->description('Proveedor asociado a la compra'),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Usuario')
                ->icon('heroicon-o-user')
                ->iconColor('info')
                ->searchable()
                ->description('Usuario que registró la compra'),

            Tables\Columns\TextColumn::make('fecha_compra')
                ->label('Fecha de Compra')
                ->date()
                ->icon('heroicon-o-calendar-days')
                ->iconColor('primary')
                ->sortable()
                ->description('Fecha en que se realizó la compra'),

                Tables\Columns\TextColumn::make('nombre')
                ->label('Producto')
                ->icon('heroicon-o-cube')
                ->iconColor('success')
                ->sortable()
                ->searchable()
                ->wrap()
                ->limit(30) // limita a 30 caracteres para evitar que se desborde
                ->description(fn ($record) => 'Producto ID: ' . $record->id), // opcional para dar más contexto
            

            Tables\Columns\TextColumn::make('created_at')
                ->label('Registrado')
                ->since()
                ->icon('heroicon-o-clock')
                ->iconColor('gray')
                ->description('Tiempo desde el registro'),
        ])
        ->filters([
            // Puedes agregar filtros si quieres más control de búsqueda
        ])
        ->actions([
            
            Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->tooltip('Ver detalles'),
            Tables\Actions\EditAction::make()
                ->icon('heroicon-o-pencil-square')
                ->tooltip('Editar registro'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('Eliminar seleccionados'),
            ]),
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
