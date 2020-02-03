<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddColumnPicture extends Migration
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
		DB::connection($this->connection)
			->statement("ALTER TABLE `users` ADD `picture_profile` MEDIUMBLOB AFTER `phone_number`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->table('users', function (Blueprint $table) {
            $table->dropColumn('picture_profile');
        });
    }
}
