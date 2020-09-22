<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
			$table->string('email', 254);
            $table->string('firstname', 100)->nullable()->default('');
            $table->string('lastname', 100)->nullable()->default('');
            $table->string('verified', 5)->nullable()->default('no');
			$table->string('customer_id', 30)->nullable()->default('');
            $table->integer('email_list_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
