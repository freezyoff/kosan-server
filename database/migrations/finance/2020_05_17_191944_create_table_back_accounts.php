<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBackAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::connection('kosan_finance')->create('banks', function(Blueprint $table){
			$table->string("code", 4);
			$table->string("name", 45);
			
			$table->primary("code");
		});
		
        Schema::connection('kosan_finance')->create('bank_accounts', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('owner_user_id');
			$table->string('name');
			$table->string("bank_code", 4);
			$table->string('bank_account', 25)->comment('nomor akun');
			$table->string('holder')->comment('account holder / atas nama akun');
			
			$table->foreign('owner_user_id')->references('id')->on('kosan_system.users');
			$table->foreign('bank_code')->references('code')->on('kosan_finance.banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('kosan_finance')->dropIfExists('bank_accounts');
        Schema::connection('kosan_finance')->dropIfExists('banks');
    }
}
