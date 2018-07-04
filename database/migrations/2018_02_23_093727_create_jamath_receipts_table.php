<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJamathReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jamath_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jamath_id');			
			$table->mediumInteger('year');			
			$table->integer('amount');
			$table->string('remarks',255)->nullable();
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
        Schema::dropIfExists('jamath_receipts');
    }
}
