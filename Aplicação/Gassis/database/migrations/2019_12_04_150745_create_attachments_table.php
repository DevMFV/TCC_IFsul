<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAttachmentsTable.
 */
class CreateAttachmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachments', function(Blueprint $table) {

			$table->increments('id');
			
			$table->String('file',100);
			$table->string('name',200);
			$table->string('original_name',200);

			$table->unsignedInteger('owner_id')->nullable();

			$table->enum('owner_type',
			[
				'App\\\\Entities\\\\Demand',
				'App\\\\Entities\\\\User',
				'App\\\\Entities\\\\Evaluation',
				'App\\\\Entities\\\\Production'
			]);

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
		Schema::dropIfExists('attachments');
	}
}
