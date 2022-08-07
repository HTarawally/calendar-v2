<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	// Abstract class that provides everything
	// needed for anything that is basically a category

	abstract class Category extends SavedItem {
		private $name; // the name for this category i.e. for a company, it would be the company name

		public function __construct($id, $name, $updated) {
			parent::__construct($id, $updated);

			$this->setCatName($name);
		} // end constructor

		public final function setCatName($catName) {
			if(is_string($catName)) {
				$catName = trim(htmlentities(strip_tags($catName), ENT_QUOTES));

				if(strlen($catName) < 255 && strlen($catName) >= 2) {
					$this->name = $catName;
				}
				else throw new InvalidArgumentException("The category name should be between 2 and 255 characters long");
			}
			else throw new InvalidArgumentException("The category name should be a string value");
		} // end function setCatName

		public final function returnCatName() {
			return $this->name;
		} // end function returnCatName
	}
?>
