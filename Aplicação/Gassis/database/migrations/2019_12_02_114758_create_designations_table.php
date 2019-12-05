<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDesignationsTable.
 */
class CreateDesignationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('designations', function(Blueprint $table) {

			$table->increments('id');


			# Production Data
			//=================================================================================================

			$table->unsignedInteger('productor_id')->nullable();

			# Relation
			$table->foreign('productor_id')->references('id')->on('users')->onDelete('SET NULL');

			//=================================================================================================


			# Demand Data
			//=================================================================================================

			$table->unsignedInteger('demand_id')->nullable();

			# Relation
			$table->foreign('demand_id')->references('id')->on('demands')->onDelete('SET NULL');

			//=================================================================================================


			# Admin Data
			//=================================================================================================

			$table->unsignedInteger('admin_id');

			# Relation
			$table->foreign('admin_id')->references('id')->on('users')->onDelete('SET NULL');

			//=================================================================================================
			
			
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
		Schema::dropIfExists('designations');
	}
}
