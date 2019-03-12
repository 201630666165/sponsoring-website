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
$association_name = mysqli_real_escape_string($con,$_POST["association_name"]);
$e_mail = mysqli_real_escape_string($con,$_POST["e_mail"]);
$contact_name = mysqli_real_escape_string($con,$_POST["contact_name"]);
$password = mysqli_real_escape_string($con,$_POST["password"]);
$query = "SELECT * FROM users WHERE `id`=".$id;
$res = mysqli_query($con,$query);
if ($row = mysqli_fetch_array($res)) {
	$objsnd = array('result'=> 1);
}
else{
	$isquery = "INSERT INTO users VALUES($id,$password)";
    if (mysqli_query($con,$isquery)) {
    	$insquery = 'INSERT INTO associations VALUES('.$id.',"'.$association_name.'","'.$e_mail.'","'.$contact_name.'",NULL,NULL)';
	    if(mysqli_query($con,$insquery))
	    {
	    	$objsnd = array('result'=> 0);
	    }
	    else{
	    	$query = 'SELECT * FROM associations WHERE `association_name`="'.$association_name.'"';
            if ($row = mysqli_fetch_array(mysqli_query($con,$query))){
                $objsnd = array(
	    		    'result'=> 3
	    	    );
            }
            else{
            	$objsnd = array(
	    		    'result'=> 2,
	    		    'errormsg'=> mysqli_error($con)
	    	    );
            }
	    	mysqli_query($con,"DELETE FROM users WHERE `id`=$id");
        }
    }
    else{
    	$objsnd = array(
    		'result'=> 2,
	    	'errormsg'=> mysqli_error($con)
    	);
    }
}
mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>