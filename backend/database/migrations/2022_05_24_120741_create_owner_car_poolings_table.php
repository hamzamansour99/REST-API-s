<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerCarPoolingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_car_poolings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('car_id');
            $table->text('pooling_id');
            $table->string('car_capacity');
            $table->date('required_date');
            $table->time('required_time');
            $table->text('comment')->nullable();
            $table->boolean('smoking');
            $table->boolean('ac');
            $table->boolean('only_girls');
            $table->decimal('current_longitude', 10, 7);
            $table->decimal('current_latitude', 10, 7);
            $table->decimal('destination_longitude', 10, 7);
            $table->decimal('destination_latitude', 10, 7);

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
        Schema::dropIfExists('owner_car_poolings');
    }
}
