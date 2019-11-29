<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCurrentStatesTable.
 */
class CreateCurrentStatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('current_states', function(Blueprint $table) {

			$table->increments('id');

			$table->string('state');

			$table->integer('codigo');

			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes(); 
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('current_states');
	}
}
