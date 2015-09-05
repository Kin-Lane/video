<?php
$route = '/videos/:video_id/tags/';
$app->post($route, function ($video_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$video_id = prepareIdIn($video_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['tag']))
		{
		$tag = trim(mysql_real_escape_string($param['tag']));

		$ChecktagQuery = "SELECT tag_id FROM tags where tag = '" . $tag . "'";
		$ChecktagResults = mysql_query($ChecktagQuery) or die('Query failed: ' . mysql_error());
		if($ChecktagResults && mysql_num_rows($ChecktagResults))
			{
			$tag = mysql_fetch_assoc($ChecktagResults);
			$tag_id = $tag['tag_id'];
			}
		else
			{

			$query = "INSERT INTO tags(tag) VALUES('" . $tag . "'); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());
			$tag_id = mysql_insert_id();
			}

		$ChecktagPivotQuery = "SELECT * FROM video_tag_pivot where tag_id = " . trim($tag_id) . " AND video_id = " . $video_id;
		$ChecktagPivotResult = mysql_query($ChecktagPivotQuery) or die('Query failed: ' . mysql_error());

		if($ChecktagPivotResult && mysql_num_rows($ChecktagPivotResult))
			{
			$ChecktagPivot = mysql_fetch_assoc($ChecktagPivotResult);
			}
		else
			{
			$query = "INSERT INTO video_tag_pivot(tag_id,video_id) VALUES(" . $tag_id . "," . $video_id . "); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());
			}

		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['videos_count'] = 0;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
 ?>
