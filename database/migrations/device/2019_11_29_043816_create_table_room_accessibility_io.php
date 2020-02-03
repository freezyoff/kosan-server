<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRoomAccessibilityIo extends Migration
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
		// move relation to table room_accessibility_io below
		$this->getSchema()->table('room_accessibilities', function(Blueprint $table){
			$table->dropForeign(['door_chipset_io_id']);
			$table->dropColumn('door_chipset_io_id');
			
			$table->dropForeign(['lock_chipset_io_id']);
			$table->dropColumn('lock_chipset_io_id');
		});
		
        $this->getSchema()->create('room_accessibility_io', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("room_accessibility_id");
			$table->unsignedBigInteger("door_chipset_id");
			$table->unsignedBigInteger("lock_chipset_id");
			
			$table->foreign('room_accessibility_id')->references('id')->on('room_accessibilities');
			$table->foreign('door_chipset_id')->references('id')->on('chipset_io');
			$table->foreign('lock_chipset_id')->references('id')->on('chipset_io');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('room_accessibility_io');
		
		// rollback relation to table room_accessibilities
		$this->getSchema()->table('room_accessibilities', function(Blueprint $table){
			$table->unsignedBigInteger('door_chipset_io_id');
			$table->foreign('door_chipset_io_id')->references('id')->on('chipset_io');
			
			$table->unsignedBigInteger('lock_chipset_io_id');
			$table->foreign('lock_chipset_io_id')->references('id')->on('chipset_io');
		});
    }
}
