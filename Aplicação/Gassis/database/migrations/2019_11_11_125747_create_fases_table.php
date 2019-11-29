<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFasesTable.
 */
class CreateFasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fases', function(Blueprint $table) {

            $table->increments('id');
			
			$table->string('fase');

			$table->string('codigo');

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
		Schema::drop('fases');
	}
}
