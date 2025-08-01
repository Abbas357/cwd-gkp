<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_cards', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->enum('status', ['draft', 'pending', 'rejected', 'active', 'expired', 'lost', 'duplicate'])->default('draft');

            $table->dateTime('issued_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('printed_at')->nullable();
            $table->dateTime('status_updated_at')->nullable();

            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('posting_id')->nullable(); 

            $table->index('approval_status');
            $table->index('card_status');
            $table->index(['approval_status', 'card_status']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_cards');
    }
};
