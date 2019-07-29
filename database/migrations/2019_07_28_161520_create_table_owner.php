<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOwner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->uuid("uuid")->unique();
			$table->string("org_name", 50);
			$table->string("org_address", 100);
			$table->string("org_postcode", 15);
			$table->string("org_phone", 15);
			$table->string("org_phone_ext", 4)
				->nullable()
				->default(null)
				->comment("org_phone extension");
			$table->string("pic_name", 50);
			$table->string("pic_phone", 50);
			$table->string("pic_phone_ext", 4)
				->nullable()
				->default(null)
				->comment("org_phone extension");
			
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
        Schema::dropIfExists('owners');
    }
}
