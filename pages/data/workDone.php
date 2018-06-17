<?php
	$id = $_POST["id"];
	list($day, $month, $year) = explode("/", $_POST["date"]);
	
	$company = $_POST["company"];
	
	list($hours, $mins) = explode(":", $_POST["hours"]);
	$wage = $_POST["wage"];
	
	list($oHours, $oMins) = explode(":", $_POST["oHours"]);
	$oWage = $_POST["oWage"];
	
	$workDone = new WorkDone($id, $day, $month, $year, $company, $hours, $mins, $wage, $oHours, $oMins, $oWage, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$workDone->insertIntoDatabase();
		break;
		case "edit":
			$workDone->updateField();
		break;
		case "delete":
			$workDone->deleteField();
		break;
	}

	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>