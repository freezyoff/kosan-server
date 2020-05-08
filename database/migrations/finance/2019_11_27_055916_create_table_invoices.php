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
			$table->unsignedBigInteger('biller_user_id')->comment("yang membayar invoice");
			
			//invoice date info
			$table->timestamp('issue_date')
				->nullable()
				->default(null)
				->comment("tanggal invoice dibuat");
			$table->timestamp('due_date')
				->nullable()
				->default(null)
				->comment("tanggal jatuh tempo invoice");
			$table->unsignedInteger('grace_periode')
				->nullable()
				->default(null)
				->comment("tenggat waktu invoice dalam satuan hari");
			
			//invoice ammount info
			$table->double('ammount');
			$table->double('tax');
			$table->double('discount');
			$table->string('description');
			
			$table->foreign('biller_user_id')->references('id')->on('kosan_system.users');
			
        });
		
		$this->getSchema()->create('devices_invoices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("invoice_id");
			$table->unsignedBigInteger("device_id");
			$table->timestamp('subscription_start')->nullable()->default(null);
			$table->timestamp('subscription_end')->nullable()->default(null);
			
			$table->foreign('invoice_id')->references('id')->on('kosan_finance.invoices');
			$table->foreign('device_id')->references('id')->on('kosan_device.devices');
        });
		
		$this->getSchema()->create('rooms_invoices', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger("invoice_id");
			$table->unsignedBigInteger("room_id");
			$table->timestamp('subscription_start')->nullable()->default(null);
			$table->timestamp('subscription_end')->nullable()->default(null);
			
			$table->foreign('invoice_id')->references('id')->on('kosan_finance.invoices');
			$table->foreign('room_id')->references('id')->on('kosan_kosan.rooms');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$this->getSchema()->dropIfExists('devices_invoices');
		$this->getSchema()->dropIfExists('rooms_invoices');
		$this->getSchema()->dropIfExists('invoices');
    }
}
