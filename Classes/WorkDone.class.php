<?php
	// WorkDone class that encapsulates the data for any work done
	// modifies, inserts, deletes and creates new work

	class WorkDone extends Money implements iDatabaseTasks {
		private $hours;
		private $minutes;
		private $wage;
		private $overtimeHours;
		private $overtimeMinutes;
		private $overtimeWage;
		
		public function __construct($id, $day, $month, $year, $compID, $hours, $mins, $wage, $oHours, $oMins, $oWage, $updated) {
			parent::__construct($id, $day, $month, $year, $compID, $updated);
			
			$this->setHours($hours);
			$this->setMinutes($mins);
			$this->setWage($wage);
			$this->setOvertimeHours($oHours);
			$this->setOvertimeMinutes($oMins);
			$this->setOvertimeWage($oWage);
		} // end constructor
		
		public function setHours($hours) {
			$this->hours = $hours;
		} // end function setHours
		
		public function setMinutes($mins) {
			if($mins < 60) {
				$this->minutes = $mins;
			}
			else throw new InvalidArgumentException("Minutes should be an integer less than 60");
		} // end function setMinutes
		
		public function setWage($wage) {
			if(preg_match("/^[0-9]{0,}\.{0,1}[0-9]{0,2}$/", $wage)) {
				$this->wage = $wage;
			}
			else throw new InvalidArgumentException("Please enter the wage in the proper format e.g. 1.25");
		} // end function setWage
		
		public function setOvertimeHours($oHours) {
			$this->overtimeHours = $oHours;
		} // end function setOvetimeHours
		
		public function setOvertimeMinutes($oMins) {
			if($oMins < 60) {
				$this->overtimeMinutes = $oMins;
			}
			else throw new InvalidArgumentException("Overtime minutes should be an integer less than 60");
		} // end function setOvertimeMinutes
		
		public function setOvertimeWage($oWage) {
			if(preg_match("/^[0-9]{0,}\.{0,1}[0-9]{0,2}$/", $oWage)) {
				$this->overtimeWage = $oWage;
			}
			else throw new InvalidArgumentException("Please enter the overtime wage in the proper format e.g. 1.25");
		} // end function setOvertimeWage
		
		public function returnHours() {
			return $this->hours;
		} // end function returnHours
		
		public function returnMinutes() {
			return $this->minutes;
		} // end function returnMinutes
		
		public function returnWage() {
			return $this->wage;
		} // end function returnWage
		
		public function returnOvertimeHours() {
			return $this->overtimeHours;
		} // end function returnOvertimeHours
		
		public function returnOvertimeMinutes() {
			return $this->overtimeMinutes;
		} // end function returnOvertimeMinutes
		
		public function returnOvertimeWage() {
			return $this->overtimeWage;
		} // end function returnOvertimeWage
		
		public function insertIntoDatabase() {
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();
			$catID = $this->returnCatID();
			$hours = $this->returnHours();
			$minutes = $this->returnMinutes();
			$wage = $this->returnWage();
			$oHours = $this->returnOvertimeHours();
			$oMins = $this->returnOvertimeMinutes();
			$oWage = $this->returnOvertimeWage();
			$updated = $this->returnLastUpdated();

			$query = "INSERT INTO workDone (Day, Month, Year, CompanyID, Hours, Minutes, Wage, 
					OvertimeHours, OvertimeMinutes, OvertimeWage)
				VALUES ('$day', '$month', '$year', '$catID', '$hours', '$minutes', '$wage', 
					'$oHours', '$oMins', '$oWage')";
			
			return Calendar::$MYSQLI->query($query) ;
		} // end function insertIntoDatabase
		
		public function updateField() {
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();
			$catID = $this->returnCatID();
			$hours = $this->returnHours();
			$minutes = $this->returnMinutes();
			$wage = $this->returnWage();
			$oHours = $this->returnOvertimeHours();
			$oMins = $this->returnOvertimeMinutes();
			$oWage = $this->returnOvertimeWage();
			$ID = $this->returnID();
			
			$query = "UPDATE workDone SET Day = '$day', Month = '$month', Year = '$year', CompanyID = '$catID', Hours = '$hours', 
				Minutes = '$minutes', Wage = '$wage', OvertimeHours = '$oHours', 
				OvertimeMinutes = '$oMins', OvertimeWage = '$oWage' WHERE WorkdoneID = '$ID'";
			
			return Calendar::$MYSQLI->query($query);
		} // end function updateField
		
		public function deleteField() {
			$ID = $this->returnID();
			
			$query = "DELETE FROM workDone WHERE WorkdoneID = '$ID'";
			
			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>