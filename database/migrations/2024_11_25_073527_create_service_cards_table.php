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
        Schema::create('service_cards', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('email', 191)->unique();
            $table->string('mobile_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('personnel_number')->nullable();
            $table->string('mark_of_identification')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('parmanent_address')->nullable();
            $table->string('present_address')->nullable();
            $table->string('designation')->nullable();
            $table->string('bps')->nullable();
            $table->string('office')->nullable();
            $table->timestamp('issue_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->enum('status', ['New', 'Verified', 'Rejected'])->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_cards');
    }
};
