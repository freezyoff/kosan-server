<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDeviceAccessibility extends Migration
{
	
	protected $connection = "kosan_accessibility";
	protected function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_ACCESSIBILITY", $this->connection);
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('devices_accessibilities', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("device_id")->comment("kosan hardware device");
			$table->unsignedTinyInteger("lock_pin")->default("0")->comment("device lock relay pin number");
			$table->unsignedTinyInteger("door_pin")->default("0")->comment("device door sensor pin number");
			$table->string("name", 100)->default("");
			
			$table->foreign('device_id')->references('id')->on('kosan_hardware.devices');
        });
		
		$this->getSchema()->create('users_accessibilities', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("device_accessibility_id")->comment("primary key table accessibilities");
			$table->unsignedBigInteger("user_id")->comment("primary key table kosan_user.users");
			$table->timestamp("valid_after")->nullable()->default(null);
			$table->timestamp("valid_before")->nullable()->default(null);
			
			$table->foreign('device_accessibility_id')->references('id')->on('devices_accessibilities');
			$table->foreign('user_id')->references('id')->on('kosan_system.users');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$this->getSchema()->dropIfExists('users_accessibilities');
		$this->getSchema()->dropIfExists('devices_accessibilities');
    }
}
