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
$countf = 0;
$datasf=Array();
$countp = 0;
$datasp=Array();
$query = 'SELECT * FROM favorite NATURAL JOIN activities WHERE id = '.$id;
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
    do {
        $countf=$countf+1;
        $datasf[$countf-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datasf[$countf-1][1]=$row["title"];
        $datasf[$countf-1][2]=$row["start_time"];
        $datasf[$countf-1][3]=$row["province"].$row["city"];
        $datasf[$countf-1][4]=$row["linkman"];
        $datasf[$countf-1][5]=$row["click_quantity"];
        $datasf[$countf-1][6]=$row["activity_id"];
     } while ($row = mysqli_fetch_array($res));
}

$query = 'SELECT * FROM activities WHERE founderid='.$id;
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
    do {
        $countp=$countp+1;
        $datasp[$countp-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datasp[$countp-1][1]=$row["title"];
        $datasp[$countp-1][2]=$row["start_time"];
        $datasp[$countp-1][3]=$row["province"].$row["city"];
        $datasp[$countp-1][4]=$row["linkman"];
        $datasp[$countp-1][5]=$row["click_quantity"];
        $datasp[$countp-1][6]=$row["activity_id"];
     } while ($row = mysqli_fetch_array($res));
}
$objsnd = array(
        'state'=> 200,
        'countp'=> $countp,
        'datasp'=> $datasp,
        'countf'=> $countf,
        'datasf'=> $datasf
    );

mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>