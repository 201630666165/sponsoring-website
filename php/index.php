<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);

$datasa=Array();
$counta=0;
$query = 'SELECT count(*),founderid FROM activities GROUP BY founderid ORDER BY count(*) DESC LIMIT 5';
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
        $counta=$counta+1;
        $datasa[$counta-1][0]=$row["count(*)"];
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
            $datasa[$counta-1][1]=$rows["association_name"];
            $datasa[$counta-1][2]=$rows["introduction"];
            $datasa[$counta-1][3]=$rows["avatar_url"];
            $datasa[$counta-1][4]=$rows["id"];
        }
     } while ($row = mysqli_fetch_array($res));
}

$datasc=Array();
$countc=0;
$query = 'SELECT event_logo_url,title,activity_id FROM activities WHERE DATEDIFF(`start_time`,CURDATE())>=0 AND NOT event_logo_url="" ORDER BY click_quantity DESC LIMIT 2';//选择点击量最大且未过期的前两个有海报的活动，
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
        $countc=$countc+1;
        $datasc[$countc-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datasc[$countc-1][1]=$row["title"];
        $datasc[$countc-1][2]=$row["activity_id"];
     } while ($row = mysqli_fetch_array($res));
}
else{
    $query = 'SELECT event_logo_url,title,activity_id FROM activities WHERE NOT event_logo_url="" ORDER BY click_quantity DESC LIMIT 2';//如果没有符合条件的，就囊括过期的活动
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
            $countc=$countc+1;
            $datasc[$countc-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
            $datasc[$countc-1][1]=$row["title"];
            $datasc[$countc-1][2]=$row["activity_id"];
        } while ($row = mysqli_fetch_array($res));
    }
}

$dataso=Array();
$counto=0;
$query = 'SELECT * FROM activities WHERE DATEDIFF(`end_time`,CURDATE())<0 ORDER BY click_quantity LIMIT 7';
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
        $counto=$counto+1;
        $dataso[$counto-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $dataso[$counto-1][1]=$row["title"];
        $dataso[$counto-1][2]=$row["click_quantity"];
        $dataso[$counto-1][3]=$row["content"];
        $dataso[$counto-1][4]=$row["activity_id"];
     } while ($row = mysqli_fetch_array($res));
}

$datasf=Array();
$countf=0;
$query = 'SELECT DISTINCT activity_id,count( * ) AS count FROM favorite GROUP BY activity_id ORDER BY count DESC LIMIT 7';
$res = mysqli_query($con,$query);//收集收藏热门榜数据
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
        $datasf[$countf-1][3]=$row["activity_id"];
        $datasf[$countf-1][4]=$row["count"];
        $query = 'SELECT * FROM activities WHERE activity_id = '.$row["activity_id"];
        $ress = mysqli_query($con,$query);
        if (!$ress) {//查询收藏人数
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
            $datasf[$countf-1][0]=iconv('utf-8','gb2312',$rows["event_logo_url"]);
            $datasf[$countf-1][1]=$rows["title"];
            $datasf[$countf-1][2]=$rows["click_quantity"];
        } 
    } while ($row = mysqli_fetch_array($res));
}

$datasn=Array();
$countn=0;
$query = 'SELECT * FROM activities ORDER BY activity_id DESC LIMIT 7';
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
        $countn=$countn+1;
        $datasn[$countn-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datasn[$countn-1][1]=$row["title"];
        $datasn[$countn-1][2]=$row["publish_date"];
        $datasn[$countn-1][3]=$row["activity_id"];
     } while ($row = mysqli_fetch_array($res));
}

$datash=Array();
$counth=0;
$query = 'SELECT * FROM activities ORDER BY click_quantity DESC LIMIT 7';
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
        $counth=$counth+1;
        $datash[$counth-1][0]=iconv('utf-8','gb2312',$row["event_logo_url"]);
        $datash[$counth-1][1]=$row["title"];
        $datash[$counth-1][2]=$row["click_quantity"];
        $datash[$counth-1][3]=$row["activity_id"];
        $query = 'SELECT COUNT(*) FROM `favorite` WHERE activity_id = '.$row["activity_id"];
        $ress = mysqli_query($con,$query);
        if (!$ress) {//查询收藏人数
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
            $datash[$counth-1][4]=$rows['COUNT(*)'];
        }
     } while ($row = mysqli_fetch_array($res));
    $objsnd = array(
        'state'=> 200,
        'datash'=> $datash,
        'counth'=> $counth,
        'datasn'=> $datasn,
        'countn'=> $countn,
        'dataso'=> $dataso,
        'counto'=> $counto,
        'datasc'=> $datasc,
        'countc'=> $countc,
        'datasf'=> $datasf,
        'countf'=> $countf,
        'datasa'=> $datasa,
        'counta'=> $counta
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