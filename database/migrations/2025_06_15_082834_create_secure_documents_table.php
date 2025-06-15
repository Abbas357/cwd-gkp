<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secure_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('document_type', 100)->index(); // 'letter', 'report', 'notification', 'seniority_list', 'merit_list', etc.
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('document_number')->unique()->nullable();
            $table->date('issue_date')->nullable();
            $table->string('posting_id')->nullable();      
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');     
            $table->timestamp('published_at')->nullable();
            $table->foreignId('published_by')->nullable()->constrained('users');       
            $table->timestamps();
            $table->index(['document_type', 'status']);
            $table->index(['issue_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secure_documents');
    }
};
