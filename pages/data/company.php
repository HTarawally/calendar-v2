<?php
	$id = $_POST["id"];
	
	$company = $_POST["company"];
	
	$thisCompany = new Company($id, $company, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$thisCompany->insertIntoDatabase();
		break;
		case "edit":
			$thisCompany->updateField();
		break;
		case "delete":
			$rows = Calendar::searchDatabase("workDone", '*', "CompanyID = " . $id);
		
			if(count($rows) == 0) {
				$thisCompany->deleteField();
			}
		break;
	}

	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>