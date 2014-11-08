<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<?php 
	$url = "http://jan.dyrda.org/html/udemy_coupons.html";
	$file = file_get_contents($url);

	//Replace all spaces so regex works
	$file = preg_replace('/\n/', ' ' , $file);
	
	//To hold all matches
	$matches = null;

	//Get all matches in an array
	preg_match_all('/<div class="prod_hold">(.*?)<\/div>/', $file, $matches);

	//Filter The Data	
	$final_matches = array();
	foreach ($matches[0] as $value) {
		$value .= '</div>';
		$check = preg_match('/<span class="new_price">\$ 0!<\/span>/', $value);
		if($check){
			array_push($final_matches, $value);
		}
	}


	foreach ($final_matches as $value) {
		echo $value;
	}
	

 ?>

<script type="text/javascript">
	$(document).ready(function() {
	
		$('img').each(function() {
			 var current = $(this).attr('src'),
			 	 new_src = 'http://jan.dyrda.org/html/'+current;

	 	 	$(this).attr('src', new_src);
		});	
	});
</script>