<?php
$route = '/videos/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}

	if($query=='')
		{
		$Query = "SELECT * FROM videos WHERE name LIKE '%" . $query . "%' OR description LIKE '%" . $query . "%'";
		}
	else
		{
		$Query = "SELECT * FROM videos";
		}

	$Query .= " ORDER BY name ASC";
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

		$host = $_SERVER['HTTP_HOST'];
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

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
