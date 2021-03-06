<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receipt_number',30)->unique() ->nullable();
			$table->mediumInteger('amount');
			$table->mediumInteger('year');
            $table->integer('member_id');
			$table->date('date') -> nullable();			
			$table->boolean('accepted');
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
        Schema::dropIfExists('receipts');
    }
}
