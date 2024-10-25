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
        Schema::create('contractor_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_number', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cnic', 45);
            $table->string('owner_name', 100);
            $table->string('district', 100);
            $table->string('address')->nullable();;
            $table->string('pec_number', 100);
            $table->string('category_applied', 45);
            $table->string('contractor_name', 100);
            $table->string('pec_category', 45);
            $table->string('fbr_ntn', 45)->nullable();
            $table->string('kpra_reg_no', 45)->nullable();
            $table->string('pre_enlistment')->nullable();
            $table->boolean('is_limited')->default(false);
            $table->string('cnic_front_attachment')->nullable();
            $table->string('cnic_back_attachment')->nullable();
            $table->string('fbr_attachment')->nullable();
            $table->string('kpra_attachment')->nullable();
            $table->string('pec_attachment')->nullable();
            $table->string('form_h_attachment')->nullable();
            $table->string('pre_enlistment_attachment')->nullable();
            $table->text('deffered_reason');
            $table->boolean('is_agreed')->default(false);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_registrations');
        Schema::dropIfExists('contractor_deferments');
    }
};
