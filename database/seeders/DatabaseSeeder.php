<?php

namespace Database\Seeders;

use App\Actions\GenerateCode;
use App\Enums\ProductType;
use App\Enums\SupplierType;
use App\Models\Product;
use App\Models\ProductCategory;
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
        // User::factory(10)->create();

        User::query()
            ->create([
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]);

        $pc = ProductCategory::query()
            ->create([
                'code' => GenerateCode::execute('PC-'),
                'name' => 'KATEGORI 1',
            ]);

        $uom = Uom::query()
            ->create([
                'code' => GenerateCode::execute('UOM-'),
                'name' => 'uom 1',
            ]);

        Product::query()
            ->create([
                'code' => GenerateCode::execute('PRD-'),
                'name' => 'BARANG 1',
                'uom_id' => $uom->id,
                'product_category_id' => $pc->id,
                'type' => ProductType::RAW,
            ]);

        Supplier::query()
            ->create([
                'code' => GenerateCode::execute('SUP-'),
                'name' => 'SUPPLIER 1',
                'type' => SupplierType::LOCAL,
            ]);

        Warehouse::query()
            ->create([
                'code' => GenerateCode::execute('WH-'),
                'name' => 'WAREHOUSE 1',
            ]);
    }
}
