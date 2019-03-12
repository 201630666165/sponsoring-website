    //var upload_url = "/index.php?d=web&c=event&m=upload_event_logo";
    var upload_url = "ava.php";
	//var crop_image_url = "/index.php?d=web&c=event&m=crop_event_logo";
	var crop_image_url = "ava2.php";
	// 自定义操作js
	$(document).ready(function(e){
		$('#event_logo_upload_file').live('change',function(){
			$("#portrait_compile_tier").show();
			ajaxFileUploadview('event_logo_upload_file','photo_pic',upload_url);
		});	

	});

	function show_head(head_file){
		//插入数据库
		//$.post("{:U('Home/Index/update_head')}",{head_file:head_file},function(result){		
			$("#event_logo_image").attr('src',head_file);	
			$("#event_logo_url").val(head_file);	
			$("#portrait_compile_tier").hide();
		//});	
	}
	
	//未上传关闭窗口函数
	function aui_close () {
		$("#portrait_compile_tier").fadeOut(150);
	}

	//文件上传带预览
	function ajaxFileUploadview(imgid,hiddenid,url){

			$.ajaxFileUpload
			({
				url:url,
				secureuri:false,
				fileElementId:imgid,
				data:{name:'logan', id:'id'},
				success: function (data)
				{
                    var str = $(data).find("body").text();//获取返回的字符串
                    data = $.parseJSON(str);//把字符串转化为json对象
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
//							var dialog = art.dialog({title:false,fixed: true,padding:0});
//							dialog.time(2000).content("<div class='tips'>"+data.error+"</div>");
							PopupMessage(1, data.error, 2000);
							return false;
						}else{
							var resp = data.msg;						
							if(resp != '0000'){
//								var dialog = art.dialog({title:false,fixed: true,padding:0});
//								dialog.time(2).content("<div class='tips'>"+data.error+"</div>");
								PopupMessage(1, data.error, 2000);
								return false;
							}else{
								$('#'+hiddenid).val(data.imgurl);						
								art.dialog.open(crop_image_url+"?img="+data.imgurl,{
									title: '编辑活动海报',
									width:'580px',
									height:'400px'
								});						
								
								//dialog.time(3).content("<div class='msg-all-succeed'>上传成功！</div>");
							}			
						}
					}
				},
				error: function (data, status, e)
				{
					dialog.time(3).content("<div class='tips'>"+e+"</div>");
				}
			})
			return false;
		}
