<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$activity_id = mysqli_real_escape_string($con,$_POST["activity_id"]);

$query = 'SELECT * FROM activities WHERE ';
$mark = 0;
if (!empty($activity_id)) {
    $query=$query.' `activity_id`='.$activity_id;
    $mark=1;
}
if (!$mark) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '未置入活动参数'
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
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
    $datas[0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
    $datas[1]=$row["title"];
    $datas[2]=$row["start_time"];
    $datas[3]=$row["end_time"];
    $datas[4]=$row["province"].$row["city"];
    $datas[5]=$row["address"];
    $datas[6]=$row["category"];
    $datas[7]=$row["money"];
    $datas[8]=$row["linkman"];
    $datas[9]=$row["click_quantity"];
    $datas[10]=$row["content"];
    $datas[11]=$row["lng"];
    $datas[12]=$row["lat"];
    $datas[13]=$row["file_url"];
    $datas[14]=$row["founderid"];
    $datas[15]=$row["tag"];
    $query = 'SELECT * FROM associations WHERE `id` = '.$row["founderid"];
    $ress = mysqli_query($con,$query);
    if (!$ress) {
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
    if($rows = mysqli_fetch_array($ress)){
        $datas[16]=iconv('utf-8','gb2312',$rows["avatar_url"]);
        $datas[17]=$rows["association_name"];
    }
    $objsnd = array(
        'state'=> 200,
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