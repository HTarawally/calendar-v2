<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	// Payment class that encapsulates the data for payments received or money spent
	// modifies, inserts, deletes and creates new payments

	class Payment extends Money implements iDatabaseTasks {
		private $amount; // amount of money spent or received
		private $type; // 1 = Received, 2 = Spent

		public function __construct($id, $day, $month, $year, $amount, $type, $catID, $updated) {
			parent::__construct($id, $day, $month, $year, $catID, $updated);

			$this->setAmount($amount);
			$this->setType($type);
		} // end constructor

		public function setAmount($amount) {
			if(preg_match("/^[0-9]{0,}\.{0,1}[0-9]{0,2}$/", $amount)) {
				$this->amount = $amount;
			}
			else throw new InvalidArgumentException("Please enter the amount in the proper format e.g. 1.25");
		} // end function setAmount

		public function setType($type) {
			if($type == 1 || $type == 2) {
				$this->type = $type;
			}
			else throw new InvalidArgumentException("The type should be either 1 or 2");
		} // end function setType

		public function returnAmount() {
			return $this->amount;
		} // end funtion returnAmount

		public function returnType() {
			return $this->type;
		} // end function returnType

		public function insertIntoDatabase() {
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();
			$amount = $this->returnAmount();
			$type = $this->returnType();
			$catID = $this->returnCatID();

			$query = "INSERT INTO payments (Day, Month, Year, Amount, Type, Category)
				VALUES ('$day', '$month', '$year', '$amount', '$type', '$catID')";

			return Calendar::$MYSQLI->query($query);
		} // end function insertIntoDatabase

		public function updateField() {
			$day = $this->returnDay();
			$month = $this->returnMonth();
			$year = $this->returnYear();
			$amount = $this->returnAmount();
			$type = $this->returnType();
			$catID = $this->returnCatID();
			$ID = $this->returnID();

			$query = "UPDATE payments SET Day = '$day', Month = '$month', Year = '$year', Amount = '$amount', Type = '$type',
				Category = '$catID' WHERE PaymentID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function updateField

		public function deleteField() {
			$ID = $this->returnID();

			$query = "DELETE FROM payments WHERE PaymentID = '$ID'";

			return Calendar::$MYSQLI->query($query);
		} // end function deleteField
	}
?>
