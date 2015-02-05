<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuildings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::table('buildings')->insert(array(
				'name'=>'Building1',
				'abbv'=>'B1',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('buildings')->insert(array(
				'name'=>'Building2',
				'abbv'=>'B2',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('buildings')->insert(array(
				'name'=>'Building3',
				'abbv'=>'B3',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::table('building')->where('abbv', '=', 'B1')->delete();
		DB::table('building')->where('abbv', '=', 'B2')->delete();
		DB::table('building')->where('abbv', '=', 'B3')->delete();
	}

}
