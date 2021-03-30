<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDevicesAddColumnLastConnected extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('kosan_device')
			->table('devices', function (Blueprint $table) {
				$table->timestamp("last_synced_at")
					->after("api_token_expired")
					->comment("terakhir sinkronisasi")
					->nullable()
					->default(null);
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('kosan_device')
			->table('devices', function (Blueprint $table) {
				$table->dropColumn("last_synced_at");
			});
    }
}
