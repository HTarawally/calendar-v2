<?php
	require_once("../includes/config.php");
	require_once("installQueries.php");

	function autoloader($class) {
		require_once("../Classes/$class.class.php");
	}

	spl_autoload_register('autoloader');

	$cal = new Calendar();

	if(isset($_GET["step"])) {
		$step = (int)$_GET["step"];

		if($step < 1) {
			$step = 1;
		}
		else if($step > 3) {
			$step = 3;
		}
	}
	else $step = 1;

	function returnTableCount() {
		$tableCountQuery = "select count(*) from information_schema.tables
			where table_type = 'BASE TABLE' and table_schema = '" . Calendar::$DB_NAME . "'";

		$result = Calendar::$MYSQLI->query($tableCountQuery);
		$rows = $result->fetch_assoc();

		return $rows["count(*)"];
	}
?>

<!doctype html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo Calendar::SCRIPT_NAME . " " . Calendar::VERSION . " Installation" ?></title>

    <link rel="stylesheet" href="style.css" />
</head>

<body>
	<main>
    	<aside>
        	<ul>
            	<li <?php if($step == 1) echo "class='selected'" ?>>Installation Home</li>
                <li <?php if($step == 2) echo "class='selected'" ?>>Installing...</li>
                <li <?php if($step == 3) echo "class='selected'" ?>>Completed</li>
            </ul>
        </aside>

        <aside>
        	<h1><?php echo Calendar::SCRIPT_NAME . " " . Calendar::VERSION . " Installation" ?></h1>
            <div>
            	<?php
                	switch($step) {
						case 1:
							if(!returnTableCount()) {
								echo "<p>An empty database has been detected. A fresh installation will take place.</p>";
							}
							else {
								echo "<p>A database that already contains tables has been detected.
									This will be upgraded to the latest version.</p>";
							}

							echo "<table>
								<tr>
									<td>Database Name:</td>
									<td>" . Calendar::$DB_NAME . "</td>
								</tr>

								<tr>
									<td>Database Host:</td>
									<td>" . Calendar::$DB_HOST . "</td>
								</tr>

								<tr>
									<td>User:</td>
									<td>" . Calendar::$USER . "</td>
								</tr>
							</table>";

							echo "<a href='index.php?step=2'>Start Installation</a>";
						break;

						case 2:
							echo "<p>Installing... Please wait...</p>";

							if(returnTableCount()) { // if tables already exist, upgrade the tables
								require_once("upgradeQueries.php");

								foreach($upgradeQueries as $query) {
									Calendar::$MYSQLI->query($query);
								}
							}

							foreach($installQueries as $query) {
								Calendar::$MYSQLI->query($query);
							}

							echo "<script>document.location.href = \"index.php?step=3\"</script>";
						break;

						case 3:
							echo "<p>" . Calendar::SCRIPT_NAME . " " . Calendar::VERSION . " is now ready to use.
								Please delete the install directory before continuing.</p>";
						break;
					}
                ?>
            </div>
        </aside>
    </main>

    <?php Calendar::$MYSQLI->close(); ?>
</body>
</html>
