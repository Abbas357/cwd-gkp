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

            $table->enum('approval_status', ['draft', 'verified', 'rejected'])->nullable();
            $table->enum('card_status', ['active', 'expired', 'revoked', 'lost', 'reprinted'])->default('active');

            $table->dateTime('status_updated_by')->nullable();
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('printed_at')->nullable();

            $table->boolean('is_duplicate')->default(0);
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_cards');
    }
};
