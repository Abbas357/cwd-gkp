<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standardizations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('owner_name');
            $table->string('firm_name');
            $table->string('email', 100)->unique();
            $table->string('cnic', 15)->nullable()->unique();
            $table->string('mobile_number', 15)->nullable();
            $table->string('district', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('password', 100);
            $table->enum('status', ['draft', 'approved', 'rejected', 'blacklisted'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('specification_details');
            $table->enum('locality', ['Local', 'Foreign'])->default('Local');
            $table->string('ntn_number');
            $table->string('sale_tax_number');
            $table->enum('location_type', ['Factory', 'Warehouse', 'Store', 'Distribution Center'])->default('Factory');
            $table->enum('status', ['draft', 'approved', 'rejected'])->default('draft');
            $table->timestamp('status_updated_at')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('standardization_id')->references('id')->on('standardizations')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standardizations');
        Schema::dropIfExists('products');
    }
};
