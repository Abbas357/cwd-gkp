<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 45)->nullable();
            $table->string('email', 100)->unique();
            $table->string('cnic', 15);
            $table->string('mobile_number', 15)->nullable();
            $table->string('district', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('firm_name', 45)->nullable();
            $table->string('password', 100);
            $table->enum('status', ['active', 'blacklisted', 'suspended', 'dormant'])->default('active');
            $table->timestamp('status_updated_at')->nullable();
            // $table->foreignId('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('contractor_registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('pec_number', 100);
            $table->string('category_applied', 45)->nullable();
            $table->string('pec_category', 45)->nullable();
            $table->string('fbr_ntn', 45)->nullable();
            $table->string('kpra_reg_no', 45)->nullable();
            $table->string('pre_enlistment')->nullable();
            $table->string('is_limited', 45)->default('no');
            $table->enum('status', ['new', 'deffered_once', 'deffered_twice', 'deffered_thrice', 'approved'])->default('new');
            $table->timestamp('status_updated_at')->nullable();
            // $table->foreignId('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->text('deffered_reason')->nullable();
            $table->timestamp('card_issue_date')->nullable();
            $table->timestamp('card_expiry_date')->nullable();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('contractor_human_resources', function (Blueprint $table) {
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
            $table->timestamp('status_updated_at')->nullable();
            // $table->foreignId('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('contractor_machinery', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('model')->nullable();
            $table->string('registration')->nullable();
            $table->enum('status', ['draft', 'rejected', 'approved'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            // $table->foreignId('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('contractor_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('adp_number')->nullable();
            $table->string('project_name')->nullable();
            $table->decimal('project_cost', 12, 2)->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('project_status', ['completed', 'ongoing'])->nullable();
            $table->enum('status', ['draft', 'rejected', 'approved'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            // $table->foreignId('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contractors');
        Schema::dropIfExists('contractor_registrations');
        Schema::dropIfExists('contractor_hr_profiles');
        Schema::dropIfExists('contractor_machinery');
        Schema::dropIfExists('contractor_work_experiences');
    }
};
