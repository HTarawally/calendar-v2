<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	// Company class that encapsulates the data for companies
	// modifies, inserts, deletes and creates new companies

	class Company extends Category implements iDatabaseTasks {
		public function __construct($id, $name, $updated) {
			parent::__construct($id, $name, $updated);
		} // end constructor

		public function insertIntoDatabase() {
			$name = $this->returnCatName();

			$query = "INSERT INTO companies (CompanyName)
				VALUES ('$name')";

			return Calendar::$MYSQLI->query($query);
		} // end function insertIntoDatabase

		public function updateField() {
			$name = $this->returnCatName();
			$ID = $this->returnID();

			$query = "UPDATE companies SET CompanyName = '$name' WHERE CompanyID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function updateField

		public function deleteField() {
			$ID = $this->returnID();

			$query = "DELETE FROM companies WHERE CompanyID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>
