<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRequestersTable.
 */
class CreateAdminsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table) {

			$table->increments('id');

			// People Datas

			$table->String('name', 50);
			$table->String('filename')->nullable();
			
			// Productor Data

			// Assisted Data

			// Auht Datas

			$table->String('email', 80)->unique();
			$table->String('password', 254)->nullable();
		
			// Permission

			/* 

				1 -> Assistido
				2 -> Solicitante
				3 -> Produtor
				4 -> Admin  

			*/

			$table->String('status')->default('active');
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();  



			/* 

				ADD DEPOIS

					$table->date('birth')->nullable();
					$table->boolean('ocupado')->nullable();
					$table->string('laudo')->nullable();
					$table->int('permission')->default(1);

			*/

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	//	Schema::table('admins', function(Blueprint $table) {
	//		// apagar relacionamentos
	//	});

		// DROPA A TABELA
		Schema::dropIfExists('admins');
	}
}
