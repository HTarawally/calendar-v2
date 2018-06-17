<?php
	$id = $_POST["id"];
	list($day, $month, $year) = explode("/", $_POST["date"]);
	
	$amount = $_POST["amount"];
	$type = $_POST["type"];
	$category = $_POST["category"];
	
	$payment = new Payment($id, $day, $month, $year, $amount, $type, $category, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$payment->insertIntoDatabase();
		break;
		case "edit":
			$payment->updateField();
		break;
		case "delete":
			$payment->deleteField();
		break;
	}

	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>