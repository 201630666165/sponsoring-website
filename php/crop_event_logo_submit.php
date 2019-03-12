<?php
/*$data = array(
              'status'=> 0,
              'error'=> '图片类型不符！'
            );
 $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
            exit();*/
//记得用getimagesize判断图像像素值是否符合要求
header("Content-Type: text/html; charset=utf-8");
$path = $_POST["pic_name"];
$x = $_POST["x"];
$y = $_POST["y"];
$w = $_POST["w"];
$h = $_POST["h"];
$path = iconv('utf-8','gb2312',$path);
list($width,$height,$type,$attr)=getimagesize($path);
if ($width<1080||$height<640) {
  $data = array(
              'status'=> 0,
              'error'=> '图片尺寸不足1080*640！'
            );
 $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
            exit();
}


switch ($type) {
      case IMAGETYPE_GIF:
           $im1 = imagecreatefromgif($path);  //创建一个跟原图一样大小的图片
           break;
      case IMAGETYPE_JPEG:
           $im1 = imagecreatefromjpeg($path);  //创建一个跟原图一样大小的图片
           break;
      case IMAGETYPE_PNG:
           $im1 = imagecreatefrompng($path);  //创建一个跟原图一样大小的图片
           break;
      default :
           $data = array(
              'status'=> 0,
              'error'=> '图片类型不符！'
            );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
           exit();
    break;
}
$new_img = imagecreatetruecolor($w, $h);  //创建一个用户剪裁宽高的黑白图片
if(!imagecopyresampled($new_img, $im1, 0, 0, $x, $y, $w, $h, $w, $h))
{
  $data = array(
              'status'=> 0,
              'error'=> '剪裁图片失败！'
            );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
  exit();
} //将原图拷贝到新创建剪裁区域的图片中
switch ($type) {
       case IMAGETYPE_GIF:
            $newsrc = "upload-croped/".date("m-d-H-i-s")."gif";
            $newsrc = iconv('utf-8','gb2312',$newsrc);
            if(!imagegif($new_img, $newsrc))
             //按新路径保存图片
            {
                $data = array(
                    'status'=> 0,
                    'error'=> '保存图片失败！'
                );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
            exit();
            }
            break;
       case IMAGETYPE_JPEG:
            $newsrc = "upload-croped/".date("m-d-H-i-s").".jpg";
            $newsrc = iconv('utf-8','gb2312',$newsrc);
            if(!imagejpeg($new_img, $newsrc))
             //按新路径保存图片
            {
                $data = array(
                    'status'=> 0,
                    'error'=> '保存图片失败！'
                );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
            exit();
            }
            break;
       case IMAGETYPE_PNG:
            $newsrc = "upload-croped/".date("m-d-H-i-s")."png";
            $newsrc = iconv('utf-8','gb2312',$newsrc);
            if(!imagepng($new_img, $newsrc))
             //按新路径保存图片
            {
                $data = array(
                    'status'=> 0,
                    'error'=> '保存图片失败！'
                );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;
            exit();
            }
            break;
       default:
            $data = array(
              'status'=> 0,
              'error'=> '???'
            );
            $json_string = json_encode($data);
            header('Content-Type: application/json');
            echo $json_string;

            exit();

            break;
}
$data = array(
              'status'=> 1,
              'file'=> $newsrc,
              'error'=> ''
            );
$json_string = json_encode($data);
header('Content-Type: application/json');
echo $json_string;
?>