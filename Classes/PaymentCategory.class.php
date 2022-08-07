<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	// PaymentCategory class that encapsulates the data for payment categories
	// modifies, inserts, deletes and creates new payment categories

	class PaymentCategory extends Category implements iDatabaseTasks {
		public function __construct($id, $name, $updated) {
			parent::__construct($id, $name, $updated);
		} // end constructor

		public function insertIntoDatabase() {
			$name = $this->returnCatName();

			$query = "INSERT INTO paymentCategories (Name)
				VALUES ('$name')";

			return Calendar::$MYSQLI->query($query);
		} // end function insertIntoDatabase

		public function updateField() {
			$name = $this->returnCatName();
			$ID = $this->returnID();

			$query = "UPDATE paymentCategories SET Name = '$name' WHERE PaymentCategoryID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function updateField

		public function deleteField() {
			$ID = $this->returnID();

			$query = "DELETE FROM paymentCategories WHERE PaymentCategoryID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>
