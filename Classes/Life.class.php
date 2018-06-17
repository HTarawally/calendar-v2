<?php
	// Abstract class that provides everything 
	// needed for anything that is day to day life

	abstract class Life extends SavedItem {
		private $day;
		private $month;
		private $year;
		
		public function __construct($id, $day, $month, $year, $updated) {
			parent::__construct($id, $updated);
			
			$this->setDay($day);
			$this->setMonth($month);
			$this->setYear($year);
		} // end constructor
		
		public final function setDay($day) {
			if(preg_match("/^[0-9]{1,2}$/", $day)) { // if day contains a number 1 or 2 digits long
				if($day >= 1 && $day <= 31) {
					$this->day = $day;
				}
				else throw new InvalidArgumentException("The day should be in the range 1 - 31");
			}
			else throw new InvalidArgumentException("The day should be in the format d or dd");
		} // end function setDay
		
		public final function setMonth($month) {
			if(preg_match("/^[0-9]{1,2}$/", $month)) { // if month contains a number 1 or 2 digits long
				if($month >= 1 && $month <= 12) {
					$this->month = $month;
				}
				else throw new InvalidArgumentException("The month should be in the range 1 - 12");
			}
			else throw new InvalidArgumentException("The month should be in the format m or mm");
		} // end function setMonth
		
		public final function setYear($year) {
			if(preg_match("/^[0-9]{4}$/", $year)) { // if the year is 4 digits long
				$this->year = $year;
			}
			else throw new InvalidArgumentException("The year should be in the format yyyy");
		} // end function setYear
		
		public final function returnDay() {
			return $this->day;
		} // end function returnDay
		
		public final function returnMonth() {
			return $this->month;
		} // end function returnMonth
		
		public final function returnYear() {
			return $this->year;
		} // end function returnYear
	}
?>