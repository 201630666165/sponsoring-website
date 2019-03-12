<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$sremsg = mysqli_real_escape_string($con,$_POST["sremsg"]);

$query = 'SELECT * FROM activities WHERE `title` LIKE "%'.$sremsg.'%" or `tag` LIKE "%'.$sremsg.'%"';
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
        $datas[$count-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datas[$count-1][1]=$row["title"];
        $datas[$count-1][2]=$row["start_time"];
        $datas[$count-1][3]=$row["province"].$row["city"];
        $datas[$count-1][4]=$row["linkman"];
        $datas[$count-1][5]=$row["click_quantity"];
        $datas[$count-1][6]=$row["activity_id"];
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