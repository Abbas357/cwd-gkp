<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->string('is_limited', 45)->default('no');
            $table->enum('status', ['new', 'deffered_one', 'deffered_two', 'deffered_three', 'approved'])->default('new');
            $table->text('deffered_reason');
            $table->string('reg_no', 45)->nullable();
            $table->timestamp('card_issue_date')->nullable()->default(null);
            $table->timestamp('card_expiry_date')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contractor_registrations');
    }
};
