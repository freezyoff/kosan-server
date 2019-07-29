<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bio', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->enum("type",["PERSON", "ORGANIZATION"]);
			$table->string("name_first", 25);
			$table->string("name_middle", 25);
			$table->string("name_last", 25);
			$table->string("address", 100);
			$table->string("postcode", 15);
			$table->string("phone1", 15);
			$table->string("phone2", 15);
			
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bio');
    }
}
