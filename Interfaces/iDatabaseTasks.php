<?php 
	// interface that sets the functions needed for any class that
	// communicates with the database
	
	interface iDatabaseTasks {
		public function insertIntoDatabase();
		public function updateField();
		public function deleteField();
	}
?>