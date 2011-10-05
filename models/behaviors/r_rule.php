<?php

class RRuleBehavior extends ModelBehavior {
	
	public $modelName = 'RRule';
	
	protected $_start;
	
	protected $_end;
	
	function setup(&$Model, $config = array()) {
		$this->defaults['foreignKey'] = sprintf('%s_id', Inflector::underscore($Model->alias));
		$this->settings[$Model->alias] = am($this->defaults, $config);
		
		$RRule = ClassRegistry::init('Calendar.RRule');

		$Model->bindModel(array(
			'hasMany' => array(
				$this->modelName => array(
					'className' => $this->modelName,
					'foreignKey' => $this->settings[$Model->alias]['foreignKey']
				))
		), false);
		
		$RRule->bindModel(array(
			'belongsTo' => array(
				$Model->alias => array(
					'className' => $Model->alias,
					'foreignKey' => $this->settings[$Model->alias]['foreignKey']
				))
		), false);
	}

	// @todo - Figure out what to do before saving RRules, if anything...
	public function beforeSave(&$Model, $options) {
		$this->serializeRules(&$Model);
		return true;
	}
	
	// @todo - Add a sweet join to make this faster
	function beforeFind(&$Model, $query) {
		if (!empty($query['recurs'])) {
			$this->_start = $query['recurs']['from'];
			$this->_end = $query['recurs']['to'];
		} elseif (!empty($query['conditions']['start_date']) && !empty($query['conditions']['end_date'])) {
			$this->_start = $query['conditions']['start_date'];
			$this->_end = $query['conditions']['end_date'];
			unset($query['conditions']['start_date']);
			unset($query['conditions']['end_date']);
		}
		if ($this->_start && $this->_end) {
			$query['contain'][] = $this->modelName;
			$query['conditions']['OR'] = array(
					'AND' => array (
						$Model->alias . '.end_date >=' => $this->_start,
						$Model->alias . '.start_date <=' => $this->_end,
					),
					$Model->alias.'.recurring' => true,
				);			
		}
		return $query;
	}
	
	public function serializeRules(&$Model) {
		if(!empty($Model->data[$this->modelName]) && is_array($Model->data[$this->modelName])) {
			foreach ($Model->data[$this->modelName] as &$rule) {
				if (!empty($rule['bydaydays']) && is_array($rule['bydaydays'])) {
					$rule['bydaydays'] = implode(',', array_values($rule['bydaydays']));
				}
			}
		} else if (!empty($Model->data[$this->modelName]['bydaydays']) && is_array($Model->data[$this->modelName]['bydaydays'])) {
			$Model->data[$this->modelName]['bydaydays'] = implode(',',array_values($Model->data[$this->modelName]['bydaydays']));	
		}
	}

	public function calculateRecurrence(&$Model, $results) {
		$events = array();
		if (empty($this->_start) || empty($this->_end)) {
			return $results;
		}
		foreach ($results as $event) {
			
			if (!empty($event[$this->modelName])) {
				$one_day = new DateInterval('P1D');
				$end_day = new CalendarDate($this->_end);
				for ($date = new CalendarDate($this->_start); $date <= $end_day; $date->add($one_day)) {
					foreach ($event[$this->modelName] as $rule) {
					
						if ($this->ruleIsTrue($Model, $rule, $date)) {
							$events[] = $this->renderEventForDate($Model, $event, clone $date);	
						}
					}
				}
			} else {
				$events[] = $event;
			}
		}
        $this->_start = $this->_end = null;
		return $events;
	}

	/**
	 * Validates a recurrence rule for a particular date.
	 *
	 * @param array $rule An array describing a recurrence rule 
	 * @param array $date A DateTime object to test the rule against.
	 * @return bool true if the rule is valid for this date, false if it is not
	 * @access public
	 */
	public function ruleIsTrue(&$Model, $rule, $date) {

		extract($rule);

		/* TODO
		 * 
		 * Add support for other types of recurrence here. All recurrence
		 * modeling should be done after the iCal spec shown here:
		 * http://developer.apple.com/library/mac/documentation/AppleApplications/Reference/SyncServicesSchemaRef/Articles/Calendars.html#//apple_ref/doc/uid/TP40001540-174926
		 */
		if ($frequency == 'weekly') {
			$days = explode(',', $bydaydays);
			foreach ($days as $day) {
				if ($day == strtolower($date->format('l'))) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Renders a recurring event for the given date. Does not check to make sure the
	 * event occurs on this date (use RecurrenceRule::ruleIsTrue for that).
	 *
	 * @param array $event Contains data formatted the same as a retrieved Event from a find.
	 * @param DateTime $date A DateTime object in UTC time. This is the date to render the event for.
	 * @return array The instance rendered for this recurring event
	 * @access public
	 */
	public function renderEventForDate(&$Model, $event, $date) {

		$rendered_event = $event;
		$start_date = new CalendarDate($event[$Model->alias]['start_date']);
		$end_date   = new CalendarDate($event[$Model->alias]['end_date']);
		$interval = $start_date->diff($end_date);
		$interval = new DateInterval("PT{$interval->h}H{$interval->i}M");

		$floating_start_hour = $start_date->format('H');
		$date->setTime($floating_start_hour, $start_date->format('i'), $start_date->format('s'));
		$event[$Model->alias]['start_date'] = $date->format();

		$date->add($interval);
		$event[$Model->alias]['end_date'] = $date->format();

		return $event;
	}


	public function buildRerurrenceByFrequency(&$Model, $date, $timeZone, $frequency) {
		$startDate = new CalendarDate(
			$date,
			new DateTimeZone($timeZone)
		);
		$startDate->setTimeZone(new DateTimeZone('UTC'));
		$dayOfWeek = strtolower($startDate->format('l'));

		return array(array(
			'frequency' => $frequency,
			'bydaydays' => array($dayOfWeek)
		));
	}

}
?>
