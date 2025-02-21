<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->string('username', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->timestamp('password_updated_at')->nullable();
            $table->enum('status', ['Inactive', 'Active', 'Archived'])->default('Active');
            $table->string('otp')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cnic')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->string('featured_on')->nullable();
            $table->timestamps();
        });

        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bps')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Archived'])->default('Active');
            $table->timestamps();
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('offices')->onDelete('set null');
            $table->enum('level', ['Provincial', 'Regional', 'Divisional', 'District', 'SubDivisional'])->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Archived'])->default('Active');
            $table->timestamps();
        });

        Schema::create('sanctioned_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained();
            $table->foreignId('designation_id')->constrained();
            $table->integer('total_positions');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

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

        Schema::create('hierarchies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boss_id')->constrained('postings');
            $table->foreignId('subordinate_id')->constrained('postings');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 191)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('designations');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('sanctioned_posts');
        Schema::dropIfExists('postings');
        Schema::dropIfExists('reporting_relationships');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
