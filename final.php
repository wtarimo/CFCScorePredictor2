
<!DOCTYPE html>
<html lang="en">

<head>
<title>Home: CFC Fan Score Predictor</title>
<meta charset="utf-8">
<link rel="stylesheet" href="cfc_score_predictor.css">
<script src="rgb-hsv_converter.js"></script>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">


</head>

<body>
	<div id="wrapper">

		<header id="top_header"> CFC FAN SCORE-PREDICTOR </header>
		
		<div>
		<div id="welcome" >
		<h2>Chelsea FC fan? Predict Scores & Win Prizes!</h2>
		<p><b>CFC Fan Score Predictor </b>- a web based online game, is a venue for Chelsea FC fans on campus to predict results for Chelsea FC games and win monthly and seasonal prizes. 
		On each Chelsea FC match, participating fans can predict the game result (win, loss or tie), the score line, and Chelsea FC goal scorers. 
		Fans will be ranked according to cumulative prediction points and accuracy. <br></p>
		<p>All the Best!!!</p>
		<p><b>William Tarimo & The COM214 Team.</p>
		
		<form method="link" action="login.php"><input type="submit" value="LOG IN!" style="float:left;"></form>
		<form method="link" action="login.php"><input type="submit" value="REGISTER TO PLAY!" style="float:right;"></form>
		
		
		</div>
		<div id="prize" >
		<h2>Prize for May!</h2>
		<img src="boots.jpg">
		Signed Boots: Frank Lampard!
		<p></p>
		</div>
		
		<div id="how" >
		<form method="link" action="manage_fixtures.php"><input type="submit" value="Admin Mode!" style="float:left;"></form> 
		<form method="link" action="documentation.php"><input type="submit" value="Documentation!" style="float:left;"></form></br>
		<p><h2>HOW TO PLAY</h2>
		1. Register or Login to an existing account!</br>
		2. Predictions can be made for all upcoming Chelsea FC games in the Barclays Premier League, UEFA Champions League, FA Cup and Carling Cup in the season.<br>
		3. Prediction stops 5 minutes before game kick-off.<br>
		4. Predictions are for the normal 90 minutes soccer game, scores from extra time are not included.<br>
		5. Points: Correct result - 1pt, Exact score line - 5pts, Each correct goal scorer - 1pt.<br>
		6. Bonus Accuracy points: 100% accuracy - 3pts, 75-99% accuracy - 2pts, 50-74% accuracy - 1pt.<br>
	
		<form method="link" action="howto.php"><input type="submit" value="READ MORE!" style="float:left;"></form>
		</div>
		
		<div class = "clear"></div>
		</div>
		
		<div>
		<div id="standings" >
		<h1>SEASON STANDINGS!</h1>
		<?php
		session_start();
		
		//Accessing database of users for displaying season standings
		$db_conn = mysql_connect("localhost", "root", "com214");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
					  
		if( !mysql_select_db("CFC_ScorePredictor", $db_conn) )
			die("Database doesn't exist: " . mysql_error());
		
		$records = mysql_query("SELECT firstName,lastName,totalpoints FROM users ORDER BY totalpoints DESC LIMIT 10");
		echo( "\t\t<table> <tr> <td>firstName</td> <td>lastName</td> <td>totalPoints</td></tr>" . PHP_EOL  );	
		
		while($row = mysql_fetch_array($records))
			echo( "\t\t\t<tr> <td>" . $row['firstName'] . "</td> <td>" . $row['lastName'] . "</td> <td>" . $row['totalpoints']. "</td></tr>" . PHP_EOL );				
		echo("\t\t</table>" . PHP_EOL . "\t</article>");
															
		mysql_close($db_conn);
		
		?>
		</div>
		<div id="game">
		<h2>Explore CFC Colors: Select Image, Choose Color then click Display Image</h2>
			<canvas id="rightCanvas" width="450" height="200" style="border:3px solid #330000; margin-left:35px;-moz-border-radius: 16px;-webkit-border-radius: 16px;border-radius: 16px;">
			Your browser does not support the canvas element.
			</canvas>
			  
			<section id="main_section">
					<div>
						
						<div id = "main1" style="float:left">
						<section id = "hsv_slider" width = "150" height = "60" float = "left">
						<input type="range" id="slider" style="width: 150px;" min="0" max="1" value="0.7" step=".02" onchange='updateSliderValue(this.value)' /> 
							<canvas id="myCanvas" width="150" height="20" style="border:1px solid #BBBBBB;">
								Your browser does not support the canvas element.
							</canvas> 
						</section>
						</div>
						<div id = "main3" style="float:right;">
							<form>
							Select Image
								<select id="mySelect">
								</select>
							</form>			
						</div>
						<div id = "main2" style="float:left">
							<button type="button" id="buttons" onClick="displayImage()"> Display Image</button> 
						</div>
				</section>
			  </div>
		
		</div>
		
		<div class = "clear"></div>
		</div>
		  
		<footer id="bottom_footer"> 
		William Tarimo - COM214 - Web Technologies & Mobile Computing - Final Project - Spring 2012
		</footer>
	</div>

