<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoices extends Migration
{
	public function getSchema($name=false){
		$con = env("DB_DATABASE_KOSAN_FINANCE", "kosan_finance");
		return Schema::connection($con);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('invoices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('issuer_user_id');
			$table->unsignedBigInteger('billed_to_user_id');
			$table->unsignedBigInteger('subscription_device_id');
			$table->unsignedBigInteger('subscription_room_id');
			$table->timestamp('subscription_start')->nullable()->default(null);
			$table->timestamp('subscription_end')->nullable()->default(null);
			$table->double('ammount');
			$table->double('tax');
			$table->double('discount');
			
			$table->foreign('issuer_user_id')->references('id')->on('kosan_system.users');
			$table->foreign('billed_to_user_id')->references('id')->on('kosan_system.users');
			$table->foreign('subscription_device_id')->references('id')->on('kosan_device.devices');
			$table->foreign('subscription_room_id')->references('id')->on('kosan_kosan.rooms');
        });
		
		Schema::connection('kosan_device')->table('room_accessibilities', function(Blueprint $table){
			$table->unsignedBigInteger('invoice_id')->after('id');
			$table->foreign('invoice_id')->references('id')->on('kosan_finance.invoices');
		});
		
		Schema::connection('kosan_kosan')->table('room_users', function(Blueprint $table){
			$table->unsignedBigInteger('invoice_id')->after('id');
			$table->foreign('invoice_id')->references('id')->on('kosan_finance.invoices');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::connection('kosan_device')->hasColumn('room_accessibilities', 'invoice_id')){
			
            Schema::connection('kosan_device')->table('room_accessibilities', function(Blueprint $table){
				$table->dropForeign(['invoice_id']);
				$table->dropColumn('invoice_id');
			});
			
        }
		
		if (Schema::connection('kosan_kosan')->hasColumn('room_users', 'invoice_id')){
			
            Schema::connection('kosan_kosan')->table('room_users', function(Blueprint $table){
				$table->dropForeign(['invoice_id']);
				$table->dropColumn('invoice_id');
			});
			
        }
		
        $this->getSchema()->dropIfExists('invoices');
    }
}
