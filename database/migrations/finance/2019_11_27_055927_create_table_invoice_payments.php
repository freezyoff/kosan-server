<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoicePayments extends Migration
{
	protected $connection = "kosan_finance";
	
	public function getSchema(){
		$this->connection = env("DB_DATABASE_KOSAN_FINANCE", $this->connection);
		return Schema::connection($this->connection);
	}
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('payments', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('invoices_id');
			$table->timestamp('date')->nullable()->default(null);
			$table->double('ammount');
			$table->enum('method',['cash','transfer']);
			$table->timestamp('approved_at')->nullable()->default(null);
			$table->unsignedBigInteger('approver_user_id');
			
			$table->foreign('invoices_id')->references('id')->on('invoices');
			$table->foreign('approver_user_id')->references('id')->on('kosan_system.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('payments');
    }
}
