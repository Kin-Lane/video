<?php
$route = '/videos/:video_id/';
$app->get($route, function ($video_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$video_id = prepareIdIn($video_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM videos WHERE video_id = " . $video_id;
	//echo $Query . "<br />";

	$videosResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($videos = mysql_fetch_assoc($videosResult))
		{

		$video_id = $videos['video_id'];
		$name = $videos['name'];
		$description = $videos['description'];
		$videoUrl = $videos['videoUrl'];
		$thumbnailUrl = $videos['thumbnailUrl'];
		$width = $videos['width'];
		$height = $videos['height'];
		$creator = $videos['creator'];

		// manipulation zone

		$video_id = prepareIdOut($video_id,$host);

		$F = array();
		$F['video_id'] = $video_id;
		$F['name'] = $name;
		$F['description'] = $description;
		$F['videoUrl'] = $videoUrl;
		$F['thumbnailUrl'] = $thumbnailUrl;
		$F['width'] = $width;
		$F['height'] = $height;
		$F['creator'] = $creator;

		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
 ?>
