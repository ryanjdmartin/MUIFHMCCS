<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTypesTableSeeder');
		$this->call('UserTableSeeder');
	}

}

class UserTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user_types')->delete();

        UserType::create(array('name' => 'user'));
        UserType::create(array('name' => 'admin'));
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array('email' => 'administrator@fms.mcmaster.ca', 
            'password' => Hash::make('admin'), 
            'user_type_id' => 2));
    }

}
