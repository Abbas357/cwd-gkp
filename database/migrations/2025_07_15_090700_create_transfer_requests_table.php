<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Already Transferred', 'Request Transfer'])->default('Already Transferred');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_office_id')->nullable();
            $table->unsignedBigInteger('to_office_id')->nullable();
            $table->unsignedBigInteger('from_designation_id')->nullable();
            $table->unsignedBigInteger('to_designation_id')->nullable();
            $table->date('posting_date')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Pending', 'Under Review', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
