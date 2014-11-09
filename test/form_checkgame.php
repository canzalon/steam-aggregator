<?php 
$queryString = (isset($_POST['queryString']) ? trim($_POST['queryString'])  : "" ) ; 

function get_hours_story($file){
	

	$before;
	preg_match_all('/Main Story(.*?)Hours/', $file, $before);	
	
	if(sizeof($before[0]) < 1) 
		return "0 Hours";

	$html = $before[0][0];

	$html = str_replace("&#189;", "", $html);

	$after;
	preg_match_all('/([0-9]*)(.) Hours/', $html, $after);
	return (int) $after[0][0];
}

function doSomeCoolStuff($games){
	$games_with_times;
	foreach ($games as $key => $game) {
		$postdata = http_build_query(
	    	array(
	        	'queryString' => $game['name']
	    	)
		);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);

		$result = file_get_contents('http://www.howlongtobeat.com/search_main.php?t=games', false, $context);

		if (strpos($result,'No results') === false) {
		
	 		$games['story_hours'] = get_hours_story($result);
			
	    
		}else{
			//do nothing
		}

	}
}


function get_hours_story($file){
	

	$before;
	preg_match_all('/Main Story(.*?)Hours/', $file, $before);	
	
	if(sizeof($before[0]) < 1) 
		return "0 Hours";

	$html = $before[0][0];

	$html = str_replace("&#189;", "", $html);

	$after;
	preg_match_all('/([0-9]*)(.) Hours/', $html, $after);
	return $after[0][0];
}


if($_POST){
	
	$postdata = http_build_query(
	    array(
	        'queryString' => $queryString
	    )
	);

	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);

	$context  = stream_context_create($opts);

	$result = file_get_contents('http://www.howlongtobeat.com/search_main.php?t=games', false, $context);



//Get all matches in an array
//preg_match_all('/<div class="prod_hold">(.*?)<\/div>/', $file, $matches);

//echo $result;
	if (strpos($result,'No results') === false) {
		
		$data['story_hours'] = get_hours_story($result);
	 	
		echo json_encode($data);
	    
	}else{
		echo '{"error" : "No Results"}';
	}


}else{
	echo '{"Error" : "No Post Data Sent"}';
}
?>