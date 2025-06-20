<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machineries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('functional_status')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('model_year')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
        
        Schema::create('machinery_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->unsignedBigInteger('machinery_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machinery');
        Schema::dropIfExists('machinery_allocations');
    }
};
