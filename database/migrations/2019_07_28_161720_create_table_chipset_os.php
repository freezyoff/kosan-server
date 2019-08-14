<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChipsetOs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chipset_os', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("chipset_id");
			$table->string("version",10);
			$table->integer("firmware_size")->nullable()->default(null);
			$table->char("firmware_hash",32)->nullable()->default(null);
			//$table->binary('firmware_bin')->nullable()->default(null);
			$table->integer("filesystem_size")->nullable()->default(null);
			$table->char("filesystem_hash",32)->nullable()->default(null);
			//$table->binary('filesystem_bin')->nullable()->default(null);
			
			$table->foreign('chipset_id')->references('id')->on('chipsets');
        });
		
		DB::statement("ALTER TABLE `chipset_os` ADD `firmware_bin` MEDIUMBLOB AFTER `firmware_hash`");
		DB::statement("ALTER TABLE `chipset_os` ADD `filesystem_bin` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chipset_os');
    }
}
