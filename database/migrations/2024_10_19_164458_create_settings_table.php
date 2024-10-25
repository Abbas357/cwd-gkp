<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Communication & Works Department, KP');
            $table->string('description')->default('Official Website of Communication and Works Department, Government of Khyber Pakhtunkhwa');
            $table->string('email')->default('cwd.gkp@gmail.com');
            $table->boolean('maintenance_mode')->default(false);
            $table->string('contact_phone')->default('091-9214039');
            $table->string('contact_address')->default('Civil Secretariat, Peshawar');
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->default('CWDKPGovt');
            $table->string('twitter')->default('CWDKPGovt');
            $table->string('youtube')->default('CWDKPGovt');
            $table->text('meta_description')->nullable();
            $table->string('secret_key')->nullable();
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
