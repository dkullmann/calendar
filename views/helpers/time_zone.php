<?php
App::import('Lib', 'Calendar.CalendarDate');
/**
 * TimeZone Helper class file.
 *
 * PHP versions 5
 *
 */

/**
 * TimeZone Helper class for easy use of timezone manipulation.
 *
 * Manipulation of timezone data.
 *
 */ 
class TimeZoneHelper extends AppHelper {
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Time');

/** 
 * Options 
 *
 * @var array 
 */ 
	private $__options = array('path' => 'autoload'); 

/**
 * Time Zones
 *
 * @var array
 */
	protected $_timeZones = array();

/**
 * Countries
 *
 * @var array
 */
	protected $_countries = array();

/**
 * Constructor
 *
 * @return void
 */
	public function __construct($options = array()) {
		$defaults = array(
			'timeZones' => array('cst', 'est', 'mst', 'pst', 'akst', 'hst'),
			'countries' => array('America', 'Pacific'),
			'appTimeZone' => Configure::read('App.defaultTimezone'),
			'userTimeZone' => Configure::read('App.User.timeZone'),
			'commonZones' => array(
				'Pacific/Honolulu',
				'America/Anchorage',
				'America/Los_Angeles',
				'America/Denver',
				'America/Phoenix',
				'America/Chicago',
				'America/New_York',
			),
			'commonNames' => array(
				'Pacific/Honolulu' => 'Hawaii Time',
				'America/Anchorage' => 'Alaska Time',
				'America/Los_Angeles' => 'Pacific Time',
				'America/Denver' => 'Mountain Time',
				'America/Phoenix' => 'Mountain Time - Arizona',
				'America/Chicago' => 'Central Time',
				'America/New_York' => 'Eastern Time',
			),
		);
		parent::__construct($options);
		$this->__options = array_merge($defaults, $options); 

		$this->setTimeZones($this->__options['timeZones']);
		$this->setCountries($this->__options['countries']);
		$this->setCommonZones($this->__options['commonZones']);
		$this->setCommonNames($this->__options['commonNames']);
	}

/**
 * Utility function to re-index the array returned
 * from getTimeZones(). The $a is integer indexed
 * from the order of DateTimeZone::listIdentifiers()
 * so we need to reindex it to match proper formating
 *
 * @param array;
 * @return new indexed array;
 */
	protected function __format(array $array) {
		$i=0;
		foreach ($array as $key => $val) {
			if (is_array($val)) {
				foreach ($val as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $a => $b) {
							$name = $b['name'];
							if (in_array($name, $this->_commonZones)) {
								$vname = $this->_commonNames[$name];
								$k = 'Common Time Zones';
							} else {
								$k = $key;
								$vname = str_replace('_', ' ', end(explode('/', $name)));
							}
							$offset = $b['offset'];
							$voffset = $offset / 3600;
							$mod = $offset % 3600;
							if ($mod) {
								$vminutes = abs($mod / 60);
							} else {
								$vminutes = '00';
							}
							$display = sprintf('(GMT %d:%s) %s', $voffset, $vminutes, $vname);
							$arr[$k][] = array(
								'name' => $display,
								'value' => $name,
								'utc_offset' => $b['offset'],
								);
						}
					}
				}
			}
		}
		$ac['Common Time Zones'] = $arr['Common Time Zones'];
		$aa['America'] = $arr['America'];
		$ap['Pacific'] = $arr['Pacific'];
		$arr = array_merge($ac, $aa, $ap);
		return $arr;
	}

/**
 * Converts the timezone of UTC time in another timezone
 *
 * @param string Time in UTC format
 * @param timezone
 * @return string UTC time
 */
	public function convert($time, $fromTimeZone = null, $toTimeZone = null, $format = 'Y-m-d H:i:s') {
		if (empty($fromTimeZone)) {
			$fromTimeZone = $this->__options['appTimeZone'];
		}
		if (empty($toTimeZone)) {
			$toTimeZone = $this->__options['userTimeZone'];
		}
		return CalendarDate::convertTimeZone($time, $fromTimeZone, $toTimeZone, $format);
	}

	public function longFormat($time = null) {
		$time = CalendarDate::convertTimeZone($time, $this->__options['appTimeZone'], $this->__options['userTimeZone'], 'c');
		$string = CalendarDate::formatDate($time, 'D, M nS Y', $this->__options['userTimeZone']);
		$string .= ' at ';
		$string .= CalendarDate::formatDate($time, 'g:iA', $this->__options['userTimeZone']);
		return $string;
	}

