<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAccessControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('kosan_device')
			->create('access_controls', function (Blueprint $table) {
				$table->timestamps();
				$table->bigIncrements('id');
				$table->unsignedBigInteger("room_id");
				$table->unsignedBigInteger("device_id");
				$table->unsignedBigInteger("sensor_io_id");
				$table->unsignedBigInteger("lock_io_id");
				
				$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
				$table->foreign('device_id')->references('id')->on('devices');
				$table->foreign('sensor_io_id')->references('id')->on('chipset_io');
				$table->foreign('lock_io_id')->references('id')->on('chipset_io');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('kosan_device')->dropIfExists('access_controls');
    }
}
