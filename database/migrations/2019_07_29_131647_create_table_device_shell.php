<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDeviceShell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_shell', function (Blueprint $table) {
			$table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("user_id");
			$table->unsignedBigInteger("device_id");
			$table->boolean("cleared")->default(false)->comment("clear from screen");
			$table->boolean("executed")->default(false);
			$table->timestamp("executed_at")->nullable()->default(null);
			$table->boolean("confirmed")->default(false);
			$table->timestamp("confirmed_at")->nullable()->default(null);
			$table->text("shell");
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_shell');
    }
}
