<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDeviceIo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_io', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('device_id');
			$table->tinyInteger("pin")
				->comment("GPIO Pin number");
			$table->enum("mode", ["INPUT", "OUTPUT", "INPUT_PULLUP"])
				->default("INPUT")
				->comment(
					"INPUT: 0 " .
					"OUTPUT: 1" .
					"INPUT_PULLUP: 2"
				);
			$table->enum("type", ["SENSOR", "RELAY"])
				->default("SENSOR")
				->comment(
					"SENSOR: 0 " .
					"RELAY: 1 "
				);
			$table->enum("trigger", ["LOW", "HIGH"])
				->default("LOW")
				->comment(
					"LOW: 0 " .
					"HIGH: 1"
				);
			$table->tinyInteger("target_pin")
				->nullable()
				->default(null)
				->comment("GPIO target pin number");
			$table->enum("target_signal", ["LOW", "HIGH"])
				->nullable()
				->default(null)
				->comment(
					"LOW: 0 " .
					"HIGH: 1"
				);
			$table->integer("target_trigger_delay")
				->nullable()
				->default(null)
				->comment("in milli seconds");
				
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
        Schema::dropIfExists('device_io');
    }
}
