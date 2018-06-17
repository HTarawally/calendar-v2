<?php
	class Config {
		const SCRIPT_NAME = "Project Nirvana";
		const VERSION = "2.0";
		const PAGE_NOT_FOUND = "page not found...";

		public static $MYSQLI; // variable used to manipulate connection to database

		public static $NOW; // today's time and date

		public static $TODAY_YEAR;
		public static $TODAY_MONTH;
		public static $TODAY_DAY;

		public static $NOW_HOURS;
		public static $NOW_MINUTES;
		public static $NOW_SECONDS;

		public static $QUERY;
		public static $PAGES = array();
		public static $PAGE;

		public static $DB_NAME;
		public static $DB_HOST;
		public static $USER;
		public static $PASS;

		private static $COUNT = 0;

		public function __construct() {
			if(Config::$COUNT == 0) {
				Config::$COUNT++;

				date_default_timezone_set("Europe/London");

				Config::$DB_NAME = "database";
				Config::$DB_HOST = "localhost";
				Config::$USER = "user";
				Config::$PASS = "password";

				Config::$MYSQLI = new mysqli(Config::$DB_HOST, Config::$USER, Config::$PASS, Config::$DB_NAME);

				/* check connection */
				if (Config::$MYSQLI->connect_errno) {
					exit();
				}

				Config::$TODAY_YEAR = date("Y");
				Config::$TODAY_MONTH = date("m");
				Config::$TODAY_DAY = date("d");

				Config::$NOW_HOURS = date("H");
				Config::$NOW_MINUTES = date("i");
				Config::$NOW_SECONDS = date("s");

				Config::$NOW = Config::$TODAY_YEAR . "-" . Config::$TODAY_MONTH . "-" . Config::$TODAY_DAY .
					" " . Config::$NOW_HOURS . ":" . Config::$NOW_MINUTES . ":" . Config::$NOW_SECONDS;

				Config::$QUERY = $_SERVER['QUERY_STRING'];
				parse_str(Config::$QUERY, Config::$PAGES); // store query string in array $PAGES

				// determine which page to display
				if(isset(Config::$PAGES["page"])) {
					if((Config::$PAGES["page"] != "year") && (Config::$PAGES["page"] != "month") && (Config::$PAGES["page"] != "day"))
						Config::$PAGE = Config::$PAGES["page"];
				}
				else if(isset(Config::$PAGES["day"])) {
					Config::$PAGE = "day";
				}
				else if(isset(Config::$PAGES["month"])) {
					Config::$PAGE = "month";
				}
				else if(isset(Config::$PAGES["year"])) {
					Config::$PAGE = "year";
				}
				else { // set default page as the year
					Config::$PAGE = "year";
					Config::$PAGES["year"] = Config::$TODAY_YEAR;
				}

				// make sure that the year is in the format xxxx
				if(isset(Config::$PAGES["year"])) {
					if(strlen(Config::$PAGES["year"]) != 4) {
						Config::$PAGES["year"] = Config::$TODAY_YEAR;
					}
				} // end if

				// make sure the month is in the correct range
				if(isset(Config::$PAGES["month"])) {
					// make sure the year is set as well
					if(!isset(Config::$PAGES["year"])) {
						Config::$PAGES["year"] = Config::$TODAY_YEAR;
					}

					if(Config::$PAGES["month"] <= 0) {
						Config::$PAGES["month"] = 1;
					}
					else if(Config::$PAGES["month"] >= 13) {
						Config::$PAGES["month"] = 12;
					}
				} // end if

				// make sure the day is in the correct range
				if(isset(Config::$PAGES["day"])) {
					// make sure the month is set as well
					if(!isset(Config::$PAGES["month"])) {
						Config::$PAGES["month"] = Config::$TODAY_MONTH;
					}

					// calculate the last numerical day in the given month
					$lastDay = date("t", mktime(0, 0, 0, Config::$PAGES["month"], 1, Config::$PAGES["year"]));

					// make sure the day is in the correct range
					if(Config::$PAGES["day"] <= 0) {
						Config::$PAGES["day"] = 1;
					}
					else if(Config::$PAGES["day"] > $lastDay) {
						Config::$PAGES["day"] = $lastDay;
					}
				} // end if
			} // end outer if
		} // end constructor
	} // end class Config
?>
