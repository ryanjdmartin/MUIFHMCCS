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

		$this->call('SettingsTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('FumeHoodsTableSeeder');
	}

}

class SettingsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('system_settings')->delete();

        SystemSettings::create(array());
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        DB::table('user_types')->delete();

        UserType::create(array('id' => 1, 'name' => 'user'));
        UserType::create(array('id' => 2, 'name' => 'admin'));

        User::create(array('email' => 'administrator@fms.mcmaster.ca', 
            'password' => Hash::make('admin'), 
            'user_type_id' => 2));
    }

}

class FumeHoodsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('fume_hoods')->delete();
        DB::table('rooms')->delete();
        DB::table('buildings')->delete();

        Building::create(array('name' => 'AN Bourns Science Building',
            'abbv' => 'ABB'));
        Room::create(array('name' => '101',
            'contact' => 'lab_abb101@mcmaster.ca',
            'building_id' => 1));
        Room::create(array('name' => '102',
            'contact' => 'ex55555',
            'building_id' => 1));
        FumeHood::create(array('name' => '0001',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenence_date' => date('Y-m-d'),
            'notes' => 'Test Hood 1',
            'room_id' => 1));
        FumeHood::create(array('name' => '0002',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenence_date' => date('Y-m-d'),
            'notes' => 'Test Hood 2',
            'room_id' => 1));
        FumeHood::create(array('name' => '0003',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenence_date' => date('Y-m-d'),
            'notes' => 'Test Hood 3',
            'room_id' => 2));
    }

}
