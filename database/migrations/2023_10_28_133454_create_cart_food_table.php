<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->nullable()->constrained('foods')->cascadeOnDelete();
            $table->boolean('in_party')->default(0);
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('order_id')->nullable()->default(null);
            $table->decimal('food_count');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_food');
    }
};
