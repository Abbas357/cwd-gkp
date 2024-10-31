<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_name', 191)->nullable();
            $table->text('description');
            $table->string('subject_type', 100);
            $table->unsignedBigInteger('subject_id');
            $table->nullableMorphs('causer', 'causer');
            $table->longText('properties')->nullable();
            $table->timestamps();
            $table->index(['subject_type', 'subject_id'], 'subject');
            $table->index('log_name');
        });
        
        
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
}
