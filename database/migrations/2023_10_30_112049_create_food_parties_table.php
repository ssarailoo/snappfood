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
        Schema::create('food_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();
            $table->decimal('quantity');
            $table->decimal('discount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_parties');
    }
};
