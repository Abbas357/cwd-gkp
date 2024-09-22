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
            $table->boolean('approval_status')->default(0);
            $table->timestamps();
        });

        Schema::create('e_standardization_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('s_id')->constrained('e_standardizations')->onDelete('cascade');
            $table->string('action')->nullable();
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->foreignId('action_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('action_at')->useCurrent();
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
