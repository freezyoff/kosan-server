<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('kosan_system')->create('user_profiles', function (Blueprint $table) {
            $table->timestamps();
			$table->unsignedBigInteger("id");
			$table->string("id_number")->comment("nik, passport, sim");
			$table->enum('gender', ["m","f"])->nullable()->default(null);
			$table->string('address_province',20)->nullable()->default(null);
			$table->string('address_regency',20)->nullable()->default(null);
			$table->string('address_district',20)->nullable()->default(null);
			$table->string('address_village',20)->nullable()->default(null);
			$table->string('address_address')->nullable()->default(null);
			$table->string('address_postcode',20)->nullable()->default(null);
			$table->string('phone_region',5)->nullable()->default(null);
			$table->string('phone_number',25)->nullable()->default(null);
			
			$table->primary('id');
			$table->foreign('id')->references('id')->on('kosan_system.users');
        });
		
		DB::connection('kosan_system')
			->statement("ALTER TABLE `user_profiles` ADD `picture_idcard` MEDIUMBLOB AFTER `phone_number`");
			
		DB::connection('kosan_system')
			->statement("ALTER TABLE `user_profiles` ADD `picture_profile` MEDIUMBLOB AFTER `phone_number`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('kosan_system')->dropIfExists('user_profiles');
    }
}
