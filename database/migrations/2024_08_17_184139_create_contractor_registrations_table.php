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
            $table->string('mobile_number', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cnic', 45)->nullable();
            $table->string('owner_name', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('pec_number', 100)->nullable();
            $table->string('category_applied', 45)->nullable();
            $table->string('contractor_name', 100)->nullable();
            $table->string('pec_category', 45)->nullable();
            $table->string('fbr_ntn', 45)->nullable();
            $table->string('kpra_reg_no', 45)->nullable();
            $table->string('pre_enlistment')->nullable();
            $table->string('is_limited', 45)->default('no');
            $table->enum('status', ['new', 'deffered_one', 'deffered_two', 'deffered_three', 'approved'])->default('new');
            $table->text('deffered_reason')->nullable();
            $table->string('reg_no', 45)->nullable();
            $table->string('password', 100)->nullable();
            $table->timestamp('card_issue_date')->nullable()->default(null);
            $table->timestamp('card_expiry_date')->nullable()->default(null);
            $table->timestamp('password_updated_at')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('contractor_human_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('cnic_number')->nullable();
            $table->string('pec_number')->nullable();
            $table->string('designation')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create('contractor_machinery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('model')->nullable();
            $table->string('registration')->nullable();
            $table->timestamps();
        });

        Schema::create('contractor_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
            $table->string('adp_number')->nullable();
            $table->string('project_name')->nullable();
            $table->decimal('project_cost', 12, 2)->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('status', ['completed', 'ongoing'])->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contractors');
        Schema::dropIfExists('contractor_hr_profiles');
        Schema::dropIfExists('contractor_machinery');
        Schema::dropIfExists('contractor_work_experiences');
    }
};
