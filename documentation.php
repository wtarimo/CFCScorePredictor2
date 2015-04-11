
<!DOCTYPE html>
<html lang="en">

<head>
<title>CFC Fan Score Predictor</title>
<meta charset="utf-8">
<link rel="stylesheet" href="cfc_score_predictor.css">
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">


</head>

<body>
	<div id="wrapper">

		<header id="top_header"> Documentation: CFC FAN SCORE-PREDICTOR </header>
		
		<div id="doc">
		
			CFC Fan Score Predictor - a web based online game, is a venue for Chelsea FC fans on campus to predict results for Chelsea FC games and win monthly and seasonal prizes.
			On each Chelsea match, participating fans can predict the game result (win, loss or tie), the score line, and CFC goal scorers.
			Fans will be ranked according to cumulative prediction points.
			A manager or admin will always post matches and their results together with  letting the system calculate points for each prediction on the game results.
			Fans will not have to predict goal scorers from the opposite teams; we can treat these teams anonymously. 
			Rules for giving prediction points are given in the HowToPlay page.

			<h2>General Rules:</h2>
			1.Predictions can be made for all upcoming Chelsea FC games in the Barclays Premier League, UEFA Champions League, FA Cup and Carling Cup in the season.</br>
			2.Prediction stops 5 minutes before game kick-off. </br>
			3.Predictions are for the normal 90 minutes soccer game, scores from extra time are not included. </br>
			4.Points: Correct result - 1pt, Exact score line - 5pts, Each correct goal scorer - 1pt </br>
			
			<h2>Design Ideas:</h2>
			1.Client Side Interactions: Users can create and login to their accounts in order to submit predictions</br>
			2.Server side processing: The server maintains databases with tables for users (account credentials and accumulative points), predictions (user predictions for each next game) and fixtures (list of all games with/out results as added by the manager/admin</br>
			
			<h2>Navigation of Site: Pages & Content</h2>
			1.Main Page: Game description, preview of game standings, options for fan to login or register</br>
			2.Prediction page where users submit or change predictions for the next game</br>
			3.HowToPlay page with how-to-play instructions</br>
			4.Documentation page with information on the site content, and design. This page.</br>
			
			<h2>Technologies Used: </h2>
			Main Page: CSS, Javascript, XMLHttpRequest, Image, Image processing, Canvas, PHP, MYSQL</br>
			Login/Registration Page: CSS, forms, PHP, MYSQL</br>
			Admin/Manager Page: CSS, forms, local/session storage, local file read & write</br>
			Prediction Page: CSS, forms, PHP, MYSQL</br>
			Documentation Page: CSS</br>
			HowToPlay Page: CSS</br>
			
			<div id="buttons"><form method="link" action="index.php"><input type="submit" value="EXIT!" style="float:left;"></form></div>

		</div>
		  
		<footer id="bottom_footer"> 
		William Tarimo - COM214 - Web Technologies & Mobile Computing - Final Project - Spring 2012
		</footer>
	</div>

</body>
</html>

