<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTipoDeficienciasTable.
 */
class CreateTipoDeficienciasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_deficiencias', function(Blueprint $table) {

			$table->increments('id');
			$table->String('tipo');
			$table->Integer('codigo');

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
		Schema::dropIfExists('tipo_deficiencias');
	}
}
