<?php
class TimeZoneHelper extends AppHelper {
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Time');

/**
 * 
 */
	public $timezones = array( 
        'Kwajalein' => 'Eniwetok, Kwajalein', 
        'Pacific/Midway' => 'Midway Island, Somoa', 
        'Pacific/Honolulu' => 'Hawaii', 
        'America/Anchorage' => 'Alaska', 
        'America/Los_Angeles' => 'Pacific Time (US & Canada)', 
        'America/Denver' => 'Mountain Time (US & Canada)', 
        'America/Tegucigalpa' => 'Central Time (US & Canada), Mexico City', 
        'America/New_York' => 'Eastern Time (US & Canada), Bogota, Lima, Quito', 
        'America/Halifax' => 'Atlantic Time (Canada), Caracas, La Paz', 
        'America/St_Johns' => 'Newfoundland', 
        'America/Argentina/Buenos_Aires' => 'Brazil, Buenos Aires, Georgetown', 
        'Atlantic/South_Georgia' => 'Mid-Atlantic', 
        'Atlantic/Azores' => 'Azores, Cape Verde Islands', 
        'Europe/Dublin' => 'Western Europe Time, London', 
        'Europe/Belgrade' => 'CET (Central Europe Time), Brussels', 
        'Europe/Minsk' => 'EET (Eastern Europe Time), South Africa', 
        'Asia/Kuwait' => 'Baghdad, Kuwait, Riyadh, Moscow', 
        'Asia/Tehran' => 'Tehran', 
        'Asia/Muscat' => 'Abu Dhabi, Muscat', 
        'Asia/Yekaterinburg' => 'Ekaterinburg, Islamabad', 
        'Asia/Kolkata' => 'Bombay, Calcutta, Madras, New Delhi', 
        'Asia/Dhaka' => 'Almaty, Dhaka, Colombo', 
        'Asia/Krasnoyarsk' => 'Bangkok, Hanoi, Jakarta', 
        'Asia/Brunei' => 'Beijing, Perth, Singapore, Hong Kong', 
        'Asia/Seoul' => 'Tokyo, Seoul, Osaka, Sapporo', 
        'Australia/Darwin' => 'Adelaide, Darwin', 
        'Australia/Canberra' => 'EAST (East Australian Standard)', 
        'Asia/Magadan' => 'Magadan, Solomon Islands', 
        'Pacific/Fiji' => 'Auckland, Wellington, Fiji', 
        'Pacific/Tongatapu' => 'Tongatapu' 
    ); 

    function select($fieldname, $label="Time zone") { 
    
        $list = $this->Form->input( 
            $fieldname,  
            array( 
                "type" => "select", 
                "label" => $label, 
                "options" => $this->timezones, 
                "error" => "Please select your time zone" 
            ) 
        ); 
        return $this->output($list); 
    } 

    function display($index) { 
        return $this->output($this->timezones[$index]); 
    }

}