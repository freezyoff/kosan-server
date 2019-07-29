<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAccessibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//we prevent user to have direct access to table device_io,
		//we create this table as intermediate table access right
        Schema::create('accessibilities', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("device_io_id");
			$table->string("location_name", 100);
			$table->string("access_name", 100);
			$table->enum("type", ["READ", "WRITE"]);
			
			$table->foreign('device_io_id')->references('id')->on('device_io');
        });
		
		//we create this table to store user access validity
		Schema::create('users_accessibilities', function (Blueprint $table) {
            $table->timestamps();
			$table->unsignedBigInteger("user_id");
			$table->unsignedBigInteger("accessibility_id");
			$table->timestamp("valid_after")->nullable()->default(null)->comment("access valid for user after given date");
			$table->timestamp("valid_before")->nullable()->default(null)->comment("access valid for user before given date");
			//$table->enum("request", ["LOW", "HIGH"]);
			//$table->boolean("confirmed");
			
			$table->primary(["user_id", "accessibility_id"]);
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('accessibility_id')->references('id')->on('accessibilities');
        });
		
		//we create this table to store user access request
		//we make this table loose (transaction table), for performance
		Schema::create('users_accessibilities_request', function (Blueprint $table){
			$table->timestamps();
			$table->unsignedBigInteger("user_id");
			$table->unsignedBigInteger("accessibility_id");
			$table->enum("request", ["LOW", "HIGH"]);
			$table->boolean("executed")
				->comment("user access request executed by device");
			$table->timestamp("executed_at")
				->nullable()
				->default(null)
				->comment("time when user access request executed by device");
			$table->boolean("confirmed")
				->comment("device confirmed the execution of user access request");
			$table->timestamp("confirmed_at")
				->nullable()
				->default(null)
				->comment("time when device confirmed the execution of user access request");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('users_accessibilities_request');
		Schema::dropIfExists('users_accessibilities');
        Schema::dropIfExists('accessibilities');
    }
}
