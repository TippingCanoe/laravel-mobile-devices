<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddOwner extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		//
		// Core Schema
		//

		Schema::table('device', function (Blueprint $table) {

			$table
				->string('owner_type')
				->nullable()
			;

			$table
				->integer('owner_id')
				->unsigned()
				->nullable()
			;

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table('device', function (Blueprint $table) {
			$table->dropColumn('owner_type');
			$table->dropColumn('owner_id');
		});

	}

}