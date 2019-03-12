<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$id = mysqli_real_escape_string($con,$_POST["id"]);
$activity_id = mysqli_real_escape_string($con,$_POST["activity_id"]);
$query = "SELECT * FROM favorite WHERE `id`=".$id." and `activity_id`=".$activity_id;
$res = mysqli_query($con,$query);
if ($row = mysqli_fetch_array($res)) {
	$objsnd = array(
        'state'=> 204,
        'errormsg'=> '已收藏'
    );
}
else{
    	$insquery = "INSERT INTO favorite VALUES($id,$activity_id)";
	    if(mysqli_query($con,$insquery))
	    {
	    	$objsnd = array('state'=> 200);
	    }
	    else{
	    	$objsnd = array(
                'state'=> 204,
                'errormsg'=> mysqli_error($con)
            );
        }
}
mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>