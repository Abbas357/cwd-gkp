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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('slug', 191)->unique();
            $table->mediumText('description')->nullable();
            $table->string('procurement_entity', 191)->nullable();;
            $table->timestamp('date_of_advertisement')->nullable();
            $table->timestamp('closing_date')->nullable();
            $table->string('domain', 191)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('published_by')->constrained('users');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->boolean('comments_allowed')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
