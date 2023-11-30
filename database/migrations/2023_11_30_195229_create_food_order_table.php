<?php

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
        Schema::create('food_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->nullable()->constrained('foods');
            $table->foreignId('order_id')->constrained();
            $table->decimal('food_count');
            $table->decimal('price', 10, 2);
            $table->boolean('in_party')->default(0);
            $table->decimal('discount_percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_order');
    }
};
