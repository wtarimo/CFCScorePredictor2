
<!DOCTYPE html>
<html lang="en">

<head>
<title>Accounts: CFC Fan Score Predictor</title>
<meta charset="utf-8">
<link rel="stylesheet" href="cfc_score_predictor.css">
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">

</head>

<body>
	<div id="wrapper">

		<header id="top_header"> CFC FAN SCORE-PREDICTOR </header>
		
		<div><div id="box" >
		<h2>LOG IN!</h2>
		
		<form id = "add_fixture" action="login.php" method="post">
            UserName: <input type="text" name="username" placeholder="UserName" required> <br />
			PassWord: <input type="password" name="password" placeholder="PassWord" required> <br />
       
            <input type="submit" name="button" value="LogIn"  />
          
        </form>
		
		</div><div id="box" >
		<h2>REGISTER!</h2>
		
		<form id = "add_fixture" action="login.php" method="post">
			First Name*: <input type="text" name="firstName" placeholder="First Name" required> <br />
			Last Name *: <input type="text" name="lastName" placeholder="Last Name" required> <br />
			
            UserName *: <input type="text" name="username" placeholder="UserName" required> <br />
			PassWord *: <input type="password" name="password1" placeholder="PassWord" required> <br />
			Comfirm PassWord *: <input type="password" name="password2" placeholder="PassWord" required> <br />
       
            <input type="submit" name="button" value="Register"  />
          
        </form>
		</div><div class = "clear"></div></div>
		
		
		<?php
			session_start();
			$db_conn = mysql_connect("localhost", "root", "com214");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error());
						  
			if( !mysql_select_db("CFC_ScorePredictor", $db_conn) )
				die("Database doesn't exist: " . mysql_error());
				
			if(isset($_POST["button"]) ){
				if( $_POST["button"] == "LogIn" ) {
					//Login: Authenticate username and password from users table
					$query = "SELECT * FROM users WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."'" ;
					$result = mysql_query($query) or die(mysql_error());
					if (!mysql_num_rows($result))
						echo("Your credentials could not be authenticated! Please Try Again!");
					else {
						//If authentic user, then proceed to prediction page, saving user into session-user
						$_SESSION["user"] = $_POST['username'];
						echo("Welcome".$_SESSION['user']);
						header("Location: predict.php");
						exit;
					}
				}

				if( $_POST["button"] == "Register" ) {
					
					$query = "SELECT * FROM users WHERE username = '".$_POST['username']."'" ;
					$result = mysql_query($query) or die(mysql_error());
					//Check if username is already taken
					if (mysql_num_rows($result)) {
						echo("Username ".$_POST['username']." is already taken, try another one!");
					}
					//Make sure the two passwords match
					if($_POST['password1'] == $_POST['password2']) {
						$cmd = "INSERT INTO users (username, password, firstName, lastName, totalpoints)
							  VALUES ('" . $_POST['username'] . "', '" . $_POST['password1'] . "', '" . $_POST['firstName'] . "', '" . $_POST['lastName'] . "',0)";
							  
						//If info is correct, register new user and proceed to prediction, saving user as session-user, no need to login again
						mysql_query($cmd, $db_conn);
						$_SESSION['user'] = $_POST['username'];
						header("Location: predict.php");
						exit;
					}
					else {
						echo("Your passwords didn't match!");
					}
				}
			}
		?>
		
		  
		<footer id="bottom_footer"> 
		William Tarimo - COM214 - Web Technologies & Mobile Computing - Final Project - Spring 2012
		</footer>
	</div>

</body>
</html>

