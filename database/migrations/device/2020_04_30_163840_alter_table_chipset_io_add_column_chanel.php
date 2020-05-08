<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableChipsetIoAddColumnChanel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('kosan_device')
			->table('chipset_io', function (Blueprint $table) {
				$table->tinyInteger("chanel")
					->after("pin")
					->comment("kanal grup relay dan sensor")
					->default(1);
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
			->table('chipset_io', function (Blueprint $table) {
				$table->dropColumn("chanel");
			});
    }
}
