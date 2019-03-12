<?php
header("charset=utf-8");
if ($_FILES["additive_upload_file"]["error"] > 0){
	$data = array(
	    		    'error'=> '上传文件错误',
	    		    'state'=> 204
	    	    );
}
else if ($_FILES["additive_upload_file"]["type"]!='application/msword'&&
    $_FILES["additive_upload_file"]["type"]!='application/vnd.openxmlformats-officedocument.wordprocessingml.document'&&
    $_FILES["additive_upload_file"]["type"]!='application/pdf'&&
    $_FILES["additive_upload_file"]["type"]!='text/plain'&&
    $_FILES["additive_upload_file"]["type"]!='application/vnd.ms-powerpoint'&&
    $_FILES["additive_upload_file"]["type"]!='application/vnd.openxmlformats-officedocument.presentationml.presentation') {
	$data = array(
	    		    'error'=> '上传文件格式不符',
	    		    'state'=> 205
	    	    );
}
else  if (($_FILES["additive_upload_file"]["size"] > 4000000)) {
	$data = array(
	    		    'error'=> '上传文件不得大于4MB',
	    		    'state'=> 206
	    	    );
}
else if (file_exists("fileup/" .date("m-d-H-i-s"). iconv('utf-8','gb2312',$_FILES["additive_upload_file"]["name"])))
      {
                $data = array(
	    		    'msg'=> '400',
	    		    'error'=> '文件已存在',
	    		    'state'=> 207
	    	    );
      }
    else
      {
          $name = iconv('utf-8','gb2312',$_FILES["additive_upload_file"]["name"]);
          move_uploaded_file($_FILES["additive_upload_file"]["tmp_name"],"fileup/" .date("m-d-H-i-s"). $name);
          $name = iconv('gb2312','utf-8',$name);
          $data = array(
          	        'state'=> 200,
                    'file_url'=> "fileup/" .date("m-d-H-i-s"). $name
	    	    );
      }
$json_string = json_encode($data);
echo $json_string;
?>