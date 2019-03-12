<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$get_sremsg=$_GET["sremsg"];
$get_sromsg=$_GET["sromsg"];
if (!empty($get_sremsg)||!empty($get_sromsg)) {
    $_SESSION["sremsg"]=$get_sremsg;
    $_SESSION["sromsg"]=$get_sromsg;
}
$sremsg=$_SESSION["sremsg"];
$sromsg=$_SESSION["sromsg"];
if (empty($sremsg)&&empty($sromsg)) {
	$objsnd = array('result'=> 1);
}
else{
	$objsnd = array(
		'result'=> 0,
		'sremsg'=> $sremsg,
		'sromsg'=> $sromsg
	);
}
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>