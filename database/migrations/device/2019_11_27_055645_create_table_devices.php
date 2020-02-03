<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDevices extends Migration
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
        $this->getSchema()->create('devices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('chipset_id');
			$table->uuid('uuid')
				->nullable()
				->default(null);
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
    }
}
