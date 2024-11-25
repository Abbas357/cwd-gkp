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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username', 191)->unique();
            $table->string('cnic')->nullable();
            $table->string('email', 191)->unique();
            $table->string('mobile_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('designation')->nullable();
            $table->string('position')->nullable();
            $table->string('office')->nullable();
            $table->string('title')->nullable();
            $table->string('bps')->nullable();
            $table->enum('posting_type', ['appointment', 'transfer'])->nullable();
            $table->date('posting_date')->nullable();
            $table->enum('exit_type', ['transfer', 'retired'])->nullable();
            $table->date('exit_date')->nullable();
            $table->string('otp')->nullable();
            $table->enum('status', ['Inactive', 'Active', 'Archived'])->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_featured')->default(0);        
            $table->string('password');
            $table->timestamp('password_updated_at')->nullable();
            $table->rememberToken();
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

        Schema::create('user_hierarchy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('boss_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_hierarchy');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
