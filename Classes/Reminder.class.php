<?php
	// Reminder class that encapsulates the data for any reminders
	// modifies, inserts, deletes and creates new reminder

	class Reminder extends Life implements iDatabaseTasks {
		private $comment; // string containing the reminder
		private $occurrence; // how often i should be reminded. 1 = Once only, 2 = yearly, 3 = monthly, 4 = weekly, 5 = daily
		private $times; // how many times i should be reminded. -1 = forever. 
		
		public function __construct($id, $comment, $day, $month, $year, $occ, $times, $updated) {
			parent::__construct($id, $day, $month, $year, $updated);
			
			$this->setComment($comment);
			$this->setOccurrence($occ);
			$this->setTimes($times);
		} // end constructor
		
		public function setComment($comment) {
			if(is_string($comment)) {
				$comment = trim(htmlentities(strip_tags($comment), ENT_QUOTES));
				
				if(strlen($comment) < 255 && strlen($comment) >= 2) {
					$this->comment = $comment;
				}
				else throw new InvalidArgumentException("The comment should be between 2 and 255 characters long");
			}
			else throw new InvalidArgumentException("The comment should be a string value");
		} // end function setComment
		
		public function setOccurrence($occ) {
			if($occ > 0 && $occ <= 6) {
				$this->occurrence = $occ;	
			}
			else throw new InvalidArgumentException("Occurrence should be an integer between 1 and 6 inclusive");
		} // end function setOccurrence
		
		public function setTimes($times) {
			if($times >= -1 && $times != 0) {
				$this->times = $times;
			}
			else throw new InvalidArgumentException("Times should either be -1 or a positive integer");
		} // end function setTimes
		
		public function returnComment() {
			return $this->comment;	
		} // end function returnComment
		
		public function returnOccurrence() {
			return $this->occurrence;
		} // end function returnOccurrence
		
		public function returnTimes() {
			return $this->times;	
		} // end function returnTimes
		
		public function insertIntoDatabase() {
			$comment = $this->returnComment();
			$day = $this->returnDay();
			$month = $this->returnMonth(); 
			$year = $this->returnYear();
			$occurrence = $this->returnOccurrence();
			$times = $this->returnTimes();

			$query = "INSERT INTO reminders (Comment, Day, Month, Year, Occurrence, Times)
				VALUES ('$comment', '$day', '$month', '$year', '$occurrence', '$times')";
				
			return CALENDAR::$MYSQLI->query($query) ;
		} // end function insertIntoDatabase
		
		public function updateField() {
			$ID = $this->returnID();
			$comment = $this->returnComment();
			$day = $this->returnDay();
			$month = $this->returnMonth(); 
			$year = $this->returnYear();
			$occurrence = $this->returnOccurrence();
			$times = $this->returnTimes();
			
			$query = "UPDATE reminders SET Comment = '$comment', Day = '$day', Month = '$month', Year = '$year', Occurrence = '$occurrence', 
				Times='$times' WHERE ReminderID = '$ID'";
			
			return Calendar::$MYSQLI->query($query);
		} // end function updateField
		
		public function deleteField() {
			$ID = $this->returnID();
			
			$query = "DELETE FROM reminders WHERE ReminderID = '$ID'";
			
			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>