<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        Product::query()
            ->create([
                'code' => Str::uuid7(),
                'name' => 'barang 1',
            ]);

        Warehouse::query()
            ->create([
                'code' => Str::uuid7(),
                'name' => 'warehouse 1',
            ]);
    }
}
