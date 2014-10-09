<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePlatforms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('platform', function (Blueprint $table) {

			$table
				->increments('id')
				->unsigned()
			;

			$table->string('name');

			//
			//
			//

			$table->unique('name', 'U_name');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('platform');
	}

}