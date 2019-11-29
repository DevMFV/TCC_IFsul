<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTipoSolicitantesTable.
 */
class CreateTipoSolicitantesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_solicitantes', function(Blueprint $table) {
			
			$table->increments('id');
			
			$table->string('tipo');

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
		Schema::drop('tipo_solicitantes');
	}
}
