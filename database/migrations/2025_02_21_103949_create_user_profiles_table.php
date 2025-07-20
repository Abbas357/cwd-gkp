<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->string('personnel_number')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('present_address')->nullable();
            $table->string('mark_of_identification')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('featured_on')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps(); 
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
