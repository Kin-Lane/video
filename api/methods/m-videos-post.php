<?php
$route = '/videos/';
$app->post($route, function () use ($app){

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['name'])){ $name = $param['name']; } else { $name = 'No Name'; }
	if(isset($param['description'])){ $description = $param['description']; } else { $description = ''; }
	if(isset($param['videoUrl'])){ $videoUrl = $param['videoUrl']; } else { $videoUrl = ''; }
	if(isset($param['thumbnailUrl'])){ $thumbnailUrl = $param['thumbnailUrl']; } else { $thumbnailUrl = ''; }
	if(isset($param['width'])){ $width = $param['width']; } else { $width = ''; }
	if(isset($param['height'])){ $height = $param['height']; } else { $height = ''; }
	if(isset($param['creator'])){ $creator = $param['creator']; } else { $creator = ''; }

  	$LinkQuery = "SELECT * FROM videos WHERE videoUrl = '" . $videoUrl . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$Link = mysql_fetch_assoc($LinkResult);

		$video_id = $Link['video_id'];

    $host = $_SERVER['HTTP_HOST'];
  	$video_id = prepareIdOut($video_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "videos Already Exists!";
		$ReturnObject['video_id'] = $video_id;

		}
	else
		{

		$query = "INSERT INTO videos(";

		if(isset($name)){ $query .= "name,"; }
		if(isset($description)){ $query .= "description,"; }
		if(isset($videoUrl)){ $query .= "videoUrl,"; }
		if(isset($thumbnailUrl)){ $query .= "thumbnailUrl,"; }
		if(isset($width)){ $query .= "width,"; }
		if(isset($height)){ $query .= "height,"; }
		if(isset($creator)){ $query .= "creator"; }

		$query .= ") VALUES(";

		if(isset($name)){ $query .= "'" . mysql_real_escape_string($name) . "',"; }
		if(isset($description)){ $query .= "'" . mysql_real_escape_string($description) . "',"; }
		if(isset($videoUrl)){ $query .= "'" . mysql_real_escape_string($videoUrl) . "',"; }
		if(isset($thumbnailUrl)){ $query .= "'" . mysql_real_escape_string($thumbnailUrl) . "',"; }
		if(isset($width)){ $query .= "'" . mysql_real_escape_string($width) . "',"; }
		if(isset($height)){ $query .= "'" . mysql_real_escape_string($height) . "',"; }
		if(isset($creator)){ $query .= "'" . mysql_real_escape_string($creator) . "'"; }

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$video_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
  	$video_id = prepareIdOut($video_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "video Added";
		$ReturnObject['video_id'] = $video_id;

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
