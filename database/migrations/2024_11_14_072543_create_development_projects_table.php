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
        Schema::create('development_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('introduction')->nullable();
            $table->date('commencement_date')->nullable();
            $table->string('total_cost')->nullable();
            $table->foreignId('district_id')->constrained('districts');
            $table->string('work_location')->nullable();
            $table->foreignId('ce_id')->constrained('users')->nullable();
            $table->foreignId('se_id')->constrained('users')->nullable();
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->string('progress_percentage')->nullable();
            $table->enum('status', ['Draft', 'In-Progress', 'On-Hold', 'Completed'])->default('In-Progress');    
            $table->date('year_of_completion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('development_projects');
    }
};
