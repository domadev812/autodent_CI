<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_calendar {
	
	private $_week_days;
	private $_current_date;
	private $_title;
	
	public function __construct($current_date = null){
		 $this->_current_date = $this->_date($current_date);
		 $this->_week_days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	}
	
	public function getCurrentDate(){
		return $this->_current_date;
	}
		
	public function getWeekDays(){
		return $this->_week_days;
	}
	
	public function getTitle($interval = 'month'){
		$format = [
			'year' => 'Y',
			'month' => 'F Y',
			'week' => '\W\e\e\k W \o\f Y',
			'day' => 'l j F, Y',
		];
		return date(isset($format[$interval]) ? $format[$interval] : '', strtotime($this->_current_date));
	}
	
	public function getMonth(){
		$start_date = $this->_week_date($this->_date($this->_current_date,'Y-m-01'));
		$end_date = $this->_week_date($this->_date($this->_current_date,'Y-m-t'), 'Next Sunday - 1 day');
		
		if($end_date < $this->_date($this->_current_date,'Y-m-t')){
			$end_date = $this->_week_date($this->_date($this->_current_date,'Y-m-t'),'next Saturday');
		}
		

		$dates = [];
		while($start_date <= $end_date){
			$key = date('Y-m-d', strtotime($start_date));
			$m1 = date('Y-m', strtotime($this->_current_date));
			$m2 = date('Y-m', strtotime($key));
			$day = date('j', strtotime($key));
			
			$classes = [];
			if($m1 != $m2){$classes[] = 'disabled';}
			if($this->_date() == $key){$classes[] = 'current';}
			
			$dates[$key] = (object) [
				'classes' => implode(' ', $classes),
				'disabled' => intval($m1 != $m2),
				'day' => $day
			];
			$start_date = date('Y-m-d', strtotime($start_date.' + 1 day'));
		}
		return $dates;
	}
	
	public function getYear(){
		$start_date = $this->_date($this->_current_date, 'Y-01-01');
		$end_date = $this->_date($this->_current_date, 'Y-12-t');
		$curr_month = date('Y-m');

		$dates = [];
		while($start_date <= $end_date){
			$key = date('Y-m', strtotime($start_date));
			$month_name = date('F', strtotime($key));

			$classes = [];
			if($curr_month == $key){$classes[] = 'current';}
			
			$dates[$key] = (object) [
				'classes' => implode(' ', $classes),
				'month' => $month_name
			];
			$start_date = date('Y-m-d', strtotime($start_date.' + 1 month'));
		}
		return $dates;
	}
	
	private function _week_date($date, $day = 'Last Saturday + 1 day', $format = 'Y-m-d'){
	    return date($format, strtotime($day, strtotime($date))); 
	}	

	private function _getWeekNumber($date = null){
	    return date('W', strtotime($this->_date($date)));
	}
	    
	private function _date($date = null, $format = 'Y-m-d'){
	    return date($format, $date ? strtotime($date) : time());
	}	
}?>