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
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
            $table->integer('adp_number')->nullable();
            $table->string('scheme_code', 191)->unique();
            $table->string('scheme_name', 191)->nullable();
            $table->string('sector_name', 191)->nullable();
            $table->string('sub_sector_name', 191)->unique();
            $table->decimal('local_cost', 15, 3)->nullable();
            $table->decimal('foreign_cost', 15, 3)->nullable();
            $table->decimal('previous_expenditure', 15, 3)->nullable();
            $table->decimal('capital_allocation', 15, 3)->nullable();
            $table->decimal('revenue_allocation', 15, 3)->nullable();
            $table->decimal('total_allocation', 15, 3)->nullable();
            $table->decimal('f_allocation', 15, 3)->nullable();
            $table->decimal('tf', 15, 3)->nullable();
            $table->decimal('revised_allocation', 15, 3)->nullable();
            $table->decimal('prog_releases', 15, 3)->nullable();
            $table->decimal('progressive_exp', 15, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemes');
    }
};
