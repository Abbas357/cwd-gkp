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
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 45)->nullable();
            $table->string('email', 100)->unique();
            $table->string('cnic', 15);
            $table->string('mobile_number', 15)->nullable();
            $table->string('district', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('pec_number', 100);
            $table->string('fbr_ntn', 45)->nullable();
            $table->enum('status', ['draft', 'rejected', 'approved'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('consultant_id')->references('id')->on('consultants')->onDelete('cascade');
            $table->string('firm_name', 45)->nullable();
            $table->string('password', 100);
            $table->enum('status', ['active', 'blacklisted', 'suspended', 'dormant'])->default('active');
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('consultant_human_resources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('cnic_number')->nullable();
            $table->string('pec_number')->nullable();
            $table->string('designation')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft', 'rejected', 'approved'])->default('draft');
            $table->text('remarks')->nullable();
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->foreignId('consultant_id')->references('id')->on('consultants')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
