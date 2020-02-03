<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRooms extends Migration
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
        $this->getSchema()->create('rooms', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("location_id");
			$table->string("name");
			$table->double("rate_dialy");
			$table->double("rate_weekly");
			$table->double("rate_monthly");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('rooms');
    }
}
