<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_types', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name')->unique();
			$table->timestamps();
		});
        Schema::table('users', function($table){
            $table->integer('user_type_id')->unsigned();
            $table->foreign('user_type_id')    
                ->references('id')->on('user_types')
                ->onUpdate('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table){
            $table->dropForeign('users_user_type_id_foreign');
            $table->dropColumn('user_type_id');
        });
		Schema::drop('user_types');
	}

}
