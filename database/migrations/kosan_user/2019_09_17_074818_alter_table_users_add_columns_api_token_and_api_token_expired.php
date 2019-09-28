<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddColumnsApiTokenAndApiTokenExpired extends Migration
{
	protected $connection = "kosan_user";
	
	public function getSchema(){
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
            $table->string('api_token')->nullable()->default(null);
			$table->timestamp('api_token_expired')->nullable()->default(null);
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
            $table->dropColumn('api_token');
			$table->dropColumn('api_token_expired');
        });
    }
}
