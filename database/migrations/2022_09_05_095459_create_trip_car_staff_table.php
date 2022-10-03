<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripCarStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_car_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('trip_id');
            $table->integer('staff_id');
            $table->integer('car_id');
            $table->integer('type_car_id');
            $table->integer('assistant_driver_id');
            $table->string('datetime');
            $table->integer('schedule_id');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('trip_car_staff');
    }
}
