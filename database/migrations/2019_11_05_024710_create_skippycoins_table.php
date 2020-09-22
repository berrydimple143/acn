<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkippycoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skippycoins', function (Blueprint $table) {
            $table->increments('id');
			$table->string('status', 5)->nullable()->default('off');
			$table->string('key', 254)->nullable()->default('');
			$table->string('customer_id', 30)->nullable()->default('');
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
        Schema::dropIfExists('skippycoins');
    }
}
