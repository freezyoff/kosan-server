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
			$table->unsignedBigInteger('owner_user_id');
			$table->uuid("uuid")->unique();
			$table->string("name", 50);
			$table->string("address", 100);
			$table->string("postcode", 15);
			$table->string("phone", 15);
			$table->text("descriptions")->nullable()->default(null);
			$table->unsignedBigInteger("pic_user_id")->nullable()->default(null);
			
			$table->foreign('owner_user_id')->references('id')->on('users');
			$table->foreign('pic_user_id')->references('id')->on('users');
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
