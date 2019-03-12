<?php
    header("charset=utf-8");
    $url = $_GET["img"];
    echo '
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"> 
<title>编辑活动海报</title>
<script src="jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="jquery.Jcrop_new.js" type="text/javascript"></script>
<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css">
<link rel="stylesheet" href="default.css?4.1.6">
<script type="text/javascript" src="jquery.artDialog.js?skin=default"></script>
<script type="text/javascript" src="iframeTools.js"></script>

<!--<link rel="stylesheet" href="__PUBLIC__/Css/jcrop.css" type="text/css" />-->
<style type="text/css">
html{
	overflow:hidden;
}
@charset "utf-8";
/* CSS Document */
body{padding:0; margin:0; font-size:83%; background:#fff;overflow:hidden; color:#333333; font-family:"宋体",Verdana, Geneva, sans-serif;}
.rel{position:relative;}.abs{position:absolute;}.fixed{position:fixed;}
.zxx_out_box{margin:0 auto;}
.zxx_main_con{margin: 8px auto 0;padding-bottom: 12px;width: 524px;}
.zxx_test_list{padding:1em 0; font-size:1.1em;line-height:1.3; overflow:hidden; zoom:1;}
.love_img_btn{ text-align:center; margin-top:30px;}
.btn2{ font-size:12px; color:#FFF; text-align:center; width:79px; height:30px; line-height:30px; border:none; background:url(../style/images/btn_bg1.png) no-repeat;}
.jcrop-holder { float:left;width:523px !important;margin-right:20px;min-height:284px !important;background:#ccc !important;}
/*控制预览图大小*/
/*.jcrop-holder img{max-height: 283px;}*/
.crop_preview{float:left;width:104px;height:104px;overflow:hidden;overflow:hidden;}
.crop_preview img{
	background:#ccc;
	vertical-align: top;
}
.clear{clear:both}
.btn{cursor:pointer}
.tl{text-align:left}
.tc{text-align:center;}
.ml10 {margin-left:10px;}
.mt10 {margin-top:10px;}
.ml-180{#margin-left:-180px;}
.confirmOk,.confirm_exit{
	background:#62b651;
	color:#fff;
	border:1px solid #62b651;
	border-radius:3px;
	width:80px;
	height:30px;
	#line-height:20px;
	font-size:15px;
	font-family:"微软雅黑";
	cursor: pointer;
	display:inline-block;
	margin:0px;
}
.confirm_exit{
	#margin-left:10px;/*ie7*/
	border:1px solid #A5AAAE;
}
.confirmOk:focus,.confirm_exit{
	outline:none;
}
.confirm_exit{
	margin-left:10px;
	background:#FBFBFB;
	color:#5E676C;
}

</style>
<script type="text/javascript">
	$(document).ready(function(){
		
		xsize = $(".crop_preview").width(),
        ysize = $(".crop_preview").height();
		$("#xuwanting").Jcrop({
			onChange:showPreview,
			onSelect:showPreview,
			aspectRatio: xsize / ysize,
	        setSelect: [ 0, 0, 325, 416 ],	       
	        boxWidth:400,
	        boxHeight:300
			
		});	
		//简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
		function showPreview(coords){
			if(parseInt(coords.w) > 0){
				//计算预览区域图片缩放的比例，通过计算显示区域的宽度(与高度)与剪裁的宽度(与高度)之比得到
				var rx = $("#preview_box").width() / coords.w; 
				var ry = $("#preview_box").height() / coords.h;
				//通过比例值控制图片的样式与显示
				$("#crop_preview").css({
					width:Math.round(rx * $("#xuwanting").width()) + "px",	//预览图片宽度为计算比例值与原图片宽度的乘积
					height:Math.round(rx * $("#xuwanting").height()) + "px",	//预览图片高度为计算比例值与原图片高度的乘积
					marginLeft:"-" + Math.round(rx * coords.x) + "px",
					marginTop:"-" + Math.round(ry * coords.y) + "px"
				});
				$("#x").val(coords.x);
		        $("#y").val(coords.y);
		        $("#w").val(coords.w);
		        $("#h").val(coords.h);
			}
		}
		//表单提交
		$("#confirmOk").click(function(){
			if (parseInt($("#w").val())){
				var act = $("#act").val();
				var pic_name = $("#pic_name").val();
				var x = $("#x").val();
				var y = $("#y").val();
				var w = $("#w").val();
				var h = $("#h").val();

                $.ajax({
	                url:"crop_avatar_submit.php",
	                type:"POST",
	                data:{
	                	pic_name:pic_name,
	                	x:x,
	                	y:y,
	                	w:w,
	                	h:h
	                },
	                async:false,
	                success:function(data) {
	                    if(data.status==1){
						    var _call_back="show_head";
						    var win = art.dialog.open.origin; 
						    if(_call_back && win[_call_back] && typeof(win[_call_back])=="function"){ 
							    try{ 
							    	win[_call_back].call(this, data.file); 
						    		art.dialog.close();
							    }catch(e){
							    	alert("确认异常");
						    	}; 
						    } 
					
					    }else{
					
						alert(data.error);
						return false;
					    }					
                    },
                    error:function(xhr,msg,exc){
                        alert("图片类型不符！");
	                }
                });
			    return false;
			}			
		    return false;
		});
	});
	
	//退出按钮关闭弹窗
	$( function  () {
		$("#confirm_exit").click( function () {
			$("#portrait_compile_tier", window.parent.document).hide();
			art.dialog.close();
		})
	})
</script>
</head>
<body>
    <div class="" style="display: none; position: absolute;"><div class="aui_outer">
    <table class="aui_border"><tbody><tr><td class="aui_nw"></td><td class="aui_n"></td><td class="aui_ne"></td></tr><tr><td class="aui_w"></td><td class="aui_c"><div class="aui_inner"><table class="aui_dialog"><tbody><tr><td colspan="2" class="aui_header"><div class="aui_titleBar"><div class="aui_title" style="cursor: move;"></div><a class="aui_close" href="javascript:void(0); " id="aui_close" onclick="aui_close()">×</a></div></td></tr><tr><td class="aui_icon" style="display: none;"><div class="aui_iconBg" style="background: none;"></div></td><td class="aui_main" style="width: auto; height: auto;"><div class="aui_content" style="padding: 20px 25px;"></div></td></tr><tr><td colspan="2" class="aui_footer"><div class="aui_buttons" style="display: none;"></div></td></tr></tbody></table></div></td><td class="aui_e"></td></tr><tr><td class="aui_sw"></td><td class="aui_s"></td><td class="aui_se" style="cursor: se-resize;"></td></tr></tbody></table></div></div>

	<div class="zxx_out_box">
    <div class="zxx_main_con">
        <div class="zxx_test_list">
            <div class="rel">
                <img id="xuwanting" src="'.$url.'" style="display: none;">
                <span id="preview_box" class="crop_preview" style="display: none;"><img id="crop_preview" src="'.$url.'" style="width: 1080px; height: 1440px; margin-left: 0px; margin-top: 0px;"></span>
            </div>
        </div>
    </div>
    <div class="zxx_footer">
        <form>
  	        <input type="hidden" id="act" name="act" value="background">
  			<input type="hidden" id="pic_name" name="pic_name" value="'.$url.'">
			<input type="hidden" id="x" name="x" value="0">
			<input type="hidden" id="y" name="y" value="0">
			<input type="hidden" id="w" name="w" value="1080">
			<input type="hidden" id="h" name="h" value="638">			
	    </form>
    </div>
</div>
<div class="clear"></div>
   <div class="fn pt20 tc">
      <input type="button" class="btn-all w110 ml-180 confirmOk" id="confirmOk" value="保存">
	  <input type="button" class="btn-all w110 ml-180 confirm_exit" id="confirm_exit" value="取消">
	</div>

	

<div style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: rgb(255, 255, 255);"></div></body></html>
    ';

?>