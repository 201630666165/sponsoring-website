function change(op) {
	if ($("input#option").val()==op) {
		return;
	}
	else{
		$("div#option"+op).fadeIn();
		$("div#option"+$("input#option").val()).fadeOut();
		$("a#option"+op).css({"background":"transparent"});
		$("a#option"+$("input#option").val()).css({"background":"rgba(0,0,0,0.035) none repeat scroll 0 0"});
		$("input#option").val(op);
	}
}
var userid=0;
$.ajax({
	type:"GET",
	url:"user_session.php",
	data:{
            userid:0
    },
    async: false,
    dataType:"json",
    beforeSend: function() {
        $(".modal").show();
	},
	success:function(data){
		$(".modal").hide();
        if (data.result==1) {
        	if ($("input#sessionid").val()=='') {
        		window.location.href="login.html";
        	}
        	else{
        		userid=$("input#sessionid").val();
        	}
        }
        else if (data.result==0) {
        	userid=data.userid;
        }
        else{
        	alert(data);
        }
	},
	error:function(xhr,msg,exc){
        alert("请求超时-"+msg);
	}
});
if (userid!=$("input#sessionid").val()) {
    $(".btn").hide();
    $("input").attr('readonly',"true");
}

$.ajax({
	    type:"POST",
        url:"user_info.php",
        data:{
            id:userid
        },
        dataType:"json",
        beforeSend: function() {
            $(".modal").show();
		},
		success:function(data){
			$(".modal").hide();
			//创建成功
			if (data.state == 200)
			{
				if (data.datas[0]=='') {data.datas[0]='images/default_face.png';}
				$("div.name").html(data.datas[2]);
				$("span.little_name").html(data.datas[2]);
				$("#avatar").attr('src',data.datas[0]);
				$("#little_avatar").attr('src',data.datas[0]);
				$("#event_logo_image").attr('src',data.datas[0]);
				$("#association_name").val(data.datas[2]);
				$("#contact_name").val(data.datas[4]);
				$("#introduction").val(data.datas[5]);
				$("#tel").val(data.datas[1]);
				$("#e_mail").val(data.datas[3]);
			}else if(data.state == 204){
				/*alert('参数错误！');*/
				alert(data.errormsg);
				alert(data.errorquery);
				alert(userid);
				/*alert(data.errorquery);*/
			}
			else{
				alert(data);
			}
		},
        error:function(xhr,msg,exc){
            alert("请求超时-"+msg);
	    }
    });

$.ajax({
	    type:"POST",
        url:"user.php",
        data:{
            id:userid
        },
        dataType:"json",
        beforeSend: function() {
            $(".modal").show();
		},
		success:function(data){
			$(".modal").hide();
			//创建成功
			if (data.state == 200)
			{
				$(".event_ul").html('');
				$(".footer").html('');
				$("#pub").html(data.countp);
			    /*alert(data.count);*/
			    for (var i = 0; i < data.countp; i++) {
			    	if (data.datasp[i][0]=='') {
			    	        data.datasp[i][0]="images/default_logo.png";
			            }
			    	$(".event_ul").append(
			    		'<li style="display:none;"><a class="event" onclick="javascript:enterevent('
			    		+data.datasp[i][6]+
			    		');"><div class="event_logo"><img id="event_logo" src="'
			    		+data.datasp[i][0]+
			    		'"></div></a><div class="event_content"><h3>'
			    		+data.datasp[i][1]+
			    		'</h3><div class="event_date"><span class="icontime"></span>'
			    		+data.datasp[i][2]+
			    		'</div><div class="event_address"><span class="iconplace"></span>'
			    		+data.datasp[i][3]+
			    		'</div><div class="event_foot"><img class="iconface" src="images/default_face.png"><span class="linkman">'
			    		+data.datasp[i][4]+
			    		'</span><span class="click_quantity">'
			    		+data.datasp[i][5]+
			    		'</span><span class="iconcq"></span></div></li>'
			    		);
			    }
			    $(".footer").append('<input type="hidden" id="page_counter" value='+0+'>');
			    
			    for (var i = 0; i < Math.floor((data.countp+9)/10); i++) {
			    	$(".footer").append('<li><a onclick="javascript:page('+i+');">'+(i+1)+'</a></li>');
			    }
			    page(0);

			    $(".event_ulf").html('');
				$(".footerf").html('');
				$("#fav").html(data.countf);
			    /*alert(data.count);*/
			    for (var i = 0; i < data.countf; i++) {
			    	if (data.datasf[i][0]=='') {
			    	        data.datasf[i][0]="images/default_logo.png";
			            }
			    	$(".event_ulf").append(
			    		'<li style="display:none;"><a class="event" onclick="javascript:enterevent('
			    		+data.datasf[i][6]+
			    		');"><div class="event_logo"><img id="event_logo" src="'
			    		+data.datasf[i][0]+
			    		'"></div></a><div class="event_content"><h3>'
			    		+data.datasf[i][1]+
			    		'</h3><div class="event_date"><span class="icontime"></span>'
			    		+data.datasf[i][2]+
			    		'</div><div class="event_address"><span class="iconplace"></span>'
			    		+data.datasf[i][3]+
			    		'</div><div class="event_foot"><img class="iconface" src="images/default_face.png"><span class="linkman">'
			    		+data.datasf[i][4]+
			    		'</span><span class="click_quantity">'
			    		+data.datasf[i][5]+
			    		'</span><span class="iconcq"></span></div></li>'
			    		);
			    }
			    $(".footerf").append('<input type="hidden" id="page_counterf" value='+0+'>');
			    
			    for (var i = 0; i < Math.floor((data.countf+9)/10); i++) {
			    	$(".footerf").append('<li><a onclick="javascript:pagef('+i+');">'+(i+1)+'</a></li>');
			    }
			    pagef(0);
			}else if(data.state == 204){
				$(".event_ulf").html('');
				$(".footerf").html('');
				/*alert('参数错误！');*/
				alert(data.errormsg);
				/*alert(data.errorquery);*/
			}
			else{
				alert(data);
			}
		},
        error:function(xhr,msg,exc){
            alert("请求超时-"+msg);
	    }
    });
