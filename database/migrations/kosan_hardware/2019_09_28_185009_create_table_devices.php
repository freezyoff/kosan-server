<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDevices extends Migration
{
	protected $connection = "kosan_hardware";
	
	protected function getSchema(){
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$this->getSchema()->create('chipsets', function (Blueprint $table) {
			$table->timestamps();
            $table->bigIncrements('id');
			$table->string("name", 100)->default("");
			$table->unsignedSmallInteger("used_io")->default(0);
		});
		
		$this->getSchema()->create('chipsets_io', function (Blueprint $table) {
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
		
		
        $this->getSchema()->create('devices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('chipset_id');
			$table->uuid('uuid');
			$table->macAddress('mac');
			$table->string('api_token', 80)
				->nullable()
				->default(null);
			$table->timestamp('api_token_expired')
				->nullable()
				->default(null);
			
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
        $this->getSchema()->dropIfExists('devices');
		$this->getSchema()->dropIfExists('chipsets_io');
		$this->getSchema()->dropIfExists('chipsets');
    }
}
