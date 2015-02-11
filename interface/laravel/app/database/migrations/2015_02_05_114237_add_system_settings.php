<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('system_settings', function($table){
            $table->float('alert_velocity')->default(2.0);
            $table->float('alert_resend')->default(24);
            $table->float('critical_resend')->default(12);
        });
        Schema::table('notifications', function($table){
            $table->renameColumn('type', 'class');
            $table->renameColumn('title', 'type');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('system_settings', function($table){
            $table->dropColumn('alert_velocity');
            $table->dropColumn('alert_resend');
            $table->dropColumn('critical_resend');
        });
        Schema::table('notifications', function($table){
            $table->renameColumn('type', 'title');
            $table->renameColumn('class', 'type');
        });
	}

}
