<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$get_activity_id=$_GET["activity_id"];
$updquery = "UPDATE activities SET click_quantity = click_quantity + 1 WHERE activity_id = ".$get_activity_id;
if (!empty($get_activity_id) && !mysqli_query($con,$updquery)) {//点击量增加，若发来的数据为0则为单纯取数据，与运算可避免updquery被执行
	$objsnd = array(
		'result'=> 2,
		'errormsg'=> mysqli_error($con)
	);
	$json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
if (!empty($get_activity_id)) {
    $_SESSION["activity_id"]=$get_activity_id;
}
$activity_id=$_SESSION["activity_id"];
if (empty($activity_id)) {
	$objsnd = array(
		'result'=> 1
	);
}
else{
	$objsnd = array(
		'result'=> 0,
		'activity_id'=> $activity_id
	);
}
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>