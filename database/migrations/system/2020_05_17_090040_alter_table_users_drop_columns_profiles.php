<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersDropColumnsProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('kosan_system')->table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('address_province');
            $table->dropColumn('address_regency');
            $table->dropColumn('address_district');
            $table->dropColumn('address_village');
            $table->dropColumn('address_address');
            $table->dropColumn('address_postcode');
            $table->dropColumn('phone_region');
            $table->dropColumn('phone_number');
			$table->dropColumn('picture_idcard');
			$table->dropColumn('picture_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('kosan_system')->table('users', function (Blueprint $table) {
			$table->enum('gender', ["m","f"])->nullable()->default(null)->after("password");
			$table->string('address_province',20)->default("")->after("gender");
			$table->string('address_regency',20)->default("")->after("address_province");
			$table->string('address_district',20)->default("")->after("address_regency");
			$table->string('address_village',20)->default("")->after("address_district");
			$table->string('address_address')->default("")->after("address_village");
			$table->string('address_postcode',20)->default("")->after("address_address");
			$table->string('phone_region',5)->default("")->after("address_postcode");
			$table->string('phone_number',25)->default("")->after("phone_region");
        });
		
		DB::connection('kosan_system')
			->statement("ALTER TABLE `users` ADD `picture_idcard` MEDIUMBLOB AFTER `phone_number`");
			
		DB::connection('kosan_system')
			->statement("ALTER TABLE `users` ADD `picture_profile` MEDIUMBLOB AFTER `phone_number`");
    }
}
