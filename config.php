<?php

error_reporting(E_ALL);
set_time_limit(300);
ini_set('display_errors', TRUE);

//Set API Key
$apikey = "2CE823C252056B1D942D71E1F335DC60"; 

//Grab ID from index.php
if(isset($_POST["steamid"])) {
	$steamid = $_POST["steamid"];
	$steam64 = $steamid;

	//if not Steam64-bit code
	if(!preg_match('/^\d+$/', $steamid)){
		if(@file_get_contents("http://steamcommunity.com/id/".$steamid."?xml=1") == FALSE){
			echo "ERROR 1"; 
			exit;
		}
		else {
			$xml = new SimpleXMLElement(file_get_contents("http://steamcommunity.com/id/".$steamid."?xml=1"));
			$steam64 = $xml->steamID64;
			if(!$steam64){
				echo "ERROR 2";
				exit;
			}
		}
	}
}
else {
	echo "ERROR 2.5: STEAMID INVALID";
}

//Grabbing User Content
$userinfo = @file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $apikey . "&steamids=" . $steam64); 

if($userinfo !== false){
	$userJSON = json_decode($userinfo, true);

	//intialize array
	$userArray = $userJSON['response']['players'][0];

	//Check if user profile set to private
	if($userArray['communityvisibilitystate'] == 1){
		echo "ERROR: User set to Private";
	}
}
else {
	echo "ERROR 3: USERINFO INVALID";
}

//Grabbing Gamelist Content
$gameinfo = @file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".$apikey."&steamid=".$steam64."&format=json&include_appinfo=1&include_played_free_games=1");
if($gameinfo !== false){
	$gameJSON = json_decode($gameinfo, true);

	//initialize array
	$gameArray = $gameJSON['response']['games'];
}
else {
	echo "ERROR 4: GAMEINFO INVALID";
}

?>


