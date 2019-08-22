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

			//People Datas -v

			$table->String('name', 50);
			$table->String('filename')->nullable();

			//Auht Datas
			$table->String('email', 80)->unique();
			$table->String('password', 254)->nullable();
		
			//Permission
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
