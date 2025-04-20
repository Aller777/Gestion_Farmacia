<?php

namespace App\Filament\Resources;

use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\CategoriaResource\Pages;

class CategoriaResource extends Resource
{
    // Modelo asociado a este recurso
    protected static ?string $model = Categoria::class;

    // Icono mostrado en la navegación
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Grupo en el menú de navegación
    protected static ?string $navigationGroup = '🏷️ CATEGORIA DE PRODUCTOS';

    // Etiqueta en el menú (opcional, pero útil si quieres cambiar cómo se muestra el nombre del recurso)
    protected static ?string $navigationLabel = 'Categoria de Productos';
    protected static ?string $pluralModelLabel = 'CATEGORÍAS DISPONIBLES';
    protected static ?string $modelLabel = 'Categoría';

    // Formulario de creación/edición
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Información General')
                ->description('Completa los detalles de la categoría.')
                ->schema([

                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre de la Categoría')
                        ->placeholder('Ej: Abarrotes, Tecnología, Ropa')
                        ->required()
                        ->maxLength(255)
                        ->autofocus()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('estado')
                        ->label('Estado de la Categoría')
                        ->options([
                            1 => 'Disponible',
                            0 => 'No Disponible',
                        ])
                        ->default(1)
                        ->required()
                        ->native(false), // mejor presentación tipo dropdown moderno

                    Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción')
                        ->placeholder('Ej: Categoría destinada a productos tecnológicos como laptops, celulares, etc.')
                        ->maxLength(500)
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    // Tabla que muestra el listado
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-cube')
                    ->iconColor('info'),  // Puedes cambiar el color del ícono


                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Disponible' : 'No Disponible')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->icon('heroicon-o-check-circle') // Ícono de check para "Disponible"
                    ->iconColor('success') // Color verde para "Disponible"
                    ->icon('heroicon-o-x-circle') // Ícono de "X" para "No Disponible"
                    ->iconColor('danger') // Color rojo para "No Disponible"
                ,

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->iconColor('purple')
                    ->searchable()
                    ->icon('heroicon-o-document-text') // Ícono de documento para "Descripción"

                ,

                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->iconColor('secondary')
                    ->sortable()
                    ->icon('heroicon-o-calendar') // Ícono de calendario para "Fecha de Registro"

                ,

                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->iconColor('info')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
            ])


            ->filters([
                SelectFilter::make('estado')
                    ->label('Filtrar por Estado')
                    ->options([
                        1 => 'Disponible',
                        0 => 'No Disponible',
                    ]),
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

    // Relaciones (si las hubiera)
    public static function getRelations(): array
    {
        return [];
    }


    
    // Rutas para las páginas del recurso
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit' => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }
}
