<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRoomUsers extends Migration
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
        $this->getSchema()->create('room_users', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('room_id');
			
			// added on invoice group
			// $table->unsignedBigInteger('invoice_id');
			
			$table->timestamp('valid_after')->nullable()->default(null);
			$table->timestamp('valid_before')->nullable()->default(null);
			$table->integer('grace_periode')->comment('in seconds');
			
			$table->foreign('user_id')->references('id')->on('kosan_system.users');
			$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_users');
    }
}
