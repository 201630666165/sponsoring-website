<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
$get_association_name=$_GET["association_name"];
$get_id=$_GET["id"];
if (empty($_SESSION["association_name"])||empty($_SESSION["id"])) {
    $_SESSION["association_name"]=$get_association_name;
    $_SESSION["id"]=$get_id;
}
$association_name=$_SESSION["association_name"];
$id=$_SESSION["id"];
if (empty($association_name)||empty($id)) {
	$objsnd = array('result'=> 1);
}
else{
	$objsnd = array(
		'result'=> 0,
		'association_name'=> $association_name,
		'_id'=> $id
	);
}
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>