<script type="text/javascript">
//Javascript for the image game

var sliderValue = 0.5;
window.onload = displaySpectrum();
window.onload = fillDropDown();

//Method to populate the dropdown menu with image names in data.txt
function fillDropDown() {
	var ddl = document.getElementById("mySelect");
	var option=document.createElement("option");
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("GET", "data.txt",true);
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			option.text=xmlhttp.responseText;
			var names = option.text;
			names = names.split(" ");
			for (var i=0; i<names.length; i++) {
				var menuitem = document.createElement("option");
				menuitem.text = names[i];
				ddl.add(menuitem,null);
			}
		}
	}
	xmlhttp.send(null);
}

//Updates the sliderValue variable whenever the slider is moved
function updateSliderValue(newValue){
	sliderValue = newValue;
}

//Converts RGB color values to HEX
function rgbToHex(r,g,b) {
    var red = parseInt(r);
    var green = parseInt(g);
    var blue = parseInt(b);
    var rgb = blue | (green << 8) | (red << 16);
    var result = rgb.toString(16);
	if (red == 0) { result = "00"+result; }
	else if (red >= 1 && red <=15) {result = "0"+result;}
	return ("#" + result).toUpperCase();
}

//Runs whenever the Display Image button is clicked. 
//Displays on the left canvas, processes the image and displays it on right canvas
function displayImage() {
	//Gets the current selected image name
	var items =document.getElementById("mySelect");
	var img = items.options[items.selectedIndex].text;
	
	var image = new Image();
	var factor;
	
	//Right canvas
	var canv2=document.getElementById("rightCanvas");
	var c2=canv2.getContext("2d");
	var image2 = new Image();
	
	//Getting left and right slider boundery values
	var left = (sliderValue*1) - (0.15*1.00);
	var right = (sliderValue*1) + (0.15*1.00);
	if (left < 0) { left = 0; }
	if (right > 1) { right = 1; }
	
	image.onload = function() {
		factor = 450/this.width;		
		//Right image processing
		canv2.height = image.height * factor;
		canv2.width = image.width * factor;
		
		
		c2.drawImage(image2,0,0,canv2.width,canv2.height);
		var imageData = c2.getImageData(0,0,canv2.width,canv2.height);
		var im2 = imageData.data;
		
		//Goes through all pixes, blacking out pixes with HSV out of slider range
		for (var i = 0; n = im2.length, i < n; i += 4) {
			pixelHSV = rgbToHsv(im2[i],im2[i+1],im2[i+2]);
			if (pixelHSV[0] < left || pixelHSV[0] > right) {
				im2[i] = 0;		// red channel
				im2[i+1] = 0;  	// blue channel
				im2[i+2] = 0;	// green channel
				im2[i+3] = 255; // alpha channel
			}
		}
		c2.putImageData(imageData,0,0);

	}
	image.src = img;
	image2.src = img;
}

//Displays the slider spectrum in a canvas
function displaySpectrum() {
	var canv=document.getElementById("myCanvas");
	var c=canv.getContext("2d");     
	var w = 150;
	var h = 20;
	var imgd = c.createImageData(w, h);
	var pix = imgd.data;
	var i=0;
	for(var y = 0; y < h; y++) {
		for (var x = 0; x < w; x++, i+=4){
			rgbCol = hsvToRgb(x/w, 1, 1);
			pix[i  ] = rgbCol[0]; 	// red channel
			pix[i+1] = rgbCol[1];  	// blue channel
			pix[i+2] = rgbCol[2];  	// green channel
			pix[i+3] = 255; 		// alpha channel
		}
	}
	c.putImageData(imgd, 0, 0);
}
</script>

</body>
</html>

