<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('batch_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('make_id')->nullable();
            $table->string('year_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->double('price')->nullable();
            $table->string('steering')->nullable();
            $table->string('parish')->nullable();
            $table->string('district')->nullable();
            $table->string('description')->default('N\A');
            $table->string('milage')->default('N\A');
            $table->string('interior_color')->default('N\A');
            $table->string('exterior_color')->default('N\A');
            $table->string('doors')->nullable();
            $table->string('drive_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('negotiable')->nullable();
            $table->integer('added_by');
            $table->integer('isSold')->default(0);
            $table->integer('isNegotiable')->default(0);
            $table->integer('body_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}


