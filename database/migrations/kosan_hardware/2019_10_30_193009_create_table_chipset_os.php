<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableChipsetOs extends Migration
{
	
	protected $connection = "kosan_hardware";
	
	protected function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_HARDWARE", $this->connection);
		return Schema::connection($this->connection);
	}
	
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('chipsets_os', function (Blueprint $table) {
			$table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('chipset_id');
			$table->string("hash")->unique();
			
			$table->foreign('chipset_id')->references('id')->on('chipsets');
		});
		
		DB::connection($this->connection)
			->statement("ALTER TABLE `chipsets_os` ADD `firmware` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chipsets_os');
    }
}
