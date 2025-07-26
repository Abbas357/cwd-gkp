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
            $table->enum('document_type', ['letter', 'notification', 'report', 'seniority_list', 'merit_list', 'invoice', 'memo', 'contract', 'policy'])->default('letter');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('document_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->unsignedBigInteger('posting_id')->nullable();      
            $table->unsignedBigInteger('published_by')->nullable();       
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secure_documents');
    }
};
