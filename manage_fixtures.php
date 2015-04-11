<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
<link rel="stylesheet" href="cfc_score_predictor.css">
<style> input[placeholder] {width:350px; } </style>

	<title>Admin/Manager Mode: Accounts: CFC Fan Score Predictor</title>
	
</head>

<body>
	<div id = "wrapper">
    	<header id = "top_header">ADD FIXTURES & SUBMIT RESULTS</header>
		<div id="buttons"><form method="link" action="index.php"><input type="submit" value="EXIT!" style="float:left;"></form></div>
        <form id = "add_fixture" action="manage_fixtures.php" method="get">
            <h1>ADD FIXTURE</h1>
            GAME ID: <input type="number" name="matchid" placeholder="ID Number" required> <br />
            OPPONENT: <input type="text" name="opponent" placeholder="Opponent Team Name" required> <br />
            TIME:  <input type="text" name="time" placeholder="Eg.2007-12-31 11:30:00" required> <br />
            <input type="submit" name="button" value="ADD"  />
          
        </form>
        <form id = "submit_result" action="manage_fixtures.php" method="get">
            <h1>SUBMIT RESULT</h1>
            GAME ID: <input type="number" name="matchid" placeholder="ID Number" required> <br />
            RESULT:   <input type="text" name="result" placeholder="Type: Win, Tie or Loss" required> <br />
			SCORELINE:   <input type="text" name="scoreline" placeholder="(Chelsea-Opponent) Eg. '3-1'" required> <br />
			GOAL SCORERS:   <input type="text" name="scorers" placeholder="Player Numbers separated by commas Eg. '11,24,5'"> <br />
			NEXT GAME ID: <input type="number" name="nextgame" placeholder="ID Number"> <br />
			<input type="submit" name="button" value="SUBMIT"  />
        </form>

		<?php
			$db_conn = mysql_connect("localhost", "root", "com214");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error());
						  
			if( !mysql_select_db("CFC_ScorePredictor", $db_conn) )
				die("Database doesn't exist: " . mysql_error());
				
			if(isset($_GET["button"]) ){
				//Add new fixture to the table
				if( $_GET["button"] == "ADD" ) {
					$cmd = "INSERT INTO fixtures (matchid, opponent, time, result, scoreline, scorers)
							  VALUES ('" . $_GET['matchid'] . "', '" . $_GET['opponent'] . "', '" . $_GET['time'] ."','','','')";
					mysql_query($cmd, $db_conn);
				}
				
				//Submit/update official game result in the fixtures table
				if( $_GET["button"] == "SUBMIT" ) {
					$f = fopen("nextgame.txt","w");
					fputs($f,$_GET['nextgame']);
					fclose($f);
					$cmd = "UPDATE fixtures SET result='" . $_GET['result'] . "', scoreline='" . $_GET['scoreline'] ."', scorers='" . $_GET['scorers'] . "' WHERE matchid='" . $_GET['matchid'] . "'";
					mysql_query($cmd, $db_conn);
					
					//Calculate & assign points to all predictions based on the official results
					$records = mysql_query("SELECT * FROM predictions");
					while($row = mysql_fetch_array($records)) {
						$points = 0;
						//Checking if result is correct
						if (strtolower($row['result'])==strtolower($_GET['result'])){
							$points=$points+1;
						}
						
						//Checking if scoreline is exact
						$scoreline1=$row['scoreline'];
						$scoreline2=$_GET['scoreline'];
						if (((int)$scoreline1[0]==(int)$scoreline2[0]) and ((int)$scoreline1[2]==(int)$scoreline2[2])){
							$points = $points+5;
						}
						
						//Check for each correct CFC goal scorer
						if ($row['scorers']!="" and $_GET['scorers']!="") {
							$scorers1=explode(',',$row['scorers']);
							$scorers2=explode(',',$_GET['scorers']);
							foreach ($scorers2 as $score) {
								if(in_array($score,$scorers1)){
									$key = array_search($score,$scorers1);
									unset($scorers1[$key]);
									$points=$points+1;
								}
							}
						}
						
						//Update users' prediction points and users totalpoints
						$cmd = "UPDATE predictions SET points='" . $points. "' WHERE username='" . $row['username'] . "'";
						mysql_query($cmd, $db_conn);
						$cmd = "UPDATE users SET totalpoints=totalpoints + '" . $points. "' WHERE username='" . $row['username'] . "'";
						mysql_query($cmd, $db_conn);
		
					}	
				}
			}
			
			//Displaying all fixtures table as by the manager/admin
			echo( "\t<article><h1>FIXTURES</h1><br />" . PHP_EOL );																	
			$records = mysql_query("SELECT * FROM fixtures ORDER BY matchid DESC");
			echo( "\t\t<table> <tr> <td>MATCH ID#</td> <td>OPPONENT</td> <td>TIME</td> <td>RESULT</td> <td>SCORELINE</td> <td>CFC SCORERS</td></tr>" . PHP_EOL  );	
			
			while($row = mysql_fetch_array($records))
				echo( "\t\t\t<tr> <td>" . $row['matchid'] . "</td> <td>" . $row['opponent'] . "</td> <td>" . $row['time'] . "</td> <td>" . $row['result'] . "</td> <td>" . $row['scoreline'] . "</td> <td>" . $row['scorers'] . "</td></tr>" . PHP_EOL );				
			echo("\t\t</table>" . PHP_EOL . "\t</article>");
																
			mysql_close($db_conn);
        ?>  
		<footer id="bottom_footer"> 
		William Tarimo - COM214 - Web Technologies & Mobile Computing - Final Project - Spring 2012
		</footer>
    </div>
    
</body>
</html>