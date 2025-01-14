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
        Schema::create('e_standardizations', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('specification_details');
            $table->string('firm_name');
            $table->string('address');
            $table->string('mobile_number');
            $table->string('phone_number');
            $table->string('email');
            $table->enum('locality', ['Local', 'Foreign'])->default('Local');
            $table->string('ntn_number');
            $table->enum('location_type', ['Factory', 'Warehouse'])->default('Factory');
            $table->enum('status', ['new', 'approved', 'rejected'])->default('new');
            $table->text('rejection_reason');
            $table->timestamp('card_issue_date')->nullable();
            $table->timestamp('card_expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_standardizations');
    }
};