/**
 * This function takes an array of the old style of time zone
 * abreviations. e.g. CST, EST, PST
 *
 * @param array;
 * @return none; sets $this->_timeZones variable
 */
		public function setTimeZones (array $array) {
			$this->_timeZones = $array;
		}

/**
 * This function takes an array of the continent names for which
 * you want to get the valid time zone names for
 *
 * @param array;
 * @return none; sets $this->_countries variable
 */
		public function setCountries (array $countries) {
			$this->_countries = $countries;
		}

/**
 * This function takes an array of the common time zone names
 *
 * @param array;
 * @return none; sets $this->_commonZones variable
 */
		public function setCommonZones (array $commonZones) {
			$this->_commonZones = $commonZones;
		}

/**
 * This function takes an array of the common time zone names
 *
 * @param array;
 * @return none; sets $this->_commonNames variable
 */
		public function setCommonNames (array $commonNames) {
			$this->_commonNames = $commonNames;
		}

/**
 * This function is similiar to the dateTime::listabbreviations method
 * but this one weeds out those time zones that are not recognized.
 *
 * @param none;
 * @return array; a multidimensional [country][time zone abreviation][city/offset]
 */
	public function getTimeZones() {
		$ident = DateTimeZone::listIdentifiers();
		$cntIdent = count($ident);
		$zones = $this->_timeZones;
		$cntZones = count($zones);

		for ($i = 0; $i < $cntZones; $i++ ) {
			for ($j = 0; $j < $cntIdent; $j++) {
				$date = new DateTime(null, new DateTimeZone($ident[$j]));
				$zoneFormat = $date->format('T');
				$tz = $date->getTimezone();
				$tzName = $tz->getName();
				$offset = $date->getOffset();
				$utc[$j] = array('name' => $tzName, 'offset' => $offset);

				if (strtoupper($zones[$i]) == $zoneFormat) {
					$ex = explode('/', $tzName);
					for ( $z = 0; $z < count($this->_countries); $z++) {
						if ($ex[0] == ucwords($this->_countries[$z])) {
							$array[$ex[0]][$zoneFormat][$j] = array('name' => $tzName, 'offset' => $offset);
						}
					}
				}
			}
		}
		return $this->__format($array);
	}

/**
 * Generates a select dropdown with a list of timezones
 *
 * @param string $fieldname Name of the field
 * @param array $options Classic FormHelper::input options extended with:
 *	- auto: if true all existing world timezones will be loaded, otherwise default values will be used
 *	- utc_offset: if true the UTC offset will be added in an "utc_offset" html attribute for each option
 * @return string Html markup for the dropdown
 */
	public function select($fieldname, $options = array()) {
		$options = array_merge(
			array('auto' => false, 'utc_offset' => false),
			$options);
		$default = array(
			'America/Los_Angeles' => 'PST',
			'America/Chicago' => 'CST',
			'America/New_York' => 'EST',
			'America/Phoenix' => 'MST'
		);
		$set = !empty($options['auto']) ? $this->getTimezones() : $default;

		if ($options['utc_offset']) {
			$newSet = array();
			foreach($set as $value => $name) {
				$LocalTime = new DateTime(null, new DateTimeZone($value));
				$newSet[] = array(
					'name' => $name,
					'value' => $value,
					'utc_offset' => $LocalTime->getOffset() / 3600
				);
			}
			$set = $newSet;
		}

		array_unshift($set, 'Select your time zone');
		unset($options['auto'], $options['utc_offset']);
		return $this->Form->input($fieldname, array('type' => 'select', 'options' => $set) + $options);
	}

}