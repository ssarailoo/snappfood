<?php

use App\Enums\OrderStauts;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('hashed_id')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('discount_id')->nullable()->default(null)->constrained();
            $table->foreignId('restaurant_id')->constrained();
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('status', OrderStauts::getValues())->nullable()->default(OrderStauts::CHECKING->value);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
