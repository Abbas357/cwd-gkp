<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('office')->nullable();
            $table->string('office_type')->nullable();
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('functional_status')->nullable();
            $table->string('color')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('model_year')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
