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
            $table->string('module')->default('main');
            $table->string('key');
            $table->longText('value')->nullable();
            $table->string('type')->default('string');
            $table->text('description')->nullable();
            $table->string('group')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true); 
            $table->timestamps();
            
            $table->index(['module', 'key', 'type']);
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
