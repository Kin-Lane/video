<?php
$route = '/videos/:video_id/';
$app->put($route, function ($video_id) use ($app){

  $host = $_SERVER['HTTP_HOST'];
	$video_id = prepareIdIn($video_id,$host);

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['name'])){ $name = $param['name']; } else { $name = ''; }
	if(isset($param['description'])){ $description = $param['description']; } else { $description = ''; }
	if(isset($param['videoUrl'])){ $videoUrl = $param['videoUrl']; } else { $videoUrl = ''; }
	if(isset($param['thumbnailUrl'])){ $thumbnailUrl = $param['thumbnailUrl']; } else { $thumbnailUrl = ''; }
	if(isset($param['width'])){ $width = $param['width']; } else { $width = ''; }
	if(isset($param['height'])){ $height = $param['height']; } else { $height = ''; }
	if(isset($param['creator'])){ $creator = $param['creator']; } else { $creator = ''; }

  $LinkQuery = "SELECT * FROM videos WHERE video_id = " . $video_id;
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$query = "UPDATE videos SET ";

		if(isset($name))
			{
			$query .= "name='" . mysql_real_escape_string($name) . "'";
			}
		if(isset($description))
			{
			$query .= ",description='" . mysql_real_escape_string($description) . "'";
			}
		if(isset($videoUrl))
			{
			$query .= ",videoUrl='" . mysql_real_escape_string($videoUrl) . "'";
			}
		if(isset($thumbnailUrl))
			{
			$query .= ",thumbnailUrl='" . mysql_real_escape_string($thumbnailUrl) . "'";
			}
		if(isset($width))
			{
			$query .= ",width='" . mysql_real_escape_string($width) . "'";
			}
		if(isset($height))
			{
			$query .= ",height='" . mysql_real_escape_string($height) . "'";
			}
		if(isset($creator))
			{
			$query .= ",creator='" . mysql_real_escape_string($creator) . "'";
			}

		$query .= " WHERE video_id = " . $video_id;

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());

    $video_id = prepareIdOut($video_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "videos Updated!";
		$ReturnObject['video_id'] = $video_id;

		}
	else
		{
		$Link = mysql_fetch_assoc($LinkResult);

    $video_id = prepareIdOut($video_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "videos Doesn't Exist!";
		$ReturnObject['video_id'] = $video_id;

		}

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
