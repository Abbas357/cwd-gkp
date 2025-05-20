<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('functional_status')->nullable();
            $table->string('name')->nullable();
            $table->text('specifications')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('acquisition_type')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_allotments', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->boolean('is_current')->default(false);
            $table->index('asset_id');
            $table->index('user_id');
            $table->index('office_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_allotments');
    }
};
