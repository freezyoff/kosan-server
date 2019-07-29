<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('owner_id');
			$table->uuid("uuid")->unique();
			$table->string("loc_name", 50);
			$table->string("loc_address", 100);
			$table->string("loc_postcode", 15);
			$table->string("loc_phone", 15);
			$table->string("loc_phone_ext", 4)
				->nullable()
				->default(null)
				->comment("loc_phone extension");
			$table->string("pic_name", 50);
			$table->string("pic_phone", 50);
			$table->string("pic_phone_ext", 4)
				->nullable()
				->default(null)
				->comment("pic_phone extension");
			
			$table->foreign('owner_id')->references('id')->on('owners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
