<?php
	class Calendar extends Utility {
		public static $MONTHS = array("January", "February", "March", "April", "May", "June", "July", "August", "September", 
			"October", "November", "December");
			
		public static $DAYS_SHORT_NAMES = array("Mo", "Tu", "We", "Th", "Fr", "Sa", "Su");
		public static $DAYS_FULL_NAMES = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		
		public function __construct() {
			parent::__construct();
		} // end constructor
		
		// function that determines if the month is one of those special months
		// to be displayed in an orange background
		public static function isSpecialMonth($month) {
			switch($month) {
				case 2:
				case 4:
				case 5:
				case 7:
				case 10:
				case 12:
					return true;
					break;
				default:
					return false;
					break;	
			}
		} // end function isSpecialMonth
		
		// returns the day of the week of the specified date
		public static function returnDayOfWeek($year, $month, $day) {
			$dayOfWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
			if($dayOfWeek == 0) 
				$dayOfWeek = 7;
				
			return $dayOfWeek;
		} // end function returnDayOfWeek
		
		public static function returnPreviousMonth($month) {
			if($month <= 1) {
				return 12;
			}
			else return $month - 1;
		} // end function returnPreviousMonth
		
		public static function returnNextMonth($month) {
			if($month >= 12) {
				return 1;
			}
			else return $month + 1;
		} // end function returnNextMonth
		
		public static function printMonth($year, $month) {
			$totalDays = 42;
			
			$curMonthStartDay = Calendar::returnDayOfWeek($year, $month, 1);
			
			$curMonthNumOfDays = date("t", mktime(0, 0, 0, $month, 1, $year));
			
			$prevMonthNumOfDays = date("t", mktime(0, 0, 0, Calendar::returnPreviousMonth($month), 1, 
				(Calendar::returnPreviousMonth($month) == 12 ? $year - 1 : $year)
			));
				
			$nextMonthNumOfDays = $totalDays - ($curMonthNumOfDays + $curMonthStartDay) + 1;
			
			$class = Calendar::isSpecialMonth($month) ? "month special" : "month";
			
			echo "\n\t<div class='$class container'>\n\t\t<h2><a href='index.php?year=" . $year . "&amp;month=$month'>" 
				. Calendar::$MONTHS[$month - 1] . "</a></h2>\n";
				
				foreach(CALENDAR::$DAYS_SHORT_NAMES as $day) {
					echo "\n\t\t<h3>" . $day . "</h3>";
				}
				
				echo "\n";
				
				// print the days in the previous month
				for($i = ($prevMonthNumOfDays - $curMonthStartDay + 2); $i <= $prevMonthNumOfDays; $i++) {
					$usedMonth = Calendar::returnPreviousMonth($month);
					
					echo "\n\t\t<span class='other'><a href='index.php?year=" . 
					(Calendar::returnPreviousMonth($month) == 12 ? $year - 1 : $year)
					 . "&amp;month=$usedMonth&amp;day=$i'>" . $i . "</a></span>";
				}
				
				echo "\n";
				
				// print the days in the current month
				for($i = 1; $i <= $curMonthNumOfDays; $i++) {
					echo "\n\t\t<span><a href='index.php?year=" . $year . "&amp;month=$month&amp;day=$i'";
						if(($i == Calendar::$TODAY_DAY) && ($month == Calendar::$TODAY_MONTH) && ($year == Calendar::$TODAY_YEAR)) {
							echo " class='today'";
						}
					echo ">" . $i . "</a></span>";
				}
				
				echo "\n";
				
				// print the days in the next month
				for($i = 1; $i <= $nextMonthNumOfDays; $i++) {
					$usedMonth = Calendar::returnNextMonth($month);
					
					echo "\n\t\t<span class='other'><a href='index.php?year=" . 
					(Calendar::returnNextMonth($month) == 1 ? $year + 1 : $year)
					. "&amp;month=$usedMonth&amp;day=$i'>" . $i . "</a></span>";
				}
				
			echo "\n\t</div>\n";
		} // end function printMonth
		
		public static function printBirthdays($year, $month = '', $day = '', $personName = '', $limit = '') {
			// store where strings
			$where = array();
			
			if(!empty($day)) 
				$where[] = "Day = " . $day;
			
			if(!empty($month)) 
				$where[] = "Month = " . $month;
				
			if(!empty($personName)) 
				$where[] = "PersonName LIKE '%" . $personName . "%'";
			
			$whereStr = implode(" AND ", $where);
			
			// search for birthdays
			$rows = Calendar::searchDatabase("birthdays", '*', $whereStr,
				"Month, Day ASC"); 
		
			if(count($rows) != 0)  {
				echo "\t<div class='fieldHeader'>" . 
					"\n\t\t<h2>" . "Birthdays" . "</h2>" .
				"\n\t</div>\n";
				
				echo "\n\t<div class='fieldContent'>";
				$count = 0;
				
				foreach($rows as $row) {
					if(!empty($limit)) {
						if($limit <= $count) break;	
					}
					
					if($year < $row["Year"]) break;
					
					$id = $row["BirthdayID"];
					$dayOfWeek = Calendar::returnDayOfWeek($year, $row["Month"], $row["Day"]);
					$personName = html_entity_decode($row["PersonName"], ENT_QUOTES);
					$bDay = $row["Day"];
					$bMonth = $row["Month"];
					$bYear = $row["Year"];
					
					echo "\n\t\t\t<div class='seperated container article'>";
							echo "\n\t\t\t\t<div class='cols col3of12'>$personName</div>
							 	\n\t\t\t\t<div class='cols col3of12'>";

							echo Calendar::$DAYS_FULL_NAMES[$dayOfWeek - 1] . 
								" $bDay " . Calendar::$MONTHS[$bMonth - 1] .
							"</div>";
							echo "\n\t\t\t\t<div class='cols col2of12'>";
								printf("%d", $year - $bYear);
							echo " years</div>";
							echo "\n\t\t\t\t<div class='cols col2of12'><button class='birthday'>Edit</button></div>";
							echo "\n\t\t\t\t<div class='cols col2of12'>
								<form method='post' action='index.php?page=data/birthday' class='delete birthday'>
									<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
            						<input type='hidden' name='op' value='delete' />
									<input type='hidden' name='id' value='$id' />
									<input type='hidden' name='name' value=\"$personName\" />
									<input type='hidden' name='date' value='$bDay/$bMonth/$bYear' /> 
									<button>Delete</button>
								</form>
							</div>";
					echo "\n\t\t\t</div>";
					
					$count++;
				}
				
				echo "\n\t</div>\n";
			}
		} // end function printBirthdays
		
		public static function printReminders($year = '', $month = '', $day = '', $comment = '', $limit = '') {
			// search for all reminders
			$rows = Calendar::searchDatabase("reminders", "*", 
				isset($comment) ? "Comment LIKE '%" . htmlentities($comment, ENT_QUOTES) . "%'" : null);
				
			$count = 0;
			$savedComments = array();
			
			$givenDate = new DateTime(
				(!empty($year) ? $year : Calendar::$TODAY_YEAR) . "-" .
				(!empty($month) ? $month : "01") . "-" .
				(!empty($day) ? $day : "01")
			);

			// go through reminders
			foreach($rows as $row) {
				$usedDate = new DateTime($row["Year"] . "-" . $row["Month"] . "-" . $row["Day"]);
				$times = $row["Times"];	
				$modifier = "";
				
				// calculate if the reminder should be part of those shown here
				switch($row["Occurrence"]) {
					case 1: // for reminders shown only once
						if((!empty($year) ? $row["Year"] == $year : true) &&
							(!empty($month) ? $row["Month"] == $month : true) &&
							(!empty($day) ? $row["Day"] == $day : true)) {
								
							$savedComments[] = $row;
						}
					break;

					case 2: // for reminders shown yearly
						$modifier = empty($modifier) ? "+ 1 year" : $modifier;
						
					case 3: // for reminders shown monthly
						$modifier = empty($modifier) ? "+ 1 month" : $modifier;
						
					case 4: // for reminders shown fortnightly
						$modifier = empty($modifier) ? "+ 2 weeks" : $modifier;
						
					case 5: // for reminders shown weekly
						$modifier = empty($modifier) ? "+ 1 week" : $modifier;
						
					case 6: // for reminders shown daily
						$modifier = empty($modifier) ? "+ 1 day" : $modifier;
						
						while($row["Times"] != -1 ? $times > 0 : true) {
							list($thisYear, $thisMonth, $thisDay) = explode("-", $usedDate->format("Y-m-d"));
							
							if((!empty($year) ? $year == $thisYear : true) && 
								(!empty($month) ? $month == $thisMonth : true) && 
								(!empty($day) ? $day == $thisDay : true)) {
									
								$savedComments[] = $row;
								break;
							}
							
							if($givenDate->getTimestamp() < $usedDate->getTimestamp()) {
								break;	
							}
							
							$usedDate->modify($modifier);
							$times -= ($row["Times"] != -1) ? 1 : 0;
						}
					break;
				} // end switch
			} // end foreach */
			
			if(!empty($savedComments)) {
				$count = 1;
				
				echo "\t<div class='fieldHeader'>" . 
					"\n\n\t\t<h2>" . "Reminders" . "</h2>" .
				"\n\t</div>\n";	
				
				echo "\n\t<div class='fieldContent'>";
				
				// go through all the comments
				foreach($savedComments as $thisComment) {
					$id = $thisComment["ReminderID"];
					$comment = html_entity_decode($thisComment["Comment"], ENT_QUOTES);
					$rDay = $thisComment["Day"];
					$rMonth = $thisComment["Month"];
					$rYear = $thisComment["Year"];
					$occurrence = $thisComment["Occurrence"];
					$times = $thisComment["Times"];
					
					echo "<div class='seperated container article'>";
						echo "<div class='cols col8of12'>$comment</div>";
						echo "<div class='cols col2of12'><button class='reminder'>Edit</button></div>";
						echo "<div class='cols col2of12'>
							<form method='post' action='index.php?page=data/reminder'>
								<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
								<input type='hidden' name='op' value='delete' />
								<input type='hidden' name='id' value='$id' />
								<input type='hidden' name='comment' value=\"$comment\" />
								<input type='hidden' name='date' value='$rDay/$rMonth/$rYear' /> 
								<input type='hidden' name='occurrence' value='$occurrence' />
								<input type='hidden' name='repeats' value='$times' />
								<button>Delete</button>
							</form>
						</div>";
					echo "</div>";
					
					if(!empty($limit)) {
						if($count >= $limit) {
							break;
						}
						
						$count++;
					}
				}
				
				echo "\n\t</div>\n";
			}
		} // end function printReminders
		
		public static function printPayments($year = '', $month = '', $day = '', $category = '', $limit = '') {
			// store where strings
			$where = array();
			
			if(!empty($day)) 
				$where[] = "Day = " . $day;
			
			if(!empty($month)) 
				$where[] = "Month = " . $month;
				
			if(!empty($year)) 
				$where[] = "Year = " . $year;
				
			$whereStr = implode(" AND ", $where);
			
			$foundCatIDs = array();
			// if a category name is searched for
			if(!empty($category)) {
				$rows = Calendar::searchDatabase("paymentCategories", "PaymentCategoryID", 
					"Name LIKE '%" . htmlentities($category, ENT_QUOTES) . "%'");
				
				foreach($rows as $row) {
					$foundCatIDs[] = $row["PaymentCategoryID"];
				}
			}
			
			$idStr = implode(" OR Category = ", $foundCatIDs);

			// search for all payments
			// start by finding all the payment categories for payments
			$rows = Calendar::searchDatabase("payments", "Category", 
				$whereStr . 
				(!empty($foundCatIDs) ? 
				(!empty($whereStr) ? " AND ": "") . "Category = " . $idStr : ""), 
				"Category ASC");
			
			if(count($rows) != 0) {
				Calendar::printPaymentCategories();
				
				echo "\t<div class='fieldHeader'>" . 
					"\n\t\t<button class='more payments' title='Show Payments Breakdown'><span>Payments Breakdown</span></button>" . 
					"\n\t\t<button class='more paymentcategories' title='Show Payment Categories'><span>Payment Categories</span></button>" .
					"\n\n\t\t<h2>" . "Payments" . "</h2>" .
				"\n\t</div>\n";
				
				echo "\n\t<div class='fieldContent'>\n\t\t<table class='data payments'>";
					echo "\n\t\t\t<thead>";
						echo "<tr>";
							echo "\n\t\t\t\t<th>Category</th>";
							echo "\n\t\t\t\t<th colspan='4'>Received</th>";
							echo "\n\t\t\t\t<th colspan='4'>Spent</th>";
							echo "\n\t\t\t\t<th>Profit</th>";
						echo "</tr>";
						echo "\n\n\t\t\t<tr>
							<th></th>
							<th>Num</th>
							<th>Average</th>
							<th>Range</th>
							<th>Total</th>
							<th>Num</th>
							<th>Average</th>
							<th>Range</th>
							<th>Total</th>
							<th></th>
						</tr>\n\n\t\t\t";
					echo "\n\t\t\t</thead><tbody>";
					
					$categories = array();
					foreach($rows as $row) {
						$categories[] = $row["Category"];
					}
					$categories = array_unique($categories);
					
					$overallReceivedNum = 0;
					$overallReceivedTotal = 0;
					
					$overallSpentNum = 0;
					$overallSpentTotal = 0;
					
					$count = 0;
					foreach($categories as $catID) {
						if(!empty($limit)) {
							if($count >= $limit) break;
							$count++;
						}
						
						$received = array();
						$spent = array();
						
						// get the category name from database
						$rows = Calendar::searchDatabase("paymentCategories", "Name", "PaymentCategoryID = " . $catID);
						foreach($rows as $row) {
							$catName = html_entity_decode($row["Name"], ENT_QUOTES);
						}
						
						// get all payments for this category 
						$rows = Calendar::searchDatabase("payments", "*", $whereStr . 
							(!empty($whereStr) ? " AND " : "") . "Category = " . $catID);
							
						foreach($rows as $row) {
							if($row["Type"] == 1) {
								$received[] = $row["Amount"];
							}
							else {
								$spent[] = $row["Amount"];
							}
						}
						
						$totalReceived = 0;
						$receivedMin = NULL;
						$receivedMax = NULL;
						foreach($received as $payment) {
							$totalReceived += $payment;
							
							if(!isset($receivedMin) || $payment < $receivedMin) {
								$receivedMin = $payment;
							}
							
							if(!isset($receivedMax) || $payment > $receivedMax) {
								$receivedMax = $payment;
							}
						}
						
						$totalSpent = 0;
						$spentMin = NULL;
						$spentMax = NULL;
						foreach($spent as $payment) {
							$totalSpent += $payment;
							
							if(!isset($spentMin) || $payment < $spentMin) {
								$spentMin = $payment;
							}
							
							if(!isset($spentMax) || $payment > $spentMax) {
								$spentMax = $payment;
							}
						}
						
						$overallReceivedNum += count($received);
						$overallReceivedTotal += $totalReceived;
						
						$overallSpentNum += count($spent);
						$overallSpentTotal += $totalSpent;
						
						echo "<tr>
							<td>$catName</td>
							
							<td>" . count($received) . "</td>
							<td>&pound;";
								printf("%.2f", (count($received) == 0 ? 0 :$totalReceived / count($received)));
							echo "</td>
							<td>";
							
							printf("&pound;%.2f - &pound;%.2f", (count($received) == 0 ? 0 : $receivedMin), 
								(count($received) == 0 ? 0 : $receivedMax));
							
							echo "</td>
							<td>&pound;";
								printf("%.2f", $totalReceived);
							echo "</td>
							
							<td>" . count($spent) . "</td>
							<td>&pound;";
								printf("%.2f", (count($spent) == 0 ? 0 :$totalSpent / count($spent)));
							echo "</td>
							<td>";
							
							printf("&pound;%.2f - &pound;%.2f", (count($spent) == 0 ? 0 : $spentMin), 
								(count($spent) == 0 ? 0 : $spentMax));
							
							echo "</td>
							<td>&pound;";
								printf("%.2f", $totalSpent);
							echo "</td>	\n\t\t\t\t\t<td>&pound;";
								printf("%.2f", $totalReceived - $totalSpent);
							echo "</td>\n\t\t\t</tr>\n\n\t\t\t";
					}
				
				echo "</tbody><tfoot><tr>
						<td>Total</td>
						<td>$overallReceivedNum</td>
						<td></td>
						<td></td>
						<td>&pound;";
						printf("%.2f", $overallReceivedTotal);
					echo "</td>";
				
				echo "\n\t\t\t\t<td>$overallSpentNum</td>
						<td></td>
						<td></td>
						<td>&pound;";
						printf("%.2f", $overallSpentTotal);
					echo "</td><td>&pound;";
						printf("%.2f", $overallReceivedTotal - $overallSpentTotal);
					echo "</td>\n\t\t\t</tr></tfoot>";
				
				echo "\n\t\t</table>\n\t</div>\n";
			}
		} // end function printPayments
		
		public static function printPaymentsBreakdown($year = '', $month = '', $day = '', $category = '', $limit = '') {
			// store where strings
			$where = array();
			
			if(!empty($day)) 
				$where[] = "Day = " . $day;
			
			if(!empty($month)) 
				$where[] = "Month = " . $month;
				
			if(!empty($year)) 
				$where[] = "Year = " . $year;
				
			$whereStr = implode(" AND ", $where);
			
			// search for all payments
			$rows = Calendar::searchDatabase("payments", '*', $whereStr, "Year, Month, Day ASC");
			
			$count = 0;
			$categoryName = '';
			if(count($rows) != 0) {			
				echo "\n\t<div class='moreContent payments'>";
			
				$oldYear = 0;
				$oldMonth = 0;
				$oldDay = 0;
				foreach($rows as $row) {
					$id = $row["PaymentID"];
					$pDay = $row["Day"];
					$pMonth = $row["Month"];
					$pYear = $row["Year"];
					$amount = $row["Amount"];
					$type = $row["Type"];
					$pCat = $row["Category"];
					
					// get category names
					$catNames = Calendar::searchDatabase("paymentCategories", "Name", "PaymentCategoryID = " . $pCat);
					
					foreach($catNames as $catName) {
						$categoryName = html_entity_decode($catName["Name"], ENT_QUOTES);
					}
					
					if(!empty($category) && !preg_match("/$category/i", $categoryName))
						continue;
					
					if(!empty($limit)) {
						if($count >= $limit) break;
						$count++;
					}
					
					if($oldYear != $pYear) {
						echo "\n\n\t\t<h2>" . $pYear . "</h2>";
						$oldYear = $pYear;
					}
					
					if($oldMonth != $pMonth) {
						echo "\n\t\t\t<h3>" . Calendar::$MONTHS[$pMonth - 1] . "</h3>";
						$oldMonth = $pMonth;
					}
					
					if($oldDay != $pDay) {
						echo "\n\n\t\t\t\t<div class='p" . $pDay . $pMonth . $pYear . "'><h4>";
						echo Calendar::$DAYS_FULL_NAMES[Calendar::returnDayOfWeek($pYear, $pMonth, $pDay) - 1];
						echo " " . $pDay . "</h4></div>";
						$oldDay = $pDay;
					}
			
					echo "\n\t\t\t\t<article class='p" . $pDay . $pMonth . $pYear . "'><p class='cols col10of12'>";
						printf("&pound;%.2f", $amount);
						printf(($type == 1) ? " from " : " to ");
					echo $categoryName . "</p>
						<div class='cols col1of12'><button class='payment' title='Edit'></button></div>
						<div class='cols col1of12'>
							<form method='post' action='index.php?page=data/payment'>
								<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
								<input type='hidden' name='op' value='delete' />
								<input type='hidden' name='id' value='$id' />
								<input type='hidden' name='date' value='$pDay/$pMonth/$pYear' /> 
								<input type='hidden' name='amount' value='$amount' />
								<input type='hidden' name='type' value='$type' />
								<input type='hidden' name='category' value='$pCat' />
								<button title='Delete'></button>
							</form>
						</div>
					</article>";
				}
				
				echo "\n\t</div>\n\n";
			}
		} // end function printPaymentsBreakdown
		
		public static function printWorkDone($year = '', $month = '', $day = '', $company = '', $limit = '') {
			// store where strings
			$where = array();
			
			if(!empty($day)) 
				$where[] = "Day = " . $day;
			
			if(!empty($month)) 
				$where[] = "Month = " . $month;
				
			if(!empty($year)) 
				$where[] = "Year = " . $year;
				
			$whereStr = implode(" AND ", $where);

			$foundCompIDs = array();
			// if a company name is searched for
			if(!empty($company)) {
				$rows = Calendar::searchDatabase("company", "CompanyID", 
					"CompanyName LIKE '%" . htmlentities($company, ENT_QUOTES) . "%'");
				
				foreach($rows as $row) {
					$foundCompIDs[] = $row["CompanyID"];
				}
			}
			
			$idStr = implode(" OR CompanyID = ", $foundCompIDs);
			
			// search for all work done
			// start by finding all the companies work was done for
			$rows = Calendar::searchDatabase("workDone", "CompanyID", 
				$whereStr . 
				(!empty($foundCompIDs) ? 
				(!empty($whereStr) ? " AND ": "") . "CompanyID = " . $idStr : ""), 
				"CompanyID ASC");
		
			if(count($rows) != 0) {
				Calendar::printCompanies();
				
				echo "\t<div class='fieldHeader'>" . 
					"\n\t\t<button class='more workdone' title='Show Work Done Breakdown'><span>Work Done Breakdown</span></button>" .
					"\n\t\t<button class='more companies' title='Show Companies'><span>Companies</span></button>" .
					"\n\n\t\t<h2>" . "Work Done" . "</h2>" .
				"\n\t</div>\n";
				
				echo "\n\t<div class='fieldContent'>\n\t\t<table class='data workdone'>";
					echo "\n\t\t\t<thead>";
						echo "<tr>";
							echo "\n\t\t\t\t<th>Company</th>";
							echo "\n\t\t\t\t<th colspan='3'>Regular</th>";
							echo "\n\t\t\t\t<th colspan='3'>Overtime</th>";
							echo "\n\t\t\t\t<th>Times Worked</th>";
							echo "\n\t\t\t\t<th>Average Earned</th>";
							echo "\n\t\t\t\t<th>Total Earned</th>";
						echo "</tr>";
						echo "\n\n\t\t\t<tr>
							<td></td>
							<td>Hours</td>
							<td>Minutes</td>
							<td>Earned</td>
							<td>Hours</td>
							<td>Minutes</td>
							<td>Earned</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>";
					echo "\n\t\t\t</thead><tbody>";
					
					$companies = array();
					foreach($rows as $row) {
						$companies[] = $row["CompanyID"];
					}
					$companies = array_unique($companies);
					
					$overallRegularHours = 0;
					$overallRegularMinutes = 0;
					$overallRegularEarned = 0;
					
					$overallOvertimeHours = 0;
					$overallOvertimeMinutes = 0;
					$overallOvertimeEarned = 0;
					
					$overallWorkCount = 0;
					
					$count = 0;
					foreach($companies as $companyID) {
						if(!empty($limit)) {
							if($count >= $limit) break;
							$count++;
						}
						
						// get the company name from database
						$rows = Calendar::searchDatabase("companies", "CompanyName", "CompanyID = " . $companyID);
						foreach($rows as $row) {
							$companyName = html_entity_decode($row["CompanyName"], ENT_QUOTES);
						}
						
						// get all work done for this compnay 
						$rows = Calendar::searchDatabase("workDone", "*", $whereStr . 
							(!empty($whereStr) ? " AND " : "") . "CompanyID = " . $companyID);
							
						$regularHours = 0;
						$regularMinutes = 0;
						$regularEarned = 0;	
						
						$overtimeHours = 0;
						$overtimeMinutes = 0;
						$overtimeEarned = 0;	
						
						$workCount = 0;
						foreach($rows as $row) {
							$regularHours += $row["Hours"];
							$regularMinutes += $row["Minutes"];
							$regularEarned += $row["Wage"] * ($row["Hours"] + ($row["Minutes"] / 60));
							
							$overtimeHours += $row["OvertimeHours"];
							$overtimeMinutes += $row["OvertimeMinutes"];
							$overtimeEarned += $row["OvertimeWage"] * ($row["OvertimeHours"] + ($row["OvertimeMinutes"] / 60));
							
							$workCount++;
						}
						
						$regularHours += (int)($regularMinutes / 60);
						$regularMinutes %= 60;
						
						$overallRegularHours += $regularHours;
						$overallRegularMinutes += $regularMinutes;
						$overallRegularEarned += $regularEarned;
						
						$overtimeHours += (int)($overtimeMinutes / 60);
						$overtimeMinutes %= 60;
						
						$overallOvertimeHours += $overtimeHours;
						$overallOvertimeMinutes += $overtimeMinutes;
						$overallOvertimeEarned += $overtimeEarned;
						
						$overallWorkCount += $workCount;
						
						echo "\n\n\t\t\t<tr>
							<td>$companyName</td>
							<td>$regularHours</td>
							<td>";
								printf("%02d", $regularMinutes);
							echo "</td>
							<td>&pound;";
								printf("%.2f", $regularEarned);
							echo "</td>
							<td>$overtimeHours</td>
							<td>";
								printf("%02d", $overtimeMinutes);
							echo "</td>
							<td>&pound;";
								printf("%.2f", $overtimeEarned);
							echo "</td>
							<td>$workCount</td>
							<td>&pound;"; 
								printf("%.2f", ($regularEarned + $overtimeEarned) / $workCount);
							echo "</td>
							<td>&pound;";
								printf("%.2f", $regularEarned + $overtimeEarned);
							echo "</td>
						</tr>";
					}
					
					$overallRegularHours += (int)($overallRegularMinutes / 60);
					$overallRegularMinutes %= 60;
					
					$overallOvertimeHours += (int)($overallOvertimeMinutes / 60);
					$overallOvertimeMinutes %= 60;
					
					echo "\n\n\t\t\t</tbody><tfoot><tr>
						<td>Total</td>
						<td>$overallRegularHours</td>
						<td>";
							printf("%02d", $overallRegularMinutes);
						echo "</td>
						<td>&pound;";
								printf("%.2f", $overallRegularEarned);
						echo "</td>
						<td>$overallOvertimeHours</td>
						<td>";
							printf("%02d", $overallOvertimeMinutes);
						echo "</td>
						<td>&pound;";
								printf("%.2f", $overallOvertimeEarned);
						echo "</td>
						<td>$overallWorkCount</td>
						<td>&pound;"; 
							printf("%.2f", ($overallRegularEarned + $overallOvertimeEarned) / $overallWorkCount);
						echo "</td>
						<td>&pound;";
							printf("%.2f",$overallRegularEarned + $overallOvertimeEarned);
						echo "</td>
					</tr></tfoot>";
					
				echo "\n\t\t</table>\n\t</div>\n";
			}
		} // end function printWorkDone
		
		public static function printWorkDoneBreakdown($year = '', $month = '', $day = '', $category = '', $limit = '') {
			// store where strings
			$where = array();
			
			if(!empty($day)) 
				$where[] = "Day = " . $day;
			
			if(!empty($month)) 
				$where[] = "Month = " . $month;
				
			if(!empty($year)) 
				$where[] = "Year = " . $year;
				
			$whereStr = implode(" AND ", $where);
			
			// search for all work done
			$rows = Calendar::searchDatabase("workDone", '*', $whereStr, "Year, Month, Day ASC");
			
			$count = 0;
			$companyName = '';
			if(count($rows) != 0) {			
				echo "\t<div class='moreContent workdone'>";
				
				$oldYear = 0;
				$oldMonth = 0;
				$oldDay = 0;
				foreach($rows as $row) {
					$id = $row["WorkdoneID"];
					$wDay = $row["Day"];
					$wMonth = $row["Month"];
					$wYear = $row["Year"];
					$compID = $row["CompanyID"];
					$hours = $row["Hours"];
					$mins = $row["Minutes"];
					$wage = $row["Wage"];
					$oHours = $row["OvertimeHours"];
					$oMins = $row["OvertimeMinutes"];
					$oWage = $row["OvertimeWage"];
					
					// get company names
					$compNames = Calendar::searchDatabase("companies", "CompanyName", "CompanyID = " . $row["CompanyID"]);

					foreach($compNames as $compName) {
						$companyName = html_entity_decode($compName["CompanyName"], ENT_QUOTES);
					}
					
					if(!empty($category) && !preg_match("/$category/i", $companyName))
						continue;
					
					if(!empty($limit)) {
						if($count >= $limit) break;
						$count++;
					}
					
					if($oldYear != $row["Year"]) {
						echo "\n\t\t<h2>" . $row["Year"] . "</h2>";
						$oldYear = $row["Year"];
					}
					
					if($oldMonth != $row["Month"]) {
						echo "\n\t\t\t<h3>" . Calendar::$MONTHS[$row["Month"] - 1] . "</h3>";
						$oldMonth = $row["Month"];
					}
					
					if($oldDay != $row["Day"]) {
						echo "\n\n\t\t\t\t<div class='w" . $row["Day"] . $row["Month"] . $row["Year"] . "'><h4>";
						echo Calendar::$DAYS_FULL_NAMES[Calendar::returnDayOfWeek($oldYear, $oldMonth, $oldDay) - 1];
						echo " " . $row["Day"] . "</h4></div>";
						$oldDay = $row["Day"];
					}
			
					foreach($compNames as $company) {
						echo "\n\t\t\t\t<article class='w" . $row["Day"] . $row["Month"] . $row["Year"] . "'><p class='cols col10of12'>";
						echo $row["Hours"] . " hours and";
						printf(" %02d minutes", $row["Minutes"]);
						echo " for " . $company["CompanyName"] . " at ";
						printf("&pound;%.2f per hour", $row["Wage"]);
						
						if($row["OvertimeWage"] != 0) {
							echo "<span>";
							echo "Overtime: ";
							echo $row["OvertimeHours"] . " hours and";
							printf(" %02d minutes", $row["OvertimeMinutes"]);
							printf(" at &pound;%.2f per hour", $row["OvertimeWage"]);
							echo "</span>";
						}
						
						echo "</p>
							<div class='cols col1of12'>
								<button class='workdone' title='Edit'></button>
							</div>
							<div class='cols col1of12'>
								<form method='post' action='index.php?page=data/workDone'>
									<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
									<input type='hidden' name='op' value='delete' />
									<input type='hidden' name='id' value='$id' />
									<input type='hidden' name='date' value='$wDay/$wMonth/$wYear' /> 
									<input type='hidden' name='company' value='$compID' />
									<input type='hidden' name='hours' value='$hours:$mins' />
									<input type='hidden' name='wage' value='$wage' />
									<input type='hidden' name='oHours' value='$oHours:$oMins' />
									<input type='hidden' name='oWage' value='$oWage' />
									<button title='Delete'></button>
								</form>
							</div>
						</article>";
					}
				}
				
				echo "\n\t</div>\n";
			}
		} // end function printWorkDoneBreakdown
		
		public static function printPaymentCategories() {
			$rows = Calendar::searchDatabase("paymentCategories", '*', null, "Name");
			
			echo "<div class='moreContent paymentcategories'>";
				$count = 4;
				$newId = 0;
				foreach($rows as $row) {
					$id = $row["PaymentCategoryID"];
					$category = $row["Name"];
					
					if($count % 4 == 0) {
						$newId++;
						echo "<div class='pc" . $newId . "'></div>";
					}
					
					echo "<article class='pc" . $newId . "'>
						<p class='cols col10of12'>" . $row["Name"] . "</p>
						 <div class='cols col1of12'>
						 	<button class='paymentcategory' title='Edit'></button>
						 </div>
						 <div class='cols col1of12'>
						 	<form method='post' action='index.php?page=data/paymentCategory'>
								<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
								<input type='hidden' name='op' value='delete' />
								<input type='hidden' name='id' value='$id' />
								<input type='hidden' name='category' value='$category' />
								<button title='Delete'></button>
							</form>
						 </div>
					</article>";	
					$count++;
				}
			echo "</div>";
		}
		
		public static function printCompanies() {
			$rows = Calendar::searchDatabase("companies", '*', null, "CompanyName");
			
			echo "<div class='moreContent companies'>";
				$count = 2;
				$newId = 0;
				foreach($rows as $row) {
					$id = $row["CompanyID"];
					$company = $row["CompanyName"];
					
					if($count % 2 == 0) {
						$newId++;
						echo "<div class='c" . $newId . "'></div>";
					}
					
					echo "<article class='c" . $newId . "'>
						<p class='cols col10of12'>" .  $row["CompanyName"] . "</p>
					 	<div class='cols col1of12'>
						 	<button class='company' title='Edit'></button>
						 </div>
						 <div class='cols col1of12'>
						 	<form method='post' action='index.php?page=data/company'>
								<input type='hidden' name='query' value='" . Calendar::$QUERY . "' />
								<input type='hidden' name='op' value='delete' />
								<input type='hidden' name='id' value='$id' />
								<input type='hidden' name='company' value='$company' />
								<button title='Delete'></button>
							</form>
						 </div>
					</article>";	
					$count++;
				}
			echo "</div>";
		}
	} // end class Calendar
?>