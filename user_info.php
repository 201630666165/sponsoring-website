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
$query = 'SELECT * FROM associations WHERE id = '.$id;
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
    $datas=Array();
    $datas[0]=iconv('utf-8','gb2312',$row["avatar_url"]);
    $datas[1]=$row["id"];
    $datas[2]=$row["association_name"];
    $datas[3]=$row["e-mail"];
    $datas[4]=$row["contact_name"];
    $datas[5]=$row["introduction"];
    $objsnd = array(
        'state'=> 200,
        'datas'=> $datas
    );
}
else{
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '未知错误',
        'errorquery'=> $query
    );
}


mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>