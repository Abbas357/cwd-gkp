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
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('office_id')->constrained();
            $table->foreignId('designation_id')->constrained();
            $table->enum('type', ['Appointment', 'Transfer', 'Promotion', 'Retirement', 'Termination'])->default('Appointment');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('order_number')->nullable();
            $table->text('remarks')->nullable();
            $table->index(['user_id', 'is_current']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
