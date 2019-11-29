<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductionsTable.
 */
class CreateProductionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productions', function(Blueprint $table) {
			
			$table->increments('id');
			$table->String('filename')->nullable();
			$table->boolean('avaliada')->default(false);
			$table->String('descricao_suspensao')->nullable();


			# status Data
			//=================================================================================================

				$table->unsignedInteger('current_state_id')->nullable();

				# Relation
				$table->foreign('current_state_id')->references('id')->on('current_states')->onDelete('SET NULL');

			//=================================================================================================

			# Fase Data
			//=================================================================================================

				$table->unsignedInteger('fase_id');

				# Relation
				$table->foreign('fase_id')->references('id')->on('fase')->onDelete('SET NULL');

			//=================================================================================================


			# Poductor Data
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
			

			# Designation Data
			//=================================================================================================

				$table->unsignedInteger('designation_id')->nullable();

				# Relation
				//$table->foreign('designation_id')->references('id')->on('designations')->onDelete('SET NULL');

			//=================================================================================================


			# Suggestion Data
			//=================================================================================================

				$table->unsignedInteger('suggestion_id')->nullable();

				# Relation
				// $table->foreign('suggestion_id')->references('id')->on('suggestions')->onDelete('SET NULL');

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
		// DROPA A TABELA
		Schema::dropIfExists('productions');
	}
}
