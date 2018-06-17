<?php
	$id = $_POST["id"];
	$name = $_POST["name"];

	list($day, $month, $year) = explode("/", $_POST["date"]);
	
	$birthday = new Birthday($id, $name, $day, $month, $year, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$birthday->insertIntoDatabase();
		break;
		case "edit":
			$birthday->updateField();
		break;
		case "delete":
			$birthday->deleteField();
		break;
	}
	
	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>