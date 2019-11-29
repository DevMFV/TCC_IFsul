<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDemandsTable.
 */
class CreateDemandsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('demands', function(Blueprint $table) {

			$table->increments('id');

			// Demand Datas

			$table->String('titulo', 50);
			$table->String('descricao', 1000)->nullable();
			$table->date('data_pedido')->nullable();
			$table->date('data_prazo')->nullable();
			$table->String('filename')->nullable();
			$table->boolean('produzindo')->nullable();
			$table->String('urgencia');

		
			// Requester Datas

			$table->unsignedInteger('requester_id')->nullable();

			// Assisted Datas

			$table->unsignedInteger('assisted_id')->nullable();

			// Relations

			$table->foreign('requester_id')->references('id')->on('users');
			$table->foreign('assisted_id')->references('id')->on('users');


			$table->String('status')->default('active');
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

	//	Schema::table('demands', function(Blueprint $table) {
	//		// apagar relacionamentos
	//	});

		// DROPA A TABELA
		Schema::dropIfExists('demands');
	}
}
