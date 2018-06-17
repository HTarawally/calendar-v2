<?php
	$id = $_POST["id"];
	
	$category = $_POST["category"];
	
	$paymentCategory = new PaymentCategory($id, $category, Calendar::$NOW);
		
	switch($_POST["op"]) {	
		case "insert":
			$paymentCategory->insertIntoDatabase();
		break;
		case "edit":
			$paymentCategory->updateField();
		break;
		case "delete":
			$rows = Calendar::searchDatabase("payments", '*', "Category = " . $id);
			
			if(count($rows) == 0) {
				$paymentCategory->deleteField();
			}
		break;
	}

	echo "<script>window.location.href = \"index.php?" . $_POST["query"] . "\"</script>";
?>