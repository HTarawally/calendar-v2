<?php
	function printMonthsOptions() {
		foreach(Calendar::$MONTHS as $index => $value) {
			echo "<option value='" . ++$index . "' ";
				if(isset(Calendar::$PAGES["month"])) {
					if(Calendar::$PAGES["month"] == $index) echo "selected";
				}
			echo ">$value</option>\n";
		}
	}

	function printYearsOptions() {
		$selectedYear = Calendar::$TODAY_YEAR;
		$startYear = $selectedYear - 15;
		$endYear = $selectedYear + 15;
	
		if(isset(Calendar::$PAGES["year"])) {
			$selectedYear = Calendar::$PAGES["year"];
			$startYear = $selectedYear - 15;
			$endYear = $selectedYear + 15;
		}
		
		for($i = $startYear; $i <= $endYear; $i++) {
			echo "<option value='$i' ";
				if($i == $selectedYear) echo "selected";
			echo ">$i</option>\n";
		}
	}
	
	function printDefaultDateValue() {
		$day = 1;
		$month = Calendar::$TODAY_MONTH;
		$year = Calendar::$TODAY_YEAR;
	
		if(isset(Calendar::$PAGES["day"])) {
			$day = Calendar::$PAGES["day"];
		}
		
		if(isset(Calendar::$PAGES["month"])) {
			$month = Calendar::$PAGES["month"];
		}
		
		if(isset(Calendar::$PAGES["year"])) {
			$year = Calendar::$PAGES["year"];
		}
		
		printf("value='%02d/%02d/%04d'", $day, $month, $year);	
	}
	
	function printLeftSide($year, $month) {
		echo "<aside class='left_pane container'>";
			Calendar::printMonth($year, $month); 
			
			echo "<div class='button_group container'>
				<button class='birthday' title='Add Birthday'>Birthday</button>
				<button class='reminder' title='Add Reminder'>Reminder</button>
				<button class='payment' title='Add Payment'>Payment</button>
				<button class='paymentcategory' title='Add Payment Category'>Payment Category</button>
				<button class='workdone' title='Add Work Done'>Work Done</button>
				<button class='company' title='Add Company'>Company</button>
			</div>";
			
		echo "</aside>";
	} // end function printLeftSide
?>