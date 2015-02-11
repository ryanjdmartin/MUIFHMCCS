<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFumeHoods extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//B1-Room1
		DB::table('fume_hoods')->insert(array(
				'name'=>'hood1',
				'room_id'=>1,
				'model'=>'FX20',
				'install_date'=>date('Y-m-d H:m:s'),
				'maintenence_date'=>date('Y-m-d H:m:s'),
				'notes'=>'',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		DB::table('fume_hoods')->insert(array(
				'name'=>'hood2',
				'room_id'=>1,
				'model'=>'FX20',
				'install_date'=>date('Y-m-d H:m:s'),
				'maintenence_date'=>date('Y-m-d H:m:s'),
				'notes'=>'',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		//B1-Room2
		DB::table('fume_hoods')->insert(array(
				'name'=>'hood3',
				'room_id'=>2,
				'model'=>'FX20',
				'install_date'=>date('Y-m-d H:m:s'),
				'maintenence_date'=>date('Y-m-d H:m:s'),
				'notes'=>'',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		//B2-Room1
		DB::table('fume_hoods')->insert(array(
				'name'=>'hood4',
				'room_id'=>4,
				'model'=>'FX20',
				'install_date'=>date('Y-m-d H:m:s'),
				'maintenence_date'=>date('Y-m-d H:m:s'),
				'notes'=>'',
				'created_at'=>date('Y-m-d H:m:s'),
				'updated_at'=>date('Y-m-d H:m:s')
			));
		//B3-Room1
		DB::table('fume_hoods')->insert(array(
				'name'=>'hood5',
				'room_id'=>6,
				'model'=>'FX20',
				'install_date'=>date('Y-m-d H:m:s'),
				'maintenence_date'=>date('Y-m-d H:m:s'),
				'notes'=>'',
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
		DB::table('fume_hoods')->where('model', '=', 'FX20')->delete();
	}

}
