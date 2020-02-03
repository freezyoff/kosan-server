<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLocations extends Migration
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
        $this->getSchema()->create('locations', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('owner_user_id');
			$table->unsignedBigInteger('pic_user_id')
				->nullable()
				->default(null);
			$table->string('name', 100);
			$table->string('address');
			$table->string('postcode', 15);
			$table->string('phone', 20);
			
			$table->foreign('owner_user_id')->references('id')->on('kosan_system.users');
			$table->foreign('pic_user_id')->references('id')->on('kosan_system.users');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('locations');
    }
}
