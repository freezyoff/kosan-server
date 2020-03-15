<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDeviceChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("kosan_device")->create('device_channels', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->string("name");
			$table->unsignedBigInteger("device_id");
			$table->unsignedBigInteger("door_sensor_io_id");
			$table->unsignedBigInteger("lock_relay_io_id");
			
			$table->foreign('device_id')->references('id')->on('devices');
			$table->foreign('door_sensor_io_id')->references('id')->on('chipset_io');
			$table->foreign('lock_relay_io_id')->references('id')->on('chipset_io');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("kosan_device")->dropIfExists('device_channels');
    }
}
