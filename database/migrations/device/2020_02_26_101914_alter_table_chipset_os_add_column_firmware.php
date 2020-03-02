<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTableChipsetOsAddColumnFirmware extends Migration
{
    protected $connection = "kosan_device";
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::connection($this->connection)->statement("ALTER TABLE chipset_os ADD firmware MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::connection($this->connection)->statement("ALTER TABLE chipset_os DROP COLUMN firmware");
    }
}
