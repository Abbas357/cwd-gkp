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
        Schema::create('news_letters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_subscribed')->default(true);
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_token')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_info')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_letters');
    }
};
