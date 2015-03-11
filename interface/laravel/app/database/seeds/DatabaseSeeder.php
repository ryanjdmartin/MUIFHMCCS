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
		$this->call('NotificationsTableSeeder');
		$this->call('MeasurementsTableSeeder');
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

        Building::create(array('id' => 1,
            'name' => 'AN Bourns Science Building',
            'abbv' => 'ABB'));
        Room::create(array('id' => 1,
            'name' => '101',
            'contact' => 'lab_abb101@mcmaster.ca',
            'building_id' => 1));
        Room::create(array('id' => 2,
            'name' => '102',
            'contact' => 'ex55555',
            'building_id' => 1));
        FumeHood::create(array('name' => '0001',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenance_date' => date('Y-m-d'),
            'notes' => 'Test Hood 1',
            'room_id' => 1));
        FumeHood::create(array('name' => '0002',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenance_date' => date('Y-m-d'),
            'notes' => 'Test Hood 2',
            'room_id' => 1));
        FumeHood::create(array('name' => '0003',
            'model' => 'Test Model',
            'install_date' => date('Y-m-d'),
            'maintenance_date' => date('Y-m-d'),
            'notes' => 'Test Hood 3',
            'room_id' => 2));
    }

}

class NotificationsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('notifications')->delete();

        Notification::create(array(
            'fume_hood_name' => '0001', 
            'class' => 'alert', 
            'type' => 'Velocity Low', 
            'measurement_time' => new DateTime('now')));
        Notification::create(array(
            'fume_hood_name' => '0001', 
            'class' => 'critical', 
            'type' => 'Velocity Low', 
            'measurement_time' => new DateTime('now')));
        Notification::create(array(
            'fume_hood_name' => '0002', 
            'class' => 'alert', 
            'type' => 'Velocity High', 
            'measurement_time' => new DateTime('now')));
        Notification::create(array(
            'fume_hood_name' => '0002', 
            'class' => 'alert', 
            'type' => 'Sash Up Overnight', 
            'measurement_time' => new DateTime('now')));
        Notification::create(array(
            'fume_hood_name' => '0001', 
            'class' => 'alert', 
            'type' => 'Sash Up Overnight', 
            'measurement_time' => new DateTime('now')));
    }

}

class MeasurementsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('measurements')->delete();

        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 20,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 21,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 22,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 1,
            'velocity' => 21,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 1,
            'velocity' => 21,
            'alarm' => 1,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 22,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 23,
            'alarm' => 1,
            'measurement_time' => new DateTime('now')));
        sleep(1);
        Measurement::create(array(
            'fume_hood_name' => '0001', 
            'sash_up' => 0,
            'velocity' => 22,
            'alarm' => 0,
            'measurement_time' => new DateTime('now')));
        sleep(1);
    }

}
