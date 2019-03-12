<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$id = $_POST["id"];
$password = $_POST["password"];
$query = "SELECT * FROM users WHERE `id`=".$id." and password=".$password;
$res = mysqli_query($con,$query);
if ($row = mysqli_fetch_array($res)) {
	$query = "SELECT * FROM associations WHERE `id`=".$id;
    $res = mysqli_query($con,$query);
    $row = mysqli_fetch_array($res);
	$objsnd = array(
		'result'=> 0,
		'association_name'=> htmlspecialchars($row["association_name"]),
		'_id'=> $id
	);
}
else{$objsnd = array('result'=> 1);}
mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>