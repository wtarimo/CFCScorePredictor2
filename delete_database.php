<html>
<head>
	<title>Delete ScorePredictor Database</title>
	<style>
		div {margin: auto; width:50%; font: bold 16px verdana, sans-serif; }
	</style>
</head>

<body>
	<div>
		<?php
			//Simple: Deleting the database and tables
            $db_conn = mysql_connect("localhost", "root", "com214");
            if (!$db_conn)
                die("Unable to connect: " . mysql_error());
				
			$retval = mysql_query( "DROP DATABASE CFC_ScorePredictor", $db_conn );
			if(! $retval )
  				die('Unable to delete database: ' . mysql_error());

			echo "Database deleted successfully\n";		
        ?>     
    </div>   
</body>