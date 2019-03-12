<?php
$con = mysqli_connect("localhost","root","","activity_founder");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }
header("Content-Type: text/html; charset=utf-8");
$query = "set names utf8";
mysqli_query($con,$query);
$sessionid = mysqli_real_escape_string($con,$_POST["sessionid"]);
$id = mysqli_real_escape_string($con,$_POST["id"]);
$association_name = mysqli_real_escape_string($con,$_POST["association_name"]);
$e_mail = mysqli_real_escape_string($con,$_POST["e_mail"]);
$contact_name = mysqli_real_escape_string($con,$_POST["contact_name"]);
$avatar_url = mysqli_real_escape_string($con,$_POST["avatar_url"]);
$introduction = mysqli_real_escape_string($con,$_POST["introduction"]);
$query = "SELECT * FROM users WHERE `id`=".$id;
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
if($row = mysqli_fetch_array($res) && $id!=$sessionid){
    $objsnd = array(
        'state'=> 204,
        'errormsg'=> '号码已存在'
    );
    mysqli_close($con);
    $json_string = json_encode($objsnd);
    header('Content-Type: application/json');
    echo $json_string;
    exit();
}
else{
    $query = "UPDATE users SET id = ".$id." WHERE id = ".$sessionid;
    $query2 = "UPDATE associations SET `association_name` = '".$association_name."' ,`e-mail` = '".$e_mail."' ,`contact_name` = '".$contact_name."' ,`avatar_url` = '".$avatar_url."' , `introduction` = '".$introduction."' WHERE id = ".$id;
    if(!mysqli_query($con,$query)){
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
    }else if (!mysqli_query($con,$query2)) {
        $query = "UPDATE users SET id = ".$sessionid." WHERE id = ".$id;//回滚操作
        mysqli_query($con,$query);
        $objsnd = array(
            'state'=> 204,
            'errormsg'=> mysqli_error($con),
            'errorquery'=> $query2
        );
        mysqli_close($con);
        $json_string = json_encode($objsnd);
        header('Content-Type: application/json');
        echo $json_string;
        exit();
    }
    else{
        $objsnd = array(
            'state'=> 200
        );
    }
}
mysqli_close($con);
$json_string = json_encode($objsnd);
header('Content-Type: application/json');
echo $json_string;
?>