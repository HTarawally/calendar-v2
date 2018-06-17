	<!-- forms ************ forms ************ -->
    <form class="inputForm birthday" method="post" action="index.php?page=data/birthday">  <!-- birthday form -->
        <div class="cols col4of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="birthdayPersonName">Name:</label>
            <input type="text" name="name" id="birthdayPersonName" />
        </div>
        <div class="cols col4of12">
            <label for="birthdayDOB">Date Of Birth:</label>
            <input type="text" name="date" id="birthdayDOB" <?php printDefaultDateValue(); ?> />
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form>  <!-- end add birthday form -->
    
    <form class="inputForm reminder" method="post" action="index.php?page=data/reminder"> <!-- reminder form -->
    	<div class="cols col3of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="reminderComment">Comment:</label>
            <input type="text" name="comment" id="reminderComment" />
        </div>
        <div class="cols col3of12">
            <label for="reminderDate">Date:</label>
            <input type="text" name="date" id="reminderDate" <?php printDefaultDateValue(); ?> />
        </div>
        <div class="cols col2of12">
            <label for="reminderOccurrences">Occurrence:</label>
            <select name="occurrence" id="reminderOccurrences">
                <option value="1">Once</option>
                <option value="2">Yearly</option>
                <option value="3">Monthly</option>
                <option value="4">Bi-weekly</option>
                <option value="5">Weekly</option>
                <option value="6">Daily</option>
            </select>
        </div>
        <div class="cols col2of12">
        	<label for="reminderRepeats">Repeats:</label>
            <input type="text" name="repeats" id="reminderRepeats" value="-1" />
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form> <!-- end add reminder form -->
    
    <form class="inputForm payment" method="post" action="index.php?page=data/payment"> <!-- payment form -->
    	<div class="cols col2of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="paymentDate">Date:</label>
            <input type="text" name="date" id="paymentDate" <?php printDefaultDateValue(); ?> />
        </div>
        <div class="cols col2of12">
            <label for="paymentAmount">Amount<span>(&pound;)</span>:</label>
            <input type="text" name="amount" id="paymentAmount" />
        </div>
        <div class="cols col2of12">
            <label for="paymentType">Type:</label>
            <select name="type" id="paymentType">
                <option value="1">Received</option>
                <option value="2">Spent</option>
            </select>
        </div>
        <div class="cols col2of12">
            <label for="paymentCategory">Category:</label>
            <select name="category" id="paymentCategory">
                <?php
					$paymentCats = Calendar::searchDatabase("paymentCategories");
					
					foreach($paymentCats as $paymentCat) {
						$id = $paymentCat["PaymentCategoryID"];
						$cat = $paymentCat["Name"];
						
						echo "<option value='$id'>" . $cat . "</option>\n";	
					}
				?>
            </select>
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form> <!-- end add payment form -->
    
    <form class="inputForm workdone" method="post" action="index.php?page=data/workDone"> <!-- workdone form -->
    	<div class="cols col2of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="workDoneDate">Date:</label>
            <input type="text" name="date" id="workDoneDate" <?php printDefaultDateValue(); ?> />
        </div>
        <div class="cols col2of12">
            <label for="workDoneCompany">Company:</label>
            <select name="company" id="workDoneCompany">
                <?php
					$companies = Calendar::searchDatabase("companies");
					
					foreach($companies as $company) {
						$id = $company["CompanyID"];
						$comp = $company["CompanyName"];
						
						echo "<option value='$id'>" . $comp . "</option>\n";	
					}
				?>
            </select>
        </div>
        <div class="cols col1of12">
            <label for="workDoneHours">Hours:</label>
            <input type="text" name="hours" id="workDoneHours" />
        </div>
        <div class="cols col1of12">
            <label for="workDoneWage">Wage<span>(&pound;)</span>:</label>
            <input type="text" name="wage" id="workDoneWage" />
        </div>
        <div class="cols col1of12">
            <label for="workDoneOHours">oHours:</label>
            <input type="text" name="oHours" id="workDoneOHours" value="0:00" />
        </div>
        <div class="cols col1of12">
            <label for="workDoneOWage">oWage<span>(&pound;)</span>:</label>
            <input type="text" name="oWage" id="workDoneOWage" value="0.00" />
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form> <!-- end add workdone form -->

	<form class="inputForm company" method="post" action="index.php?page=data/company">  <!-- company form -->
        <div class="cols col8of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="companyName">Company Name:</label>
            <input type="text" name="company" id="companyName" />
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form> <!-- end add company form -->
    
    <form class="inputForm paymentcategory" method="post" action="index.php?page=data/paymentCategory">  <!-- payment Category form -->
        <div class="cols col8of12">
        	<input type="hidden" name="query" value="<?php echo Config::$QUERY; ?>" />
            <input type="hidden" name="op" value="insert" />
            <input type="hidden" name="id" value="0" />
            <label for="paymentCat">Payment Category:</label>
            <input type="text" name="category" id="paymentCat" />
        </div>
        <div class="cols col2of12">
            <input type="submit" value="Submit" />
        </div>
        <div class="cols col2of12">
        	<input type="button" value="Close" />
        </div>
    </form> <!-- end add company form -->