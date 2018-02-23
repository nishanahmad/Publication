<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMemberSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('member_subscriptions', function($table) {
			$table->smallInteger('renew');
			$table->smallInteger('jan');
			$table->smallInteger('feb');
			$table->smallInteger('mar');
			$table->smallInteger('apr');
			$table->smallInteger('may');
			$table->smallInteger('jun');
			$table->smallInteger('july');
			$table->smallInteger('aug');
			$table->smallInteger('sep');
			$table->smallInteger('oct');
			$table->smallInteger('nov');
			$table->smallInteger('dec');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
