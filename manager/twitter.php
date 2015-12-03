<?php

/***********************************************************************************************
888888888888  I8,        8        ,8I  88  888888888888  888888888888  88888888888  88888888ba   
     88       `8b       d8b       d8'  88       88            88       88           88      "8b  
     88        "8,     ,8"8,     ,8"   88       88            88       88           88      ,8P  
     88         Y8     8P Y8     8P    88       88            88       88aaaaa      88aaaaaa8P'  
     88         `8b   d8' `8b   d8'    88       88            88       88"""""      88""""88'    
     88          `8a a8'   `8a a8'     88       88            88       88           88    `8b    
     88           `8a8'     `8a8'      88       88            88       88           88     `8b   
     88            `8'       `8'       88       88            88       88888888888  88      `8b  
*************************************************************************************************/

require "src/APITwitter/vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
/*
*
*/
function twitter_switch_lvl_1($request, $answer) {

	//Inclusion de l'API Twitter

	
	if (isset($request->level_1)) {

		switch ($request->level_1) {
			case 'test':
				//Tous ces acces sont disponibles pour le compte d'Aurélien sur le site développeur de twitter
				$consumer         = '8PprtKUsck60J9RVDL0WJbWV2' ;
				$cosumerSecret    = 'B31rkJslyXQElasB1y5dZ2TgyMeqKmkeRw9Dg2xGJv49QfzJfh' ;
				$accesToken       = '4364654237-rqu1tnN3FRYPgQPQJ5fJU7jBMuLcYqyCpMYds4z' ;
				$accesTokenSecret = 'jaV2HPFBp4D51QXQwnpSGW9CipPwgAsF8mBDzfwhcRv8R' ;
				//On instacie la connexion à Twitter
				$twitter = new TwitterOAuth($consumer, $cosumerSecret, $accesToken, $accesTokenSecret);

				$answer->tweets = $twitter->get("https://api.twitter.com/1.1/search/tweets.json?q=%23freebandnames&since_id=24012619984051000&max_id=250126199840518145&result_type=mixed&count=4");
				
				break;
			
			default:
				$answer->request = 'error level_1';
				break;
		}
	}
}

?>