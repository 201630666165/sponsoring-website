<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$get_userid=$_GET["userid"];
if (!empty($get_userid)) {
    $_SESSION["userid"]=$get_userid;
}
$userid=$_SESSION["userid"];
if (empty($userid)) {
	$objsnd = array('result'=> 1);
}
else{
	$objsnd = array(
		'result'=> 0,
		'userid'=> $userid
	);
}
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>