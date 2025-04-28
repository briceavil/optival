<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderStatsOverview as WidgetsOrderStatsOverview;
use App\Filament\Widgets\OrderStatsOverview;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\View\LegacyComponents\Widget;
use Filament\Widgets\Widget as WidgetsWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $title = 'orden';
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'Ordenes';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('id_order')
                    ->label('Nº de orden')
                    ->required(),
                Forms\Components\TextInput::make('id_number')
                    ->label('Nº de Cédula')
                    ->numeric(),
                Forms\Components\ToggleButtons::make('delivered')
                    ->label('¿Fué Entregado?')
                    ->options(['true' => 'Si', 'false' => 'No'])
                    ->boolean()
                    ->default(false)
                    ->inline()
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('Imagen de la Orden')
                    ->image()
                    ->extraInputAttributes(['capture' => 'environment','multiple'=>true])
                    ->optimize('webp')
                    ->resize(50)
                    ->imageEditor()
                    ->panelAspectRatio('1:1')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_order')
                    ->label('Nº de orden')
                    ->alignCenter()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_number')
                    ->label('Nº de Cédula')
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('delivered')
                    ->label('¿Fué Entregado?')
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen de la Orden')
                    ->alignCenter()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Filter::make('delivered')
                    ->label('Sin Entregar')
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->where('delivered', false);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
        ];
    }
}
