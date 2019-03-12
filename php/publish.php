<?php
header("charset=utf-8");
if (($_FILES["event_logo_upload_file"]["size"] > 4000000)) {
	$data = array(
	    		    'error'=> '上传文件不得大于4MB'
	    	    );
}
else if (file_exists("upload/" .date("m-d-H-i-s"). $_FILES["event_logo_upload_file"]["name"]))
      {
                $data = array(
	    		    'msg'=> '400',
	    		    'error'=> '文件已存在'
	    	    );
      }
    else
      {
          $name = iconv('utf-8','gb2312',$_FILES["event_logo_upload_file"]["name"]);
          move_uploaded_file($_FILES["event_logo_upload_file"]["tmp_name"],
          "upload/" .date("m-d-H-i-s"). $name);
          $data = array(
	    		    'msg'=> '0000',
	    		    'error'=> '',
	    		    'imgurl'=> 'upload/' .date("m-d-H-i-s"). $_FILES["event_logo_upload_file"]["name"]
	    	    );
      }
$json_string = json_encode($data);
echo $json_string;
?>