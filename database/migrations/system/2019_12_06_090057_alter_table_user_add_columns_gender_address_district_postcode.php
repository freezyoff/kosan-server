<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddColumnsGenderAddressDistrictPostcode extends Migration
{
	protected $connection = "kosan_system";
	
	public function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_SYSTEM", $this->connection);
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->table('users', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('address_province');
            $table->dropColumn('address_regency');
            $table->dropColumn('address_district');
            $table->dropColumn('address_village');
            $table->dropColumn('address_address');
            $table->dropColumn('address_postcode');
            $table->dropColumn('phone_region');
            $table->dropColumn('phone_number');
        });
    }
}
