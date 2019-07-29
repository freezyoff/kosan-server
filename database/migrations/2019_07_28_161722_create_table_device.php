<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("location_id");
			$table->unsignedBigInteger("chipset_id");
			$table->string("name", 50);
			$table->uuid("uuid")->unique()->nullable()->default(null);
			$table->string("mac")->unique();
			$table->string("os_hash");
			$table->string('api_token', 80)->unique()->nullable()->default(null);
			$table->text("state")->nullable()->default(null);
			
			$table->foreign('location_id')->references('id')->on('locations');
			$table->foreign('chipset_id')->references('id')->on('chipsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
