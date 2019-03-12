<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$founderid = mysqli_real_escape_string($con,$_POST["sessionid"]);
$title = mysqli_real_escape_string($con,$_POST["title"]);
$province = mysqli_real_escape_string($con,$_POST["province"]);
$city = mysqli_real_escape_string($con,$_POST["city"]);
$address = mysqli_real_escape_string($con,$_POST["address"]);
$lng = mysqli_real_escape_string($con,$_POST["lng"]);
$lat = mysqli_real_escape_string($con,$_POST["lat"]);
$start_time = mysqli_real_escape_string($con,$_POST["start_time"]);
$end_time = mysqli_real_escape_string($con,$_POST["end_time"]);
$event_logo_url = mysqli_real_escape_string($con,$_POST["event_logo_url"]);
$file_url = mysqli_real_escape_string($con,$_POST["file_url"]);
$file_name = mysqli_real_escape_string($con,$_POST["file_name"]);
$category = mysqli_real_escape_string($con,$_POST["category"]);
$money = mysqli_real_escape_string($con,$_POST["money"]);
$tag = mysqli_real_escape_string($con,$_POST["tag"]);
$content = mysqli_real_escape_string($con,$_POST["content"]);
$linkman = mysqli_real_escape_string($con,$_POST["linkman"]);
$tel = mysqli_real_escape_string($con,$_POST["tel"]);
$qq = mysqli_real_escape_string($con,$_POST["qq"]);
$weixin = mysqli_real_escape_string($con,$_POST["weixin"]);
$is_agent = mysqli_real_escape_string($con,$_POST["is_agent"]);
$share_title = mysqli_real_escape_string($con,$_POST["share_title"]);
$share_summary = mysqli_real_escape_string($con,$_POST["share_summary"]);
$share_logo_url = mysqli_real_escape_string($con,$_POST["share_logo_url"]);

if (empty($qq)) {
    $qq = 'NULL';
}
if (empty($weixin)) {
    $weixin = 'NULL';
}

$query = "SELECT * FROM activities WHERE `title`='".$title."'";
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
if ($row = mysqli_fetch_array($res)) {
    $objsnd = array(
        'state'=> 205,
        'errormsg'=> '不能重复发布相同的活动'
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}

$insquery = 'INSERT INTO activities VALUES('.$founderid.',"'.$title.'","'.$province.'","'.$city.'","'.$address.'","'.$lng.'","'.$lat.'","'.$start_time.'","'.$end_time.'","'.$event_logo_url.'","'.$file_url.'","'.$file_name.'","'.$category.'","'.$money.'","'.$tag.'","'.$content.'","'.$linkman.'","'.$tel.'",'.$qq.','.$weixin.',"'.$is_agent.'","'.$share_title.'","'.$share_summary.'","'.$share_logo_url.'","0",NULL,"'.date("Y-m-d").'")';
$query = 'SELECT * FROM activities WHERE title = "'.$title.'"';
if(!mysqli_query($con,$insquery)){
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> mysqli_error($con)
    );
}
else {
    $res = mysqli_query($con,$query);
    if (!$res) {
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> mysqli_error($con),
        'errorquery'=> $query
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
else if ($row = mysqli_fetch_array($res)) {

    $objsnd = array(
        'state'=> 200,
        'activity_id'=> $row["activity_id"]
    );
}
else{
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> mysqli_error($con),
        'errorquery'=> $query
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
}

mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>