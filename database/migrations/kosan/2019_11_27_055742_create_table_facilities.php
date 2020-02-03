<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFacilities extends Migration
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
        $this->getSchema()->create('facilities', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->string("name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('facilities');
    }
}
