<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDevicesAddColumnOwnerUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("kosan_device")->table('devices', function (Blueprint $table) {
			$table->unsignedBigInteger("owner_user_id")->after("chipset_id")->default(1);
			$table->foreign("owner_user_id")->references("id")->on("kosan_system.users");
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
			$table->dropForeign('devices_owner_user_id_foreign');
			$table->dropColumn("owner_user_id");
        });
    }
}
