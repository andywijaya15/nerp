<?php

namespace App\Filament\Clusters\Receiving\Resources;

use App\Enums\GoodsReceiptStatus;
use App\Filament\Clusters\Receiving;
use App\Filament\Clusters\Receiving\Resources\GoodsReceiptResource\Pages;
use App\Models\GoodsReceipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GoodsReceiptResource extends Resource
{
    protected static ?string $model = GoodsReceipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Receiving::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('purchase_order_id')
                    ->label('Purchase Order')
                    ->relationship('purchaseOrder', 'code')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) {
                            $set('lines', []);

                            return;
                        }

                        $po = \App\Models\PurchaseOrder::with('lines.product')->find($state);

                        // Auto set supplier
                        $set('supplier_id', $po->supplier_id);

                        // Generate GR Lines from PO Lines
                        $set('lines', $po->lines->map(function ($line) {
                            return [
                                'purchase_order_line_id' => $line->id,
                                'product_id' => $line->product_id,
                                'warehouse_id' => $line->warehouse_id ?? null,
                                'qty' => $line->qty_ordered - $line->qty_received,
                                'price' => $line->price,
                            ];
                        })->toArray());
                    }),

                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('receipt_date')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options(GoodsReceiptStatus::options())
                    ->default(GoodsReceiptStatus::DRAFT->value)
                    ->disabled(fn ($record) => $record !== null),

                Forms\Components\Repeater::make('lines')
                    ->relationship('lines')
                    ->label('Lines')
                    ->columnSpanFull()
                    ->visible(fn (callable $get) => $get('purchase_order_id') !== null)
                    ->schema([

                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('warehouse_id')
                            ->label('Warehouse')
                            ->relationship('warehouse', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('qty')
                            ->label('Qty Received')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->reactive(),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchaseOrder.code')
                    ->label('PO No.')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('receipt_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lines_count')
                    ->label('Items')
                    ->counts('lines'),

                Tables\Columns\TextColumn::make('total_qty')
                    ->label('Qty')
                    ->getStateUsing(fn ($record) => $record->lines()->sum('qty')),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable(),
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
            'index' => Pages\ListGoodsReceipts::route('/'),
            'create' => Pages\CreateGoodsReceipt::route('/create'),
            'edit' => Pages\EditGoodsReceipt::route('/{record}/edit'),
        ];
    }
}
