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

			$table->String('title', 50);
			$table->String('filename')->nullable();
			$table->date('data_prazo');
			

			// Assisted Datas
		
			$table->unsignedInteger('assistido_id')->nullable();

			// Requester Datas

			$table->unsignedInteger('solicitante_id')->unique();

			// Relations

			$table->foreign('assistido_id')->references('id')->on('users');
			$table->foreign('solicitante_id')->references('id')->on('users');


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
