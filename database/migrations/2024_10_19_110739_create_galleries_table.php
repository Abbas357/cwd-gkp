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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->integer('total_items')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('published_at')->nullable()->default(null);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
