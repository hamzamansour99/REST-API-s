<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            // $table->foreignId('user_id')->constrained();
            $table->string('user_id');
            $table->text('car_id');
            $table->string('active');
            $table->string('car_number');
            $table->string('type');
            $table->string('category');
            $table->string('owner_id');
            $table->string('zip');
            $table->string('country');
            $table->string('state');
            $table->string('image');
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
