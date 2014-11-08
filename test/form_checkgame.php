<form action="" method="POST">
	<input type="text" name="queryString">
	<input type="submit">
</form>





<?php 

if($_POST){
	$queryString = (isset($_POST['queryString']) ? trim($_POST['queryString'])  : "" ) ;
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

var_dump($result);

}
?>