<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	class Utility extends Config {
		public function __construct() {
			parent::__construct();
		} // end constructor

		public static function returnTitle() {
			switch(Config::$PAGE) {
				case "year":
					$title = Utility::$PAGES["year"];
				break;

				case "month":
					$title = Calendar::$MONTHS[Utility::$PAGES["month"] - 1] . " " . Utility::$PAGES["year"];
				break;

				case "day":
					$dayOfWeek = Calendar::returnDayOfWeek(Utility::$PAGES["year"], Utility::$PAGES["month"], Utility::$PAGES["day"]);

					$title = Calendar::$DAYS_FULL_NAMES[$dayOfWeek - 1] . " " . Utility::$PAGES["day"] . " " .
						Calendar::$MONTHS[Utility::$PAGES["month"] - 1] . " " . Utility::$PAGES["year"];
				break;

				default:
					$title = Utility::PAGE_NOT_FOUND;

					if(preg_match("/\//", Config::$PAGE ? Config::$PAGE : '')) {
						list($add, $page) = explode("/", Config::$PAGE);
						$title = ucwords($_POST["op"]) . " " . ucwords($page);
					}
				break;
			}

			return $title;
		} // end function returnTitle

		public static function printHeader() {
			switch(Utility::$PAGE) {
				case "year":
					echo "<a title='Previous Year' href='index.php?year=" . (Utility::$PAGES["year"] - 1) .
						"'><div class='left'></div></a>\n";

					echo "\t<a title='Next Year' href='index.php?year=" . (Utility::$PAGES["year"] + 1) .
						"'><div class='right'></div></a>\n";

					echo "\n\t<h1><a title='To Current Year' href='index.php'>" . Utility::returnTitle() . "</a></h1>\n";
				break;

				case "month":
					echo "<a title='Previous Month' href='index.php?year=" .
						(Calendar::returnPreviousMonth(Utility::$PAGES["month"]) == 12 ? Utility::$PAGES["year"] - 1 : Utility::$PAGES["year"]) 						. "&amp;month=" . Calendar::returnPreviousMonth(Utility::$PAGES["month"]) . "'><div class='left'></div></a>\n";

					echo "\t<a title='Next Month' href='index.php?year=" .
						(Calendar::returnNextMonth(Utility::$PAGES["month"]) == 1 ? Utility::$PAGES["year"] + 1 : Utility::$PAGES["year"]) .
						"&amp;month=" . Calendar::returnNextMonth(Utility::$PAGES["month"]) . "'><div class='right'></div></a>\n";

					echo "\n\t<h1><a title='Up' href='index.php?year=" .
						Utility::$PAGES["year"] . "'>" . Utility::returnTitle() . "</a></h1>\n";
				break;

				case "day":
					$nextDayYear = (Utility::$PAGES["month"] == 12 && Utility::$PAGES["day"] == 31) ?
						Utility::$PAGES["year"] + 1 : Utility::$PAGES["year"];

					if(Utility::$PAGES["month"] == 12 && Utility::$PAGES["day"] == 31) $nextDayMonth = 1;
					else if(Utility::$PAGES["day"] == date("t", mktime(0, 0, 0, Utility::$PAGES["month"], 1, Utility::$PAGES["year"])))
						$nextDayMonth = Utility::$PAGES["month"] + 1;
					else $nextDayMonth = Utility::$PAGES["month"];

					if(Utility::$PAGES["day"] == date("t", mktime(0, 0, 0, Utility::$PAGES["month"], 1, Utility::$PAGES["year"])))
						$nextDay = 1;
					else $nextDay = Utility::$PAGES["day"] + 1;

					$previousDayYear = (Utility::$PAGES["month"] == 1 && Utility::$PAGES["day"] == 1) ?
						Utility::$PAGES["year"] - 1 : Utility::$PAGES["year"];

					if(Utility::$PAGES["month"] == 1 && Utility::$PAGES["day"] == 1) $previousDayMonth = 12;
					else if(Utility::$PAGES["day"] == 1)
						$previousDayMonth = Utility::$PAGES["month"] - 1;
					else $previousDayMonth = Utility::$PAGES["month"];

					if(Utility::$PAGES["day"] == 1)
						$previousDay = date("t", mktime(0, 0, 0, Utility::$PAGES["month"] - 1, 1, Utility::$PAGES["year"]));
					else $previousDay = Utility::$PAGES["day"] - 1;

					echo "<a title='Previous Day' href='index.php?year=$previousDayYear&amp;month=$previousDayMonth&amp;day=$previousDay'>
						<div class='left'></div></a>\n";

					echo "\t<a title='Next Day' href='index.php?year=$nextDayYear&amp;month=$nextDayMonth&amp;day=$nextDay'>
						<div class='right'></div></a>\n";

					echo "\n\t<h1><a title='Up' href='index.php?year=" . Utility::$PAGES["year"] .
						"&amp;month=" . Utility::$PAGES["month"] . "'>" . Utility::returnTitle() . "</a></h1>\n";
				break;

				default:
					echo "<h1><a title='Back to home' href='index.php'>" . Utility::returnTitle() . "</a></h1>\n";
				break;
			} // end switch
		} // end function printHeader

		public static function searchDatabase($table, $field = '*', $where = '', $orderBy = '', $limit = '') {
			$results = array();

			$sql = "SELECT " . $field . " FROM " . $table .
				(!empty($where) ? " WHERE " . $where : "") .
				(!empty($orderBy) ? " ORDER BY " . $orderBy : "") .
				(!empty($limit) ? " LIMIT " . $limit : "");

			$sql = trim($sql);

			$result = Calendar::$MYSQLI->query($sql);

			while($row = $result->fetch_assoc()) {
				$results[] = $row;
			}

			$result->free_result();
			return $results;
		} // end function searchDatabase
	} // end class Utility
?>
