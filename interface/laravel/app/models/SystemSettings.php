<?php

class SystemSettings extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'system_settings';

    /* Return settings row, or create one with default values */
	public function getSettings(){
        return $this::firstOrCreate(array());
    }
    
    /* Save settings */
    public function saveSettings($settingsArray){
        $this::where('id', '>', '0')->update($settingsArray);
    }
    
}
