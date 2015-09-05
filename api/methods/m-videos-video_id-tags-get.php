<?php
$route = '/videos/:video_id/tags/';
$app->get($route, function ($video_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$video_id = prepareIdIn($video_id,$host);

	$ReturnObject = array();

	$Query = "SELECT t.tag_id, t.tag, count(*) AS Profile_Count from tags t";
	$Query .= " JOIN video_tag_pivot ptp ON t.tag_id = ptp.tag_id";
	$Query .= " WHERE ptp.video_id = " . $video_id;
	$Query .= " GROUP BY t.tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$videos_count = $Database['Profile_Count'];

		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['videos_count'] = $videos_count;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
 ?>
