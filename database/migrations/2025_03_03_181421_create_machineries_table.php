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
        Schema::create('machineries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('operational_status')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('power_source')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->string('location')->nullable();
            $table->string('certification_status')->nullable();
            $table->text('specifications')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->timestamps();
        });
        
        Schema::create('machinery_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('purpose')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->unsignedBigInteger('machinery_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinery');
        Schema::dropIfExists('machinery_allocations');
    }
};
