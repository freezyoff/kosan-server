<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_docs', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->enum("type",["KTP", "NPWP", "AKTE PENDIRIAN", "PASSPORT"]);
			$table->string("reg_number", 50)->comment("nomor registrasi KTP/NPWP/AKTE PENDIRIAN/PASSPORT");
			$table->timestamp("issued_date")->nullable()->default(null);
			$table->string("issued_at", 50);
			$table->boolean("verified")->default(false);
			$table->unsignedBigInteger("verified_by")->nullable()->default(null)->comment("kosan pic verifier user_id");
			$table->timestamp("verified_at")->nullable()->default(null)->comment("date verified");
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('verified_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_docs');
    }
}
