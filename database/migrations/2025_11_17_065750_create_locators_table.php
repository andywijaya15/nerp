<?php

use App\Models\Area;
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
        Schema::create('locators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->foreignIdFor(User::class, 'updated_by')->constrained();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained();
            $table->foreignIdFor(Area::class)->constrained();
            $table->boolean('is_active')->default(true);
            $table->string('code');
            $table->string('name');
            $table->unique(['area_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locators');
    }
};
