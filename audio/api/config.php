<?php
include "/var/www/html/system/common.php";

$dbserver = "laneworks-2.cjgvjastiugl.us-east-1.rds.amazonaws.com";
$dbname = "stack_network_kinlane_audioapi";
//$dbname = "apievangelist";
$dbuser = "kinlane";
$dbpassword = "ap1stack!";

// Make a database connection
mysql_connect($dbserver,$dbuser,$dbpassword) or die('Could not connect: ' . mysql_error());
mysql_select_db($dbname);

$datastore = "mysql"; // mysql or github JSON currently

$githuborg = "Kin-Lane";
$githubrepo = "audio";

$guser = "kinlane";
$gpass = "kpawwjN4dnJy4j";

$three_scale_provider_key = "9c72d79253c63772cc2a81d4e4bd07f8";

$awsAccessKey = "09VXKKVP882KS7F74D02";
$awsSecretKey = "uj+430Xa3uNVsdvXYbKvH5du7mNPLslb8jL74BPJ";
$awsSiteBucket = "kinlane-productions";
$awsRootURL = "http://kinlane-productions.s3.amazonaws.com/";

?>