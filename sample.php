<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My Sample Resultados-Futbol API</title>
	</head>
	<body>
		<!-- provided by resultados-futbol.com -->
		<?php
			//
			//  Sample by Leandro Hernandez on 29/06/2014.
			//  Copyright (c) 2014 Leandro Hernandez. All rights reserved.
			//
			
			// include de lib
			include("AXFootballResults/AXFootballResults.php");

			// Get your API_KEY in the "www.resultados-futbol.com" platform
			// you can get on http://www.resultados-futbol.com/api
			// format "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
			$apiKey = "ENTER-YOUR-API-KEY-HERE";
			
			// create instance
			$footballInstance = new AXFootballResults($apiKey);
			$data = $footballInstance->getWorldCup();
			
			echo "<div><h2>World Cup</h2></div>";
			
			foreach($data["matchs"] as $match){
				
				echo "<div>".$match["local"]."-".$match["visitor"]."</div>";
				
			}
			
			
		?>
	</body>
</html>