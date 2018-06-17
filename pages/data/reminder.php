<?php
	$id = $_POST["id"];
	$comment = $_POST["comment"];
	
	list($day, $month, $year) = explode("/", $_POST["date"]);
	
	$occurrence = $_POST["occurrence"];
	$repeats = $_POST["repeats"];
	
	$reminder = new Reminder($id, $comment, $day, $month, $year, $occurrence, $repeats, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$reminder->insertIntoDatabase();
		break;
		case "edit":
			$reminder->updateField();
		break;
		case "delete":
			$reminder->deleteField();
		break;
	}

	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>