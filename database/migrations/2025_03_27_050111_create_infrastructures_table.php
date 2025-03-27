<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Road', 'Bridge', 'Culvert'])->default('Road');
            $table->string('name');
            $table->string('length')->nullable();
            $table->decimal('east_start_coordinate', 8, 6)->nullable();
            $table->decimal('north_start_coordinate', 8, 6)->nullable();
            $table->decimal('east_end_coordinate', 8, 6)->nullable();
            $table->decimal('north_end_coordinate', 8, 6)->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infrastructures');
    }
};
