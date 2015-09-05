<?php
$route = '/videos/:video_id/';
$app->delete($route, function ($video_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$video_id = prepareIdIn($video_id,$host);

	$ReturnObject = array();

	$query = "DELETE FROM videos WHERE video_id = " . $video_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());

	$video_id = prepareIdOut($video_id,$host);

	$ReturnObject = array();
	$ReturnObject['message'] = "video Deleted!";
	$ReturnObject['video_id'] = $video_id;

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_enode($ReturnObject)));

	});
 ?>
