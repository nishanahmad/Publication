<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('members', function($table) {
			$table->Integer('house_id')->nullable();
			$table->string('group',20)->nullable();
			$table->Integer('income')->nullable();
			$table->Integer('chandha_aam')->nullable();
			$table->Integer('chandha_majlis')->nullable();
			$table->Integer('thahareek_e_jadid')->nullable();
			$table->Integer('waqf_e_jadid')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('users', function($table) {
			$table->dropColumn('house_id');
			$table->dropColumn('group',20);
			$table->dropColumn('income');
			$table->dropColumn('chandha_aam');
			$table->dropColumn('chandha_majlis');
			$table->dropColumn('thahareek_e_jadid');
			$table->dropColumn('waqf_e_jadid');
		});
    }
}
