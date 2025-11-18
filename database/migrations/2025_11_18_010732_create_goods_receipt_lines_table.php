<?php

use App\Models\GoodsReceipt;
use App\Models\Product;
use App\Models\PurchaseOrderLine;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_receipt_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->foreignIdFor(User::class, 'updated_by')->constrained();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained();
            $table->foreignIdFor(GoodsReceipt::class)->constrained();
            $table->foreignIdFor(PurchaseOrderLine::class)->nullable()->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->decimal('qty')->default(0);
            $table->decimal('price')->default(0);
            $table->decimal('subtotal')->virtualAs('qty * price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_lines');
    }
};
