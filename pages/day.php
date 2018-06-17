	<?php 	
		printLeftSide(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
	?>
    
    <aside class="right_pane container">
    	<div class="fieldContent" id="formHolder"></div>
		<?php 		
            Calendar::printBirthdays(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
            
            Calendar::printReminders(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
        
            Calendar::printPayments(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
        
            Calendar::printWorkDone(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
            
            Calendar::printPaymentsBreakdown(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
            
            Calendar::printWorkDoneBreakdown(Calendar::$PAGES["year"], Calendar::$PAGES["month"], Calendar::$PAGES["day"]);
        ?>
	</aside>