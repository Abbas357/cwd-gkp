<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('slug', 191)->unique();
            $table->text('summary')->nullable();
            $table->mediumText('content')->nullable();
            $table->string('category', 191)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable()->default(null);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
