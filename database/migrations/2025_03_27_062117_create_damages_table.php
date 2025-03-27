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
        Schema::create('damages', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->enum('type', ['Road', 'Bridge', 'Culvert'])->default('Road');
            $table->string('activity')->default('Monsoon');
            $table->integer('session')->default(date('Y'));
            $table->unsignedBigInteger('infrastructure_id')->nullable();
            $table->string('total_length')->nullable();
            $table->string('damaged_length')->nullable();
            $table->decimal('east_start_coordinate', 8, 6)->nullable();
            $table->decimal('north_start_coordinate', 8, 6)->nullable();
            $table->decimal('east_end_coordinate', 8, 6)->nullable();
            $table->decimal('north_end_coordinate', 8, 6)->nullable(); 
            $table->decimal('damage_east_start', 8, 6)->nullable();
            $table->decimal('damage_north_start', 8, 6)->nullable();
            $table->decimal('damage_east_end', 8, 6)->nullable();
            $table->decimal('damage_north_end', 8, 6)->nullable();
            $table->enum('damage_status', ['Partially Damaged', 'Fully Damaged'])->default('Partially Damaged');
            $table->string('damage_nature')->nullable();
            $table->decimal('approximate_restoration_cost')->nullable();
            $table->decimal('approximate_rehabilitation_cost')->nullable();
            $table->enum('road_status', ['Partially restored', 'Fully restored', 'Not restored'])->default('Partially restored');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->timestamps();
        });

        Schema::create('damage_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('damage_id')->nullable();
            $table->decimal('damage_east_start', 8, 6)->nullable();
            $table->decimal('damage_north_start', 8, 6)->nullable();
            $table->decimal('damage_east_end', 8, 6)->nullable();
            $table->decimal('damage_north_end', 8, 6)->nullable();
            $table->string('damage_status')->nullable();
            $table->string('damage_nature')->nullable();
            $table->decimal('approximate_restoration_cost')->nullable();
            $table->decimal('approximate_rehabilitation_cost')->nullable();
            $table->string('road_status');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damages');
        Schema::dropIfExists('damage_logs');
    }
};
