<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 45)->nullable();
            $table->string('email', 100);
            $table->string('contact_number', 15)->nullable();
            $table->string('district_id')->nullable();
            $table->string('address')->nullable();
            $table->string('sector')->nullable();
            $table->date('order_date')->nullable();
            $table->string('pec_number', 100);
            $table->enum('status', ['draft', 'rejected', 'approved'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->text('remarks')->nullable();
            $table->string('password', 100);
            $table->timestamps();
        });

        Schema::create('consultant_human_resources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
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

        Schema::create('consultant_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('adp_number')->nullable();
            $table->string('scheme_code')->nullable();
            $table->string('district_id')->nullable();
            $table->string('estimated_cost')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'on_hold', 'cancelled'])->default('active');
            $table->longText('hr')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('consultant_id')->references('id')->on('consultants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultant_projects');
        Schema::dropIfExists('consultant_human_resources');
        Schema::dropIfExists('consultants');
    }
};
