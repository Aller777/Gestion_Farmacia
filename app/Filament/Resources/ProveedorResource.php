<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;

use App\Models\Proveedor;
use Illuminate\Support\Facades\Http;
use App\Filament\Resources\ProveedorResource\Pages;
use App\Filament\Resources\ProveedorResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ProveedorResource extends Resource
{
    protected static ?string $model = Proveedor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '🧑‍💼 GESTIÓN DE PROVEEDORES';
    protected static ?string $navigationLabel = 'Nuestros Proveedores';
    protected static ?string $pluralModelLabel = 'NUESTROS PROVEEDORES';
    protected static ?string $modelLabel = 'Proveedor';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)
                ->schema([
                    TextInput::make('ruc')
                        ->label('RUC')
                        ->required()
                        ->maxLength(11)
                        ->unique(ignoreRecord: true)
                        ->placeholder('Ingrese el RUC del proveedor')
                        ->prefixIcon('heroicon-o-identification')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (strlen($state) === 11) {
                                $response = Http::get("https://api.apis.net.pe/v1/ruc?numero=$state");

                                if ($response->successful()) {
                                    $data = $response->json();
                                    $set('nombre', $data['nombre'] ?? '');
                                    $set('direccion', $data['direccion'] ?? '');
                                }
                            }
                        }),

                    TextInput::make('nombre')
                        ->label('Nombre o Razón Social')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Nombre completo del proveedor')
                        ->prefixIcon('heroicon-o-user'),

                    TextInput::make('direccion')
                        ->label('Dirección')
                        ->maxLength(255)
                        ->placeholder('Dirección del proveedor')
                        ->prefixIcon('heroicon-o-map-pin'),

                    TextInput::make('telefono')
                        ->label('Teléfono')
                        ->maxLength(20)
                        ->placeholder('Ej: 999 999 999')
                        ->prefixIcon('heroicon-o-phone'),

                    TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->maxLength(255)
                        ->placeholder('ejemplo@correo.com')
                        ->prefixIcon('heroicon-o-envelope'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre o Razón Social')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->iconColor('primary'),

                TextColumn::make('ruc')
                    ->label('RUC')
                    ->sortable()
                    ->searchable()
                    ->iconColor('info')
                    ->icon('heroicon-o-identification'),

                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->formatStateUsing(fn($state) => $state ?: '—')
                    ->iconColor('warning')
                    ->icon('heroicon-o-phone'),

                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->formatStateUsing(fn($state) => $state ?: '—')
                    ->iconColor('danger')
                    ->icon('heroicon-o-envelope'),

                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->iconColor('success'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->tooltip('Ver detalles'),
                
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square'),

                Action::make('email')
                    ->label('Enviar Correo')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->url(fn($record) => 'https://mail.google.com/mail/?view=cm&fs=1&to=' . $record->email)
                    ->openUrlInNewTab(),

                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->color('success')
                    ->url(fn($record) => 'https://wa.me/51' . preg_replace('/\D/', '', $record->telefono))
                    ->openUrlInNewTab(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados')
                        ->icon('heroicon-o-trash'),
                ]),
            ]);
    }




    public static function getRelations(): array
    {
        return [
            // Aquí se pueden agregar relaciones si es necesario, por ejemplo, con otros modelos
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProveedors::route('/'),
            'create' => Pages\CreateProveedor::route('/create'),
            'edit' => Pages\EditProveedor::route('/{record}/edit'),
        ];
    }
}
