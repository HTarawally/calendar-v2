	<?php 	
		printLeftSide(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
	?>
    
    <aside class="right_pane container">
    	<div class="fieldContent" id="formHolder"></div>    
		<?php
            Calendar::printBirthdays(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
            
            Calendar::printReminders(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
        
            Calendar::printPayments(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
        
            Calendar::printWorkDone(Calendar::$PAGES["year"], Calendar::$PAGES["month"]);
            
            Calendar::printPaymentsBreakdown(Calendar::$PAGES["year"], Calendar::$PAGES["month"]); 
            
            Calendar::printWorkDoneBreakdown(Calendar::$PAGES["year"], Calendar::$PAGES["month"]); 
        ?>
	</aside>