<?php

class SystemSettings extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'system_settings';

    /* Return settings row, or create one with default values */
	public static function getSettings(){
        return self::firstOrCreate(array());
    }
    
    /* Save settings */
    public static function saveSettings($settingsArray){
        self::where('id', '>', '0')->update($settingsArray);
    }
    
}
