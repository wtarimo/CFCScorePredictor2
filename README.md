# CFCScorePredictor2
A PHP web based game for soccer scores prediction for Chelsea FC!

CFC Fan Score Predictor - a web based online game, is a venue for Chelsea FC fans on campus to predict results for Chelsea FC games and win monthly and seasonal prizes. On each Chelsea match, participating fans can predict the game result (win, loss or tie), the score line, and CFC goal scorers. Fans will be ranked according to cumulative prediction points. A manager or admin will always post matches and their results together with letting the system calculate points for each prediction on the game results. Fans will not have to predict goal scorers from the opposite teams; we can treat these teams anonymously. Rules for giving prediction points are given in the HowToPlay page.

# General Rules:
1.Predictions can be made for all upcoming Chelsea FC games in the Barclays Premier League, UEFA Champions League, FA Cup and Carling Cup in the season.
2.Prediction stops 5 minutes before game kick-off. 
3.Predictions are for the normal 90 minutes soccer game, scores from extra time are not included. 
4.Points: Correct result - 1pt, Exact score line - 5pts, Each correct goal scorer - 1pt 

# Design Ideas:
1.Client Side Interactions: Users can create and login to their accounts in order to submit predictions
2.Server side processing: The server maintains databases with tables for users (account credentials and accumulative points), predictions (user predictions for each next game) and fixtures (list of all games with/out results as added by the manager/admin

# Navigation of Site: Pages & Content
1.Main Page: Game description, preview of game standings, options for fan to login or register
2.Prediction page where users submit or change predictions for the next game
3.HowToPlay page with how-to-play instructions
4.Documentation page with information on the site content, and design. This page.

# Technologies Used:
Main Page: CSS, Javascript, XMLHttpRequest, Image, Image processing, Canvas, PHP, MYSQL
Login/Registration Page: CSS, forms, PHP, MYSQL
Admin/Manager Page: CSS, forms, local/session storage, local file read & write
Prediction Page: CSS, forms, PHP, MYSQL
Documentation Page: CSS
HowToPlay Page: CSS
