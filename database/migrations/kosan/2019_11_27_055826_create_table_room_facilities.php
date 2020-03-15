<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRoomFacilities extends Migration
{
	protected $connection = "kosan_kosan";
	
	public function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_KOSAN", $this->connection);
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('room_facilities', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('room_id');
			$table->unsignedBigInteger('facility_id');
			$table->string('value');
			$table->enum('type', ['S','A','I'])->comment("S: Shared, A: Additional, I: Include");
			$table->double("additional_cost")->nullable()->comment("if column `type` value is 'A'");
			
			$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
			$table->foreign('facility_id')->references('id')->on('kosan_kosan.facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('room_facilities');
    }
}
