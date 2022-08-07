<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Birthday class that encapsulates the data for people's birthdays
	// modifies, inserts, deletes and creates new birthdays

	class Birthday extends Life implements iDatabaseTasks {
		private $name;

		public function __construct($id, $name, $day, $month, $year, $updated) {
			parent::__construct($id, $day, $month, $year, $updated);

			$this->setName($name);
		} // end constructor

		public function setName($name) {
			if(is_string($name)) {
				$name = trim(htmlentities(strip_tags($name), ENT_QUOTES));

				if(strlen($name) < 255 && strlen($name) >= 2) {
					$this->name = $name;
				}
				else throw new InvalidArgumentException("The person's name should be between 2 and 255 characters long");
			}
			else throw new InvalidArgumentException("The person's name should be a string value");
		} // end function setName

		public function returnName() {
			return $this->name;
		} // end function returnName

		public function insertIntoDatabase() {
			$name = $this->returnName();
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();

			$query = "INSERT INTO birthdays (PersonName, Day, Month, Year)
				VALUES ('$name', '$day', '$month', '$year')";

			return Calendar::$MYSQLI->query($query);
		} // end function insertIntoDatabase

		public function updateField() {
			$ID = $this->returnID();
			$name = $this->returnName();
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();

			$query = "UPDATE birthdays SET PersonName = '$name', Day = '$day', Month = '$month', Year = '$year'
				WHERE BirthdayID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function updateField

		public function deleteField() {
			$ID = $this->returnID();

			$query = "DELETE FROM birthdays WHERE BirthdayID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>
