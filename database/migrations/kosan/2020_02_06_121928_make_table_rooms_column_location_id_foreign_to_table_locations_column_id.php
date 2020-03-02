<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableRoomsColumnLocationIdForeignToTableLocationsColumnId extends Migration
{
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
        $this->getSchema()->table('rooms', function (Blueprint $table) {
			$table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
		$this->getSchema()->table('rooms', function (Blueprint $table) {
			$table->dropForeign('rooms_location_id_foreign');
        });
	}
	
}
