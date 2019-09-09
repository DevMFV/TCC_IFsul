<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRequestersTable.
 */
class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {

			$table->increments('id');

			// People Datas

			$table->String('name', 50);
			$table->String('filename')->nullable();
			
			// Productor Datas

			$table->boolean('ocupado')->nullable();

			// Assisted Datas

			$table->date('birth')->nullable();
			$table->string('laudo')->nullable();
			$table->unsignedInteger('tipo_deficiencia_id')->nullable();

			// Requester Datas

			$table->unsignedInteger('tipo_solicitante_id')->nullable();

			// Auht Datas

			$table->String('email', 80)->unique();
			$table->String('password', 254)->nullable();
		
			// Permission

			/* 

				1 -> Assistido
				2 -> Solicitante
				3 -> Produtor
				4 -> Administrador

			*/

			$table->string('permission');

			// Relations

			$table->foreign('tipo_deficiencia_id')->references('id')->on('tipodeficiencia');
			$table->foreign('tipo_solicitante_id')->references('id')->on('tipo_solicitantes');


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

	//	Schema::table('users', function(Blueprint $table) {
	//		// apagar relacionamentos
	//	});

		// DROPA A TABELA
		Schema::dropIfExists('users');
	}
}
