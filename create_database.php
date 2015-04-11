<html>
<head>
	<title>Create CFC ScorePredictor Database</title>
	<style>
		div {margin: auto; width:50%; font: bold 16px verdana, sans-serif; }
	</style>
</head>

<body>
	<div>
		<?php
			//Simple: Creating database and the three tables
            $db_conn = mysql_connect("localhost", "root", "com214");
            if (!$db_conn)
                die("Unable to connect: " . mysql_error());  // die is similar to exit
            
            if (mysql_query("CREATE DATABASE CFC_ScorePredictor", $db_conn))
                echo "Database ready";
            else
                echo "Unable to create database: " . mysql_error();
                
            if(!mysql_select_db("CFC_ScorePredictor", $db_conn))
				die("<p>Database doesn't exist: " . mysql_error());
			else {
				$cmd = "CREATE TABLE predictions(
							username varchar(20) NOT NULL PRIMARY KEY,
							matchid varchar(10),
							result varchar(20),
							scoreline varchar(10),
							scorers varchar(50),
							points varchar(10))";
				mysql_query($cmd);
				
				$cmd = "CREATE TABLE users(
							username varchar(20) NOT NULL PRIMARY KEY,
							password varchar(20),
							firstName varchar(20),
							lastName varchar(20),
							totalpoints varchar(10))";
				mysql_query($cmd);
				
				$cmd = "CREATE TABLE fixtures(
							matchid varchar(10) NOT NULL PRIMARY KEY,
							opponent varchar(50),
							time varchar(20),
							result varchar(20),
							scoreline varchar(10),
							scorers varchar(50))";
				mysql_query($cmd);
			
				echo("<p>"."Tables Created!");
			}
                    
            mysql_close($db_conn);
        ?>     
    </div>
    
</body>