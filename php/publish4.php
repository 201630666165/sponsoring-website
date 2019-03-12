<?php
header("charset=utf-8");
if ($_FILES["share_logo_upload_file"]["error"] > 0){
	$data = array(
	    		    'error'=> '上传文件错误',
	    		    'state'=> 204
	    	    );
}
else if ($_FILES["share_logo_upload_file"]["type"]!='image/gif'&&
    $_FILES["share_logo_upload_file"]["type"]!='image/jpeg'&&
    $_FILES["share_logo_upload_file"]["type"]!='image/png'&&
    $_FILES["share_logo_upload_file"]["type"]!='application/x-MS-bmp') {
	$data = array(
	    		    'error'=> '上传文件格式不符',
	    		    'state'=> 205
	    	    );
}
else  if (($_FILES["share_logo_upload_file"]["size"] > 2000000)) {
	$data = array(
	    		    'error'=> '上传文件不得大于2MB',
	    		    'state'=> 206
	    	    );
}
else if (file_exists("shareimgup/" .date("m-d-H-i-s"). iconv('utf-8','gb2312',$_FILES["share_logo_upload_file"]["name"])))
      {
                $data = array(
	    		    'msg'=> '400',
	    		    'error'=> '文件已存在',
	    		    'state'=> 207
	    	    );
      }
    else
      {
          $name = iconv('utf-8','gb2312',$_FILES["share_logo_upload_file"]["name"]);
          move_uploaded_file($_FILES["share_logo_upload_file"]["tmp_name"],
          "shareimgup/" .date("m-d-H-i-s"). $name);
          $data = array(
	    		    'state'=> 200,
                    'pic_url'=> "shareimgup/" .date("m-d-H-i-s"). $name
	    	    );
      }
$json_string = json_encode($data);
echo $json_string;
?>