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
if (empty($id)||empty($activity_id)) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '请先登录'
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
$query = 'SELECT * FROM favorite WHERE activity_id = '.$activity_id;
$res = mysqli_query($con,$query);
$count = 0;
if (!$res) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> mysqli_error($con),
        'errorquery'=>$query
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
if($row = mysqli_fetch_array($res)){
    do{
        $count++;
    }
    while ($row = mysqli_fetch_array($res));
}

$query = 'SELECT * FROM favorite WHERE id = '.$id.' and activity_id = '.$activity_id;
$res = mysqli_query($con,$query);
if (!$res) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> mysqli_error($con),
        'errorquery'=>$query
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
if($row = mysqli_fetch_array($res)){
    $objsnd = array(
        'state'=> 200,
        'codes'=>'true',
        'result'=> $count
    );
}
else{
    $objsnd = array(
        'state'=> 200,
        'codes'=>'false',
        'result'=>0
    );
}

mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>