<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$sromsg = mysqli_real_escape_string($con,$_POST["sromsg"]);

$query = 'SELECT * FROM associations WHERE `association_name` LIKE "%'.$sromsg.'%" or `introduction` LIKE "%'.$sromsg.'%"';
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
    $count = 0;
    $datas=Array();
    do {
        $count=$count+1;
        $datas[$count-1][0]=iconv('utf-8','gb2312',$row["avatar_url"]);
        $datas[$count-1][1]=$row["association_name"];
        $datas[$count-1][2]=$row["contact_name"];
        $datas[$count-1][3]=$row["id"];
        $datas[$count-1][4]=$row["introduction"];
     } while ($row = mysqli_fetch_array($res));
    $objsnd = array(
        'state'=> 200,
        'count'=> $count,
        'datas'=> $datas
    );
}
else{
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '无查询结果'
    );
}

mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>