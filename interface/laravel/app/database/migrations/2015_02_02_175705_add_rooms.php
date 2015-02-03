<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRooms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Building 1
		DB::table('rooms')->insert(array(
				'name'=>'B1-Room1',
				'contact'=>'Contact1',
				'building_id'=>1,
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('rooms')->insert(array(
				'name'=>'B1-Room1',
				'contact'=>'Contact2',
				'building_id'=>1,
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('rooms')->insert(array(
				'name'=>'B1-Room3',
				'contact'=>'Contact1',
				'building_id'=>2,
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		//Building 2
		DB::table('rooms')->insert(array(
				'name'=>'B2-Room1',
				'contact'=>'Contact2',
				'building_id'=>2,
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('rooms')->insert(array(
				'name'=>'B2-Room2',
				'contact'=>'Contact2',
				'building_id'=>2,
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		//Building 3
			DB::table('rooms')->insert(array(
				'name'=>'B3-Room1',
				'contact'=>'Contact3',
				'building_id'=>3,
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
		DB::table('rooms')->where('contact', '=', 'Contact1')->delete();
		DB::table('rooms')->where('contact', '=', 'Contact2')->delete();
		DB::table('rooms')->where('contact', '=', 'Contact3')->delete();
	}

}
