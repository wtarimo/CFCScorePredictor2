
<!DOCTYPE html>
<html lang="en">

<head>
<title>Predictions: CFC Fan Score Predictor</title>
<meta charset="utf-8">
<link rel="stylesheet" href="cfc_score_predictor.css">
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
<style> input[placeholder] {width:350px; } </style>


</head>

<body>
	<div id="wrapper">

		<header id="top_header"> CFC FAN SCORE-PREDICTOR </header>
		
		<div>
		<?php
			session_start();
			$db_conn = mysql_connect("localhost", "root", "com214");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error());
						  
			if( !mysql_select_db("CFC_ScorePredictor", $db_conn) )
				die("Database doesn't exist: " . mysql_error());
				
			//Getting current game id from saved file
			$file=fopen("nextgame.txt","r") or exit("Unable to open file!");
			$nextgame = fgetc($file);
			fclose($file);
			
			//Getting session user's names from users table for welcoming message
			$record = mysql_query("SELECT firstName,lastName FROM users WHERE username ='".$_SESSION['user']."'");
			$row = mysql_fetch_array($record);
			echo("<div id='box_left1' ><h1>WELCOME ".$row['firstName']." ".$row['lastName']."!</h1><p>");
			
			//Search fixtures table for corresponding game time and opponent
			$record = mysql_query("SELECT opponent,time FROM fixtures WHERE matchid ='".$nextgame."'");
			$row = mysql_fetch_array($record);
			
			echo("<h1>MAKE YOUR NEXT PREDICTION!</h1><p>");
			echo("NEXT GAME ON: ".$row['time']."<br />");
			echo("OPPONENT: ".$row['opponent']."<br />");
			echo("GAME ID: ".$nextgame."<br /></p>");
		?>
		
		<form id = "submit_result" action="predict.php" method="get">
            <h2>PREDICTION!</h2>
            GAME ID: <input type="number" name="matchid" placeholder="ID Number" required> <br />
            RESULT:   <input type="text" name="result" placeholder="Type: Win, Tie or Loss" required> <br />
			SCORELINE:   <input type="text" name="scoreline" placeholder="(Chelsea-Opponent) Eg. '3-1'" required> <br />
			GOAL SCORERS:   <input type="text" name="scorers" placeholder="Player Numbers separated by commas Eg. '11,24,5'"> <br />
			<p><input type="submit" name="button" value="SAVE/UPDATE PREDICTION!"  />
        </form></div>
		
		<div id="players"><form><input type='submit' name='button' value='LOG OUT!'  /></form></div>
		<div id="players" >
		<h2>CFC PLAYERS!</h2>
		
		***FW***<br />
		9. Fernando Torres<br />
		10. Juan Mata<br />
		11. Didier Drogba<br />
		23. Daniel Sturridge<br />
		21. Solomon Kalou<br />
		18. Romelu Lukaku<br />
		***MF***<br />
		6. Oriol Romeu<br />
		7. Ramires<br />
		8. Frank Lampard<br />
		5. Michael Essien<br />
		12. John Obi Mikel<br />
		15. Florent Malouda<br />
		16. Raul Meireles<br />
		***DF***<br />
		24. Gary Cahill<br />
		26. John Terry<br />
		2. Branislav Ivanovic<br />
		3. Ashley Cole<br />
		4. David Luiz<br />
		17. Jose Bosingwa<br />
		19. Paul Ferreira<br />
		27. Sam Hutchinson<br />
		34. Ryan Bertand<br />
		***GK***<br />
		1. Petr Cech<br />
		22. Ross Turnbul<br />
		40. Henrique Hilario<br />
		***Other***<br />
		0. Own Goal<br />
		</div>
		
		<div id = "box_left2">
		<h2>YOUR MOST RECENT PREDICTION!</h2>
		
		<?php
			$db_conn = mysql_connect("localhost", "root", "com214");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error());
						  
			if( !mysql_select_db("CFC_ScorePredictor", $db_conn) )
				die("Database doesn't exist: " . mysql_error());
			
			//Enter/update prediction for the current game, for this player
			if(isset($_GET["button"]) ){
				if( $_GET["button"] == "SAVE/UPDATE PREDICTION!") {
					$cmd = "DELETE FROM predictions WHERE username = '".$_SESSION['user']."'";
					mysql_query($cmd, $db_conn);
					$cmd = "INSERT INTO predictions (username, matchid, result, scoreline, scorers, points)
							  VALUES ('" . $_SESSION['user'] . "', '" . $_GET['matchid'] . "', '" . $_GET['result'] . "', '" . $_GET['scoreline'] . "', '" . $_GET['scorers'] ."','')";
					if (!mysql_query($cmd, $db_conn)) {
						$cmd = "UPDATE predictions SET result='" . $_GET['result'] . "', matchid='" . $_GET['matchid'] ."', scoreline='" . $_GET['scoreline'] ."', scorers='" . $_GET['scorers'] ."', points= '' WHERE username='".$_SESSION['user']."'";
						mysql_query($cmd, $db_conn);
					}
				}
				//Quit to main page
				if( $_GET["button"] == "LOG OUT!") {
					echo("Clicked");
					unset($_SESSION['user']);
					header("Location: index.php");
					exit;
				}
			}
			
			//Displaying plaler's most recent prediction
			$records = mysql_query("SELECT matchid,result,scoreline,scorers,points FROM predictions WHERE username = '".$_SESSION['user']."' ORDER BY matchid DESC");
			echo( "\t\t<table> <tr> <td>MATCH ID#</td> <td>RESULT</td> <td>SCORELINE</td> <td>CFC SCORERS</td> <td>POINTS</td></tr>" . PHP_EOL  );	
			
			while($row = mysql_fetch_array($records))
				echo( "\t\t\t<tr> <td>" . $row['matchid'] . "</td> <td>" . $row['result'] . "</td> <td>" . $row['scoreline'] . "</td> <td>" . $row['scorers'] . "</td> <td>" . $row['points'] ."</td></tr>" . PHP_EOL );				
			echo("\t\t</table>" . PHP_EOL . "\t</article>");
			
			echo("</div><div class = 'clear'></div></div>");
			
			//Displaying all fixtures table to the player
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

