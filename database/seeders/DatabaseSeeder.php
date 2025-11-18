<?php

namespace Database\Seeders;

use App\Actions\GenerateCode;
use App\Enums\CustomerType;
use App\Enums\ProductType;
use App\Enums\PurchaseOrderStatus;
use App\Enums\SupplierType;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Locator;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderLine;
use App\Models\Supplier;
use App\Models\Uom;
use App\Models\User;
use App\Models\Warehouse;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()
            ->create([
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]);

        $productCategory = ProductCategory::query()
            ->create([
                'code' => GenerateCode::execute('PC-'),
                'name' => 'KATEGORI 1',
            ]);

        $uom = Uom::query()
            ->create([
                'code' => GenerateCode::execute('UOM-'),
                'name' => 'uom 1',
            ]);

        $product = Product::query()
            ->create([
                'code' => GenerateCode::execute('PRD-'),
                'name' => 'BARANG 1',
                'uom_id' => $uom->id,
                'product_category_id' => $productCategory->id,
                'type' => ProductType::RAW,
            ]);

        $supplier = Supplier::query()
            ->create([
                'code' => GenerateCode::execute('SUP-'),
                'name' => 'SUPPLIER 1',
                'type' => SupplierType::LOCAL,
            ]);

        $warehouse = Warehouse::query()
            ->create([
                'code' => GenerateCode::execute('WH-'),
                'name' => 'WAREHOUSE 1',
            ]);

        $area = Area::query()
            ->create([
                'code' => GenerateCode::execute('A-'),
                'warehouse_id' => $warehouse->id,
                'name' => 'AREA 1',
            ]);

        Locator::query()
            ->create([
                'code' => GenerateCode::execute('L-'),
                'area_id' => $area->id,
                'name' => 'LOCATOR 1',
            ]);

        Customer::query()
            ->create([
                'code' => GenerateCode::execute('C-'),
                'name' => 'CUSTOMER 1',
                'type' => CustomerType::REGULAR,
            ]);

        $purchaseOrder = PurchaseOrder::query()
            ->create([
                'supplier_id' => $supplier->id,
                'order_date' => now()->toDateTimeString(),
                'delivery_date' => now()->addDays(3)->toDateTimeString(),
            ]);

        PurchaseOrderLine::query()
            ->create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $product->id,
                'qty_ordered' => 10,
                'price' => 1000,
            ]);

        $purchaseOrder->status = PurchaseOrderStatus::CONFIRMED;
        $purchaseOrder->save();
    }
}
