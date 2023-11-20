<?php

use App\Enums\CartStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('hashed_id')->nullable()->default(null)->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('restaurant_id')->constrained();
            $table->decimal('total', 10, 2)->default(0);
            $table->boolean('is_paid')->default(0);
            $table->enum('status', CartStatus::getValues())->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
