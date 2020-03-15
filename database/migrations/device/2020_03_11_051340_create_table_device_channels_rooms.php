<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDeviceChannelsRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("kosan_device")->create('device_channels_rooms', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->string("name");
			$table->unsignedBigInteger("room_id");
			$table->unsignedBigInteger("device_channel_id");
			
			$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
			$table->foreign('device_channel_id')->references('id')->on('device_channels');
        });	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("kosan_device")->dropIfExists('device_channels_rooms');
    }
}
