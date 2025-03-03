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
            $table->string('type')->nullable(); // Type of machinery (excavator, crane, generator, etc.)
            $table->string('operational_status')->nullable(); // Instead of 'functional_status'
            $table->string('manufacturer')->nullable(); // Instead of 'brand'
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable(); // Instead of 'chassis_number'
            $table->string('power_source')->nullable(); // Instead of 'fuel_type' (electric, diesel, hydraulic)
            $table->string('power_rating')->nullable(); // New field for machinery (HP, kW)
            $table->string('manufacturing_year')->nullable(); // Instead of 'model_year'
            $table->integer('operating_hours')->nullable(); // New field for machinery
            $table->date('last_maintenance_date')->nullable(); // New field for machinery
            $table->date('next_maintenance_date')->nullable(); // New field for machinery
            $table->string('location')->nullable(); // New field for machinery
            $table->decimal('hourly_cost', 10, 2)->nullable(); // New field for machinery
            $table->string('asset_tag')->nullable(); // New field for machinery tracking
            $table->string('certification_status')->nullable(); // New field for safety certifications
            $table->text('specifications')->nullable(); // New field for technical specs
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // who added the item: user_id
            $table->timestamps();
        });
        
        Schema::create('machinery_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('purpose')->nullable(); // Instead of 'type'
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->unsignedBigInteger('machinery_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable(); // New field for project allocation
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
