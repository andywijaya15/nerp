<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->foreignIdFor(User::class, 'updated_by')->constrained();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained();
            $table->boolean('is_active')->default(true);
            $table->string('code')->unique();
            $table->string('name');
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('product_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
