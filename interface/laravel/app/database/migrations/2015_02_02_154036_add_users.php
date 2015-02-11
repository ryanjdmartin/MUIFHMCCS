<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::table('users')->insert(array(
			'email'=> 'test@mail.com',
			'password'=>'password',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s'),
			'user_type_id'=>1
			));
		DB::table('users')->insert(array(
			'email'=> 'test2@mail.com',
			'password'=>'password',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s'),
			'user_type_id'=>1
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
		DB::table('users')->where('password', '=', 'password')->delete();
	}

}