function page(num) {
	/*alert($(".event_ul li").get(0));*/
	for (var i = 0; i < 10; i++) {
		if (typeof ($(".event_ul li").get(i+$("#page_counter").val()*10))!="undefined") {
			$(".event_ul li").get(i+$("#page_counter").val()*10).style.display="none";
			$(".footer li").get($("#page_counter").val()).style.backgroundColor="rgba(0,0,0,0.5)";
		}
		if (typeof ($(".event_ul li").get(i+num*10))!="undefined") {
		    $(".event_ul li").get(i+num*10).style.display="list-item";
		    $(".footer li").get(num).style.backgroundColor="#ff6008";
		}
	}
	$("#page_counter").val(num);
}
function pagef(num) {
	/*alert($(".event_ul li").get(0));*/
	for (var i = 0; i < 10; i++) {
		if (typeof $(".event_ulf li").get(i+$("#page_counterf").val()*10)!="undefined") {
			$(".event_ulf li").get(i+$("#page_counterf").val()*10).style.display="list-item";
			$(".footerf li").get($("#page_counter").val()).style.backgroundColor="rgba(0,0,0,0.5)";
		}
		if (typeof $(".event_ulf li").get(i+num*10)!="undefined") {
		    $(".event_ulf li").get(i+num*10).style.display="list-item";
		    $(".footerf li").get(num).style.backgroundColor="#ff6008";
		}
	}
	$("#page_counterf").val(num);
}
function enterevent(activity_id) {
	$.ajax({
        url:"event_session.php",
        type:"GET",
        data:{activity_id:activity_id},
        async:false,
        success:function(objsnd) {
            if (objsnd.result==0) {
                window.location.href="event.html";
            }
            else if (objsnd.result==2) {
            	alert(objsnd.errormsg);
            }
            else{
            	alert(objsnd);
            }
        },
        error:function(xhr,msg,exc){
            alert(msg);
            return false;
        }
    });
}
function updateinfo() {
	var sessionid = $("input#sessionid").val();
    if (sessionid=='') {window.location.href="login.html";}
	var id = $('#tel').val();
	var association_name = $('#association_name').val();
	var	contact_name = $('#contact_name').val();
	var	e_mail = $('#e_mail').val();
	var	avatar_url = $('#event_logo_url').val();
	var	introduction = $('#introduction').val();
	    if($.trim(id)==''){
            alert('请输入手机号码！');
            return false;
        }
        if(!validateRules.isMobile(id)){
            alert('请正确输入您的手机号！');
            return false;
        }
        if(association_name==''){
            alert('请输入社团名称！');
            return false;
        }
        if($.trim(contact_name)==''){
            alert('请输入姓名！');
            return false;
        }
        var e_mailformat = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
        if (!e_mailformat.test(e_mail)){
            alert('邮箱格式不符！');
            return false;
        }

    $.ajax({
            type:"POST",
            url:"updateinfo.php",
            data:{
            	sessionid:sessionid,
                id:id,
                contact_name:contact_name,
                association_name:association_name,
                e_mail:e_mail,
                avatar_url:avatar_url,
                introduction:introduction
            },
            async:false,
            beforeSend: function() {
                //验证发送ajax
                $(".modal").show();
            },
            success:function(objsnd){
                //创建成功
                $(".modal").hide();
                if (objsnd.state == 200)
                {
                    alert("修改成功！");
                    $.post("session_destroy.php");
					window.location.href="login.html";
                }else if (objsnd.state == 204){
                    alert(objsnd.errormsg);
                    alert(objsnd.errorquery);
                    return false;
                }else{
                    alert(objsnd);
                    return false;
                }

            },
            complete: function(){
            	$(".modal").hide();
                // 				alert('complete');
            },
            error: function(xhr,msg){
                //请求出错处理
                $(".modal").hide();
                alert(msg);
                return false;
            }
        });
}