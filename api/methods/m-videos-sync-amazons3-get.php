<?php
$route = '/videos/sync/amazons3/';
$app->get($route, function ()  use ($app,$awsAccessKey,$awsSecretKey){

	$ReturnObject = array();

	if(isset($_REQUEST['bucket'])){ $bucket = $_REQUEST['bucket']; } else { $bucket = ''; }
	if(isset($_REQUEST['prefix'])){ $prefix = $_REQUEST['prefix']; } else { $prefix = ''; }

	//$bucket = "kinlane-productions";
	//$prefix = "bw-icons";

	$s3 = new S3($awsAccessKey, $awsSecretKey);
	$S3videos = $s3->getBucket($bucket,$prefix);
	//var_dump($S3videos);

	foreach($S3videos as $S3video)
		{

		$name = $S3video['name'];
		$videoUrl = "https://s3.amazonaws.com/kinlane-productions/" . $name;

		$name = str_replace($prefix,"",$name);
		$name = str_replace("/","",$name);
		$name = str_replace("-"," ",$name);
		$name = str_replace("_"," ",$name);

		$name = str_replace(".png","",$name);
		$name = str_replace(".gif","",$name);
		$name = str_replace(".jpg","",$name);
		$name = str_replace(".jpeg","",$name);
		$name = str_replace(".svg","",$name);

		$F = array();
		$F['name'] = $name;
		$F['videoUrl'] = $videoUrl;

		$videoQuery = "SELECT * FROM videos WHERE videoUrl = '" . $videoUrl . "'";
		//echo $videoQuery . "<br />";
		$videoResult = mysql_query($videoQuery) or die('Query failed: ' . mysql_error());

		if($videoResult && mysql_num_rows($videoResult))
			{

			$video = mysql_fetch_assoc($videoResult);
			$video_id = $video['video_id'];

			}
		else
			{

			$InsertQuery = "INSERT INTO videos(";

			if(isset($name)){ $InsertQuery .= "name"; }
			if(isset($videoUrl)){ $InsertQuery .= ",videoUrl"; }
			if(isset($creator)){ $InsertQuery .= ",creator"; }

			$InsertQuery .= ") VALUES(";

			if(isset($name)){ $InsertQuery .= "'" . mysql_real_escape_string($name) . "'"; }
			if(isset($videoUrl)){ $InsertQuery .= ",'" . mysql_real_escape_string($videoUrl) . "'"; }
			if(isset($creator)){ $InsertQuery .= ",'" . mysql_real_escape_string($creator) . "'"; }

			$InsertQuery .= ")";

			//echo $InsertQuery . "<br />";
			mysql_query($InsertQuery) or die('Query failed: ' . mysql_error());
			$video_id = mysql_insert_id();

			}

		}

		$ReturnObject['sync'] = "complete";

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
