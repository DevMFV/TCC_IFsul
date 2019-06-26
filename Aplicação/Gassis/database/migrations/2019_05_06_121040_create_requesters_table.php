<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRequestersTable.
 */
class CreateRequestersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requesters', function(Blueprint $table) {

			$table->increments('id');

			//People Datas 
			$table->String('name', 50);
			$table->date('birth')->nullable();
			$table->String('filename')->nullable();

			//Auht Datas
			$table->String('email', 80)->unique();
			$table->String('password', 254)->nullable();
		
			//Permission
			$table->String('status')->default('active');
			$table->String('permission')->default('1');

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

		Schema::table('requesters', function(Blueprint $table) {
			// apagar relacionamentos
		});

		// DROPA A TABELA
		Schema::drop('requesters');
	}
}
