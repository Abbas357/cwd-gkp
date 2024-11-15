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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->dateTime('published_at')->nullable()->default(null);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->string('organizer')->nullable();
            $table->string('chairperson')->nullable();
            $table->string('participants_type')->nullable();
            $table->enum('participants_type', ['review_meeting', 'conference', 'workshop', 'seminar', 'webinar', 'training'])->nullable();
            $table->integer('no_of_participants')->nullable();
            $table->enum('event_type', ['review_meeting', 'conference', 'workshop', 'seminar', 'webinar', 'training'])->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
