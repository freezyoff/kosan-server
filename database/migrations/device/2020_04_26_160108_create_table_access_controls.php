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
				$table->string('name',100);
				$table->unsignedBigInteger("room_id")->nullable()->default(null);
				$table->unsignedBigInteger("device_id");
				$table->unsignedBigInteger("chanel");
				
				$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
				$table->foreign('device_id')->references('id')->on('devices');
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
