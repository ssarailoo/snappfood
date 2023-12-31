<?php

use App\Enums\CommentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('parent_id')
                ->nullable()->default(null)->constrained('comments')->cascadeOnDelete();
            $table->string('content');
            $table->integer('score')->unsigned()->nullable()->default(null);
            $table->enum('status', CommentStatus::getValues())->default(CommentStatus::PENDING);
            $table->string('description')->nullable()->default(null);
            $table->boolean('reconsidered')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
