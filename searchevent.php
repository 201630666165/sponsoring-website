<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$mod1 = mysqli_real_escape_string($con,$_POST["mod1"]);
$mod2 = mysqli_real_escape_string($con,$_POST["mod2"]);
$mod3 = mysqli_real_escape_string($con,$_POST["mod3"]);
$mod4 = mysqli_real_escape_string($con,$_POST["mod4"]);

$query = 'SELECT * FROM activities WHERE ';
$mark = 0;
if (!empty($mod1)) {
    $query=$query.' `category`='.$mod1;
    $mark=1;
}
if (!empty($mod2)) {
    if ($mark) {
        $query=$query.' and `money`='.$mod2;
    }
    else{$query=$query.' `money`='.$mod2;}
    $mark=1;
}
if (!empty($mod3)) {
    if ($mark) {
        $query=$query.' and `province`="'.$mod3.'"';
    }
    else{$query=$query.' `province`="'.$mod3.'"';}
    $mark=1;
}
if (!empty($mod4)) {
    if ($mark) {
        $query=$query.' and ';
    }
    switch ($mod4) {
        case "1":
            $query=$query.' DATEDIFF(`start_time`,CURDATE())=0';
            break;
        case "2":
            $query=$query.' DATEDIFF(`start_time`,CURDATE())=1';
            break;
        case "3":
            $query=$query.' DATEDIFF(`start_time`,CURDATE())<=7 and DATEDIFF(`start_time`,CURDATE())>=0';
            break;
        case "4":
            $query=$query.' DATEDIFF(`start_time`,CURDATE())<=14 and DATEDIFF(`start_time`,CURDATE())>=0';
            break;
        case "5":
            $query=$query.' DATEDIFF(`start_time`,CURDATE())<=30 and DATEDIFF(`start_time`,CURDATE())>=0';
            break;
        default:
            break;
    }
    $mark=1;
}
if (!$mark) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '未置入查询条件'
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
            $datas[$count-1][7]=iconv('utf-8','gb2312',$rows["avatar_url"]);
            $datas[$count-1][8]=$rows["id"];
            $datas[$count-1][9]=$rows["association_name"];
        }
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