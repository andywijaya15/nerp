<?php

namespace App\Filament\Clusters\MasterData\Resources;

use Filament\Forms;
use App\Models\Area;
use Filament\Tables;
use App\Models\Locator;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\MasterData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\MasterData\Resources\LocatorResource\Pages;
use App\Filament\Clusters\MasterData\Resources\LocatorResource\RelationManagers;

class LocatorResource extends Resource
{
    protected static ?string $model = Locator::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = MasterData::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('warehouse_id')
                    ->label('Warehouse')
                    ->options(Warehouse::query()->where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('area_id')
                    ->label('Area')
                    ->required()
                    ->options(function (callable $get) {
                        $warehouseId = $get('warehouse_id');
                        if (!$warehouseId) {
                            return [];
                        }
                        return Area::where('warehouse_id', $warehouseId)->pluck('name', 'id');
                    }),
                Forms\Components\TextInput::make('code')->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('area.name')->label('Area'),
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLocators::route('/'),
            'create' => Pages\CreateLocator::route('/create'),
            'edit' => Pages\EditLocator::route('/{record}/edit'),
        ];
    }
}
