<?php

use App\Enums\PurchaseOrderStatus;
use App\Models\Supplier;
use App\Models\User;
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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->foreignIdFor(User::class, 'updated_by')->constrained();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained();
            $table->string('code')->unique();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->string('status')->default(PurchaseOrderStatus::DRAFT);
            $table->date('order_date')->default(now());
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
