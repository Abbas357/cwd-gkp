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
        Schema::create('seniorities', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug')->nullable();
            $table->string('designation', 191)->nullable();
            $table->string('bps', 191)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('seniority_date')->nullable()->default(null);
            $table->timestamp('published_at')->nullable()->default(null);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seniorities');
    }
};