<?php

/**
 * Extends the php internal class DateTime to provide some defaults and useful methods for the plugin
 *
 */
class CalendarDate extends DateTime {

/**
 * Timezone name to use as default for newly created objects
 *
 * @var string
 */
	public $timezoneNormalize = 'UTC';

/**
 * Common format for dates
 *
 * @var string
 */
	public static $defaultFormat = 'Y-m-d H:i:s';

/**
 * Objects constructor
 *
 * @param string $time 
 * @param DateTimeZone $timezone 
 * @see DateTime::__construct()
 */
	public function __construct($time = 'now', $timezone = null) {
		if (!$timezone) {
			$timezone = new DateTimeZone('UTC');
		}
		parent::__construct($time, $timezone);
	}

/**
 * Converts a unix timestamp into a SQL date..
 *
 * @param string Unix timestamp.
 * @return string Time formatted as $this->date_format
 * @access public
 */		
	public static function unixToDate($unixtime = null) {
		$date = new DateTime('@'.$unixtime);
		return $date->format(self::$defaultFormat);
	}

/**
 * Converts a string or DateTime object from a local time zone to UTC. Returns a string or
 * CalendarDate object depending on what was passed in.
 *
 * @param string or DateTime $date A date string or DateTime object in a local time zone.
 * @param string or DateTimeZone $timeZone A string or DateTimeZone object to change to.
 * @param string $return_format A DateTime format to use to return a string date
 * @return string or DateTime object A string representing the time in UTC or a DateTime object
 * @access public
 */	
	public static function convertToUTC($date, $timeZone, $format = null) {

		if(!is_a($timeZone, 'DateTimeZone')) {
			$timeZone = new DateTimeZone($timeZone);
		}

		if(!($date instanceof DateTime)) {
			$date = new CalendarDate($date, $timeZone);
			$date->setTimezone(new DateTimeZone('UTC'));
			return $date->format($format);
		}

		return $date->setTimezone(new DateTimeZone('UTC'));
	}

/**
 * Converts a string or DateTime object from a UTC to a local time zone. Returns a string or
 * DateTime object depending on what was passed in.
 *
 * @param string or DateTime $date A date string or DateTime object in UTC time.
 * @param string or DateTimeZone $time_zone A string or DateTimeZone object to change to.
 * @param string $return_format A DateTime format to use to return a string date
 * @return string or DateTime object A string representing the time in the local time zone, or a DateTime object
 * @access public
 */	
	public function convertFromUTC($date, $timeZone, $format = null) {

		if(!is_a($timeZone, 'DateTimeZone')) {
			$timeZone = new DateTimeZone($timeZone);
		}

		if(!is_a($date, 'DateTime')) {
			$date = new CalendarDate($date, new DateTimeZone('UTC'));
			$date->setTimezone($timeZone);
			return $date->format($format);
		}

		return $date->setTimezone($timeZone);
	}

/**
 * Adds or subtracts an interval to the date
 *
 * @param float $offset 
 * @return void
 */
	public function setOffset($offset) {
		list($hoursOffset, $minutesOffset) = $this->_splitOffset(abs($offset));
		$interval = new DateInterval('PT'.$hoursOffset.'H' . strval($minutesOffset) . 'M');

		if($offset > 0) {
			$this->add($interval);
		} else {
			$this->sub($interval);
		}
	}

/**
 * Returns an array having the offset hours and minutes separately
 *
 * @param float $offset 
 * @param int $minuteDefault decimal fraction of an hour
 * @return array
 */
	private function _splitOffset($offset, $minuteDefault = 0) {
		$parts = array($offset, $minuteDefault); 
		if (strpos($offset, '.') !== false) {
			$parts = explode('.', $offset, 2);
		}
		$parts[1] *= 6;
		return $parts;
	}

/**
 * Returns the formatted date string on success or FALSE on failure.
 *
 * @param string $format 
 * @return mixed
 */
	public function format($format = null) {
		if (!$format) {
			$format = self::$defaultFormat;
		}
		return parent::format($format);
	}

/**
 * Retuns an ATOM formatted date string
 *
 * @return string
 */
	public function toAtom() {
		return $this->format('Y-m-d\TH:i:s\Z');
	}
}