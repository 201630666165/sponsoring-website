$("#screen1").val(0);
$("#screen2").val(0);
$("#screen3").val('');
$("#screen4").val(0);
function clik(html,val,mod) {
	if ($("#screen"+mod).val()!=0||$("#screen"+mod).val()!='') {return;}
	$("#selected"+mod).html(html+"<span class='x' onclick='javascript:del("+mod+");'>╳</span>");
	$("#screen"+mod).val(val);
	$("#selected"+mod).parent().show();
	var mod1 = $("#screen1").val();
	var mod2 = $("#screen2").val();
	var mod3 = $("#screen3").val();
	var mod4 = $("#screen4").val();
    $.ajax({
	    type:"POST",
        url:"searchevent.php",
        data:{
            mod1:mod1,
            mod2:mod2,
            mod3:mod3,
            mod4:mod4
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
			    /*alert(data.count);*/
			    for (var i = 0; i < data.count; i++) {
			    	if (data.datas[i][0]=='') {
			    	        data.datas[i][0]="images/default_logo.png";
			            }
			    	$(".event_ul").append(
			    		'<li style="display:none;"><a class="event" onclick="javascript:enterevent('
			    		+data.datas[i][6]+
			    		');"><div class="event_logo"><img id="event_logo" src="'
			    		+data.datas[i][0]+
			    		'"></div></a><div class="event_content"><h3>'
			    		+data.datas[i][1]+
			    		'</h3><div class="event_date"><span class="icontime"></span>'
			    		+data.datas[i][2]+
			    		'</div><div class="event_address"><span class="iconplace"></span>'
			    		+data.datas[i][3]+
			    		'</div><div class="event_foot"><a onclick="enteruser('
			    		+data.datas[i][8]+
			    		')"><img class="iconface" src="'
			    		+data.datas[i][7]+
			    		'"></a><span class="linkman">'
			    		+data.datas[i][9]+
			    		'</span><span class="click_quantity">'
			    		+data.datas[i][5]+
			    		'</span><span class="iconcq"></span></div></li>'
			    		);
			    }

			    $(".footer").append('<input type="hidden" id="page_counter" value='+0+'>');
			    for (var i = 0; i < Math.floor((data.count+9)/10); i++) {
			    	$(".footer").append('<li><a onclick="javascript:page('+i+');">'+(i+1)+'</a></li>');
			    }
			    page(0);
			}else if(data.state == 204){
				$(".event_ul").html('');
				$(".footer").html('');
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
}
function del(mod) {
	$("#screen"+mod).val('');
	$("#selected"+mod).parent().hide();
	$("#selected"+mod).html('');
	var mod1 = $("#screen1").val();
	var mod2 = $("#screen2").val();
	var mod3 = $("#screen3").val();
	var mod4 = $("#screen4").val();
    $.ajax({
	    type:"POST",
        url:"searchevent.php",
        data:{
            mod1:mod1,
            mod2:mod2,
            mod3:mod3,
            mod4:mod4
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
			    /*alert(data.count);*/
			    for (var i = 0; i < data.count; i++) {
			    	if (data.datas[i][0]=='') {
			    	        data.datas[i][0]="images/default_logo.png";
			            }
			    	$(".event_ul").append(
			    		'<li style="display:none;"><input type="hidden"><a class="event" onclick="javascript:enterevent('
			    		+data.datas[i][6]+
			    		');"><div class="event_logo"><img id="event_logo" src="'
			    		+data.datas[i][0]+
			    		'"></div></a><div class="event_content"><h3>'
			    		+data.datas[i][1]+
			    		'</h3><div class="event_date"><span class="icontime"></span>'
			    		+data.datas[i][2]+
			    		'</div><div class="event_address">'
			    		+data.datas[i][3]+
			    		'</div><div class="event_foot"><span class="linkman">'
			    		+data.datas[i][4]+
			    		'</span><span class="click_quantity">'
			    		+data.datas[i][5]+
			    		'</span></div></li>'
			    		);
			    }
			    $(".footer").append('<input type="hidden" id="page_counter" value='+0+'>');
			    for (var i = 0; i < Math.floor((data.count+9)/10); i++) {
			    	$(".footer").append('<li><a onclick="page('+i+');">'+(i+1)+'</a></li>');
			    }
			    page(0);
			}else if(data.state == 204){
				$(".event_ul").html('');
				$(".footer").html('');
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
}
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
function enteruser(userid) {
	$.ajax({
	type:"GET",
	url:"user_session.php",
	data:{
        userid:userid
    },
    dataType:"json",
    beforeSend: function() {
        $(".modal").show();
	},
	success:function(data){
		$(".modal").hide();
        if (data.result==0) {
        	if (data.userid==userid) {
                window.location.href="user.html";
        	}
        	else{
        		alert(data.userid);
        	}
        }
        else{
        	alert(data);
        }
	},
	error:function(xhr,msg,exc){
        alert("请求超时-"+msg);
	}
});
}