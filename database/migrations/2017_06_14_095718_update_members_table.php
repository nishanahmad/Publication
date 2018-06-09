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
			$table->string('code',15)->unique();
			$table->string('address1') ->nullable();
			$table->string('address2')->nullable();
			$table->string('place')->nullable();
			$table->string('district')->nullable();
			$table->string('pin_code',10)->nullable();
			$table->string('rms',25) ->nullable();
			$table->string('landline',15)->nullable();
			$table->string('email')->unique()->nullable();
			$table->string('ref_name')->nullable();
			$table->string('ref_phone')->nullable();
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
		Schema::table('users', function($table) {
			$table->dropColumn('code');
			$table->dropColumn('address1');	
			$table->dropColumn('address2');
			$table->dropColumn('place');						
			$table->dropColumn('district');
			$table->dropColumn('pin_code');	
			$table->dropColumn('rms');
			$table->dropColumn('landline');
			$table->dropColumn('email');	
			$table->dropColumn('ref_name');
			$table->dropColumn('ref_phone');						
		});
    }
}
