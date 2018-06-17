<?php
	if(file_exists("install/index.php")) header("Location: install/index.php");

	require_once("includes/config.php");
	require_once("includes/functions.php");
	require_once("Interfaces/iDatabaseTasks.php");

	function __autoload($class) {
		require_once("Classes/$class.class.php");
	}
	
	$cal = new Calendar();
?>
<!doctype html>
<html>
	<head lang="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Calendar :: <?php echo Calendar::returnTitle(); ?></title>
    
    <link rel="icon" type="image-x/icon" href="images/favicon.ico" />
    
    <!-- styles needed by jScrollPane -->
    <link rel="stylesheet" href="jscrollpane/jquery.jscrollpane.css" />
    <link rel="stylesheet" href="jscrollpane/jscrollpane.css" />
    
    <!-- jquery ui style sheet -->
    <link rel="stylesheet" href="jquery/jquery-ui.min.css" />
    
    <!-- my style sheets -->
    <link rel="stylesheet" href="structure.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="media.css" />
    
    <!-- the jquery library -->
    <script src="jquery/jquery-1.11.2.min.js"></script>
    
    <!-- the jquery user-interface library -->
    <script src="jquery/jquery-ui.min.js"></script>
    
    <!-- the jScrollPane script -->
    <script src="jscrollpane/jquery.jscrollpane.min.js"></script>
    
    <!-- the mousewheel plugin - optional to provide mousewheel support -->
    <script src="jscrollpane/jquery.mousewheel.js"></script>
    
    <!-- my custom scripts -->
    <script src="functions.js"></script>
    <script src="scripts.js"></script>
</head>

<body>
    <header class="seperated container">
    	<?php Calendar::printHeader(); ?>
    </header>
    
    <main class="seperated container"> 
    	<?php 
			try {
				if(file_exists("pages/" . Calendar::$PAGE . ".php")) {
					require_once("pages/" . Calendar::$PAGE . ".php"); 
				}
				else {
					throw new Exception(Calendar::PAGE_NOT_FOUND);
				}
			}
			catch(Exception $e) {
				echo $e->getMessage();	
			}
		?>
    </main>
    
    <footer class="seperated container">
    	<!--- <button onClick="document.location='index.php?page=records'">Records</button> -->
        
        <p>
        	Copyright &copy; 2014 - <?php echo Calendar::$TODAY_YEAR . " Calendar" ?>. All rights reserved
        </p>
    </footer>
    
    <div id="blackOut"> 
    </div>
    
    <div id="error">
    </div>
    
    <?php 
		require_once("includes/forms.php"); 
		Calendar::$MYSQLI->close();
	?>
</body>
</html>