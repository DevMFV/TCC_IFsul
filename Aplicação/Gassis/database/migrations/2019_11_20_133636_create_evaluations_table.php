<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEvaluationsTable.
 */
class CreateEvaluationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('evaluations', function(Blueprint $table) {

			$table->increments('id');
			$table->string('observacao',2000)->nullable();
			$table->boolean('atual')->default(true);
			
			# Production Data
			//=================================================================================================

			$table->unsignedInteger('production_id')->nullable();

			# Relation
			$table->foreign('production_id')->references('id')->on('productions')->onDelete('SET NULL');

			//=================================================================================================

			# Assisted Data
			//=================================================================================================

			$table->unsignedInteger('assisted_id');

			# Relation
			$table->foreign('assisted_id')->references('id')->on('users')->onDelete('SET NULL');

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
		Schema::dropIfExists('evaluations');
	}
}
