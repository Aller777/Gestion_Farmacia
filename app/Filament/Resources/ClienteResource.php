<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\TextInput;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '🧑‍🤝‍🧑 GESTIÓN DE CLIENTES';
    protected static ?string $navigationLabel = 'Nuestros Clientes';
    protected static ?string $pluralModelLabel = 'LISTA DE CLIENTES';
    protected static ?string $modelLabel = 'Cliente';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('dni')
                            ->label('DNI')
                            ->required()
                            ->maxLength(8)
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ingrese el DNI')
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (strlen($state) === 8) {
                                    $response = Http::get("https://api.apis.net.pe/v1/dni?numero=$state");
    
                                    if ($response->successful()) {
                                        $data = $response->json();
    
                                        $nombreCompleto = trim(($data['nombres'] ?? '') . ' ' . ($data['apellidoPaterno'] ?? '') . ' ' . ($data['apellidoMaterno'] ?? ''));
                                        $telefono = $data['celular'] ?? '';
                                        $direccion = $data['direccion'] ?? '';
    
                                        $set('nombre', $nombreCompleto);
                                        $set('telefono', $telefono);
                                        $set('direccion', $direccion);
                                    }
                                }
                            }),
    
                        TextInput::make('nombre')
                            ->label('Nombre completo')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nombre y apellidos')
                            ->prefixIcon('heroicon-o-user'),
    
                        TextInput::make('direccion')
                            ->label('Dirección')
                            ->maxLength(255)
                            ->default(null)
                            ->placeholder('Ej: Av. Perú 123')
                            ->prefixIcon('heroicon-o-map-pin'),
    
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(255)
                            ->default(null)
                            ->placeholder('Ej: 999999999')
                            ->prefixIcon('heroicon-o-phone'),
                    ]),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->iconColor('success')
                    ->icon('heroicon-o-user')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI')
                    ->iconColor('info') 
                    ->icon('heroicon-o-identification')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('direccion')
                    ->label('Dirección')
                    ->iconColor('danger') 
                    ->icon('heroicon-o-map-pin')
                    ->searchable()
                    ->wrap()
                    ->limit(40),
    
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->iconColor('warning')
                    ->icon('heroicon-o-phone')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-calendar')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-clock')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->tooltip('Ver detalles'),
                Tables\Actions\EditAction::make(),
    
                // Botón de WhatsApp
                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success') 
                    ->url(fn ($record) => 'https://wa.me/51' . $record->telefono)
                    ->openUrlInNewTab()
                    ->tooltip('Enviar mensaje por WhatsApp'),
    
                // // Botón de Gmail (mailto)
                // Tables\Actions\Action::make('gmail')
                //     ->label('Gmail')
                //     ->icon('heroicon-o-envelope')
                //     ->url(fn ($record) => 'mailto:' . $record->dni . '@gmail.com') // o usa otra columna si tienes email
                //     ->openUrlInNewTab()
                //     ->tooltip('Enviar correo'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
