<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDevicesAddColumnName extends Migration
{
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("kosan_device")->table('devices', function (Blueprint $table) {
			$table->string("alias", 100)->after("mac")->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("kosan_device")->table('devices', function (Blueprint $table) {
			$table->dropColumn("alias");
        });
    }
}
