<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChipsetSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chipset_io', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("chipset_id");
			$table->tinyInteger("pin")
				->unique()
				->comment("GPIO Pin number");
			$table->enum("mode", ["NOT_SET", "INPUT", "OUTPUT", "INPUT_PULLUP"])
				->default("INPUT")
				->comment(
					"NOT_SET: -1 " .
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
			
			$table->foreign('chipset_id')->references('id')->on('chipsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chipset_io');
    }
}
