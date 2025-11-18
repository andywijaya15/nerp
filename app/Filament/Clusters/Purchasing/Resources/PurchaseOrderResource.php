<?php

namespace App\Filament\Clusters\Purchasing\Resources;

use App\Enums\PurchaseOrderStatus;
use App\Filament\Clusters\Purchasing;
use App\Filament\Clusters\Purchasing\Resources\PurchaseOrderResource\Pages;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Purchasing::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Purchase Order Header')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('supplier_id')
                                    ->label('Supplier')
                                    ->required()
                                    ->options(Supplier::query()->pluck('name', 'id')),

                                Forms\Components\DatePicker::make('order_date')
                                    ->label('Order Date')
                                    ->required(),

                                Forms\Components\DatePicker::make('delivery_date')
                                    ->label('Delivery Date'),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options(PurchaseOrderStatus::options())
                                    ->default(PurchaseOrderStatus::DRAFT->value)
                                    ->disabled(fn ($record) => $record !== null),

                            ]),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('Purchase Order Lines')
                    ->schema([
                        Forms\Components\Repeater::make('lines')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->options(Product::query()->pluck('name', 'id'))
                                    ->required(),

                                Forms\Components\TextInput::make('qty_ordered')
                                    ->label('Qty')
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $qty = $get('qty_ordered') ?? 0;
                                        $price = $get('price') ?? 0;
                                        $set('subtotal', $qty * $price);
                                    })
                                    ->required(),

                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $qty = $get('qty_ordered') ?? 0;
                                        $price = $get('price') ?? 0;
                                        $set('subtotal', $qty * $price);
                                    })
                                    ->required(),

                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $qty = $get('qty_ordered') ?? 0;
                                        $price = $get('price') ?? 0;
                                        $set('subtotal', $qty * $price);
                                    })
                                    ->default(fn ($get) => (($get('qty_ordered') ?? 0) * ($get('price') ?? 0))),
                            ])
                            ->columns(4)
                            ->defaultItems(1),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('PO Number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')->label('Supplier')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('order_date')->date(),
                Tables\Columns\TextColumn::make('delivery_date')->date(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->status === 'DRAFT'),
                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'DRAFT')
                    ->action(function (PurchaseOrder $record) {
                        $record->status = 'CONFIRMED';
                        $record->save();
                        Notification::make()
                            ->title('Purchase Order marked as CONFIRMED')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
