<?php
	// Abstract class that provides everything 
	// needed for anything to do with payments or work

	abstract class Money extends Life {
		private $catID; // category id used to identify a company or payment category
		
		public function __construct($id, $day, $month, $year, $category, $updated) {
			parent::__construct($id, $day, $month, $year, $updated);
			
			$this->setCatID($category);
		} // end constructor
		
		public final function setCatID($catID) {
			if(preg_match("/^[0-9]{1,}$/", $catID)) { // if catID is an integer
				$this->catID = $catID;
			}
			else throw new InvalidArgumentException("Category ID should be an integer value");
		} // end function setCatID
		
		public final function returnCatID() {
			return $this->catID;
		} // end function returnCatID
	}
?>