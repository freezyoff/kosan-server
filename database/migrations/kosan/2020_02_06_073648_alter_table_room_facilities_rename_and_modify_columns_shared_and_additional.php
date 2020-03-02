<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRoomFacilitiesRenameAndModifyColumnsSharedAndAdditional extends Migration
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
        $this->getSchema()->table('room_facilities', function (Blueprint $table) {
			$table->dropColumn('value');
			$table->dropColumn('shared');
			$table->dropColumn('additional');
			$table->string('varian');
			$table->enum('type', ['p','s','a'])->comment("p: private, s: shared, a: additional");
			$table->double("additional_cost")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$this->getSchema()->table('room_facilities', function (Blueprint $table) {
			$table->dropColumn('varian');
			$table->dropColumn('type');
			$table->dropColumn('additional_cost');
			$table->string('value');
			$table->tinyInteger('shared');
			$table->tinyInteger('additional');
        });
    }
}
