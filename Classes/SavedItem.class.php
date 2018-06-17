<?php
	// Abstract class that provides the minimum details
	// for an item inserted into the database
	
	// this class is the direct or indirect parent of all 
	// items saved in the database

	abstract class SavedItem {
		private $ID; // unique id used in the database to identify data.. if $ID = 0, a new item is being added. can't be less than 0
		private $lastUpdated; // the last time this data has been updated in the format yyyy-mm-dd hh:mm:ss. 24 hour format
		
		public function __construct($id, $updated) {
			$this->setID($id);
			$this->setLastUpdated($updated);
		}// end constructor
		
		public final function setID($id) {
			if(preg_match("/^[0-9]{1,}$/", $id)) { // if id is an integer
				$this->ID = $id;
			}
			else throw new InvalidArgumentException("ID should be an integer value");
		} // end function setID
		
		public final function setLastUpdated($updated) {
			if(!is_string($updated)) {
				throw new InvalidArgumentException("Lasted updated should be a string value");
			}
			else {
				// check if the input is in the format yyyy-mm-dd hh:mm:ss
				$formatCorrect = preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $updated);
				
				if($formatCorrect) { // if the format is correct, check if the year, month.. etc values are in the correct range
					list($date, $time) = explode(" ", $updated);
					list($year, $month, $day) = explode("-", $date);
					list($hour, $minute, $second) = explode(":", $time);
					
					if($month <= 12 && $month >=1) {
						if(!($day <= 31 && $day >= 1)) {
							throw new InvalidArgumentException("The day should be in the range 1 - 31");
						}
					}
					else throw new InvalidArgumentException("The month should be in the range 1 - 12");
					
					if($hour >= 0 && $hour <= 23) {
						if($minute >= 0 && $minute <= 59) {
							if(!($second >= 0 && $second <= 59)) {
								throw new Exception("The seconds should be in the range 0 - 59");
							}
						}
						else throw new InvalidArgumentException("The minutes should me in the range 0 - 59");
					}
					else throw new InvalidArgumentException("The hour should be in the range 0 - 23");
					
					$this->lastUpdated = $updated;
				}
				else throw new InvalidArgumentException("The last updated time should be in the format yyyy-mm-dd hh:mm:ss");
			}
		} // end function setLastUpdated
		
		public final function returnID() {
			return $this->ID;
		} // end function returnID
		
		public final function returnLastUpdated() {
			return $this->lastUpdated;
		} // end function returnLastUpdated
	}
?>