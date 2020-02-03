<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableChipsetIo extends Migration
{
	protected $connection = "kosan_device";
	
	protected function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_DEVICE", $this->connection);
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('chipset_io', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('chipset_id');
			$table->enum('mode', ['NOT_SET', 'INPUT', 'OUTPUT', 'INPUT_PULLUP'])
				->default("NOT_SET")
				->comment("NOT_SET: -1, 'INPUT': 0, 'OUTPUT': 1, 'INPUT_PULLUP': 2");
			$table->unsignedTinyInteger("pin")->default("0")->comment("GPIO Pin Number");
			$table->enum("trigger_signal", ['LOW', 'HIGH'])
				->default("LOW")
				->comment("set to trigger state when signal match");
			$table->unsignedTinyInteger("trigger_target_pin")
				->nullable()
				->default(null)
				->comment("target pin when this pin on trigger state");
			$table->enum("trigger_target_signal", ['LOW', 'HIGH'])
				->nullable()
				->default(null)
				->comment("set target pin to this signal when this pin on trigger state");
			$table->unsignedSmallInteger("trigger_target_delay")
				->nullable()
				->default(null)
				->comment("delay before this pin triggering target pin");
				
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
        $this->getSchema()->dropIfExists('chipset_io');
    }
}
