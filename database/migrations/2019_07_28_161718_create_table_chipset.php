<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChipset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chipsets', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->string("name", 50);
			$table->tinyInteger("pin_used")->comment("GPIO pin used by chipset for kosan os");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chipsets');
    }
}
