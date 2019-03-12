$.ajax({
		url:"sr_session.php",
		type:"GET",
		data:{
			sremsg:0,
			sromsg:0
		},
		async:false,
		beforeSend: function() {
            $(".modal").show();
		},
		success:function(data) {
			$(".modal").hide();
			var sromsg = data.sromsg;
			//创建成功
			if (data.result == 0)
			{
                $.ajax({
                	url:"sro.php",
                	type:"POST",
                	data:{
                		sromsg:sromsg
                	},
                	async:false,
                	beforeSend: function() {
                        $(".modal").show();
		            },
                	success:function(data) {
                		$(".modal").hide();
                		if (data.state==200) {
                		    $(".event_ul").html('');
				            $(".footer").html('');
				            $("span#count").html(data.count);
			                /*alert(data.count);*/
			                for (var i = 0; i < data.count; i++) {
			    	            if (data.datas[i][0]=='') {
			    	                    data.datas[i][0]="images/default_org_logo.png";
			                        }
			    	            $(".event_ul").append(
			    		            '<li style="display:none;"><a class="event" onclick="javascript:enteruser('
			    		            +data.datas[i][3]+
			    		            ');"><div class="event_logo"><img id="event_logo" src="'
			    		            +data.datas[i][0]+
			    		            '"></div></a><div class="event_content"><h3>'
			    		            +data.datas[i][1]+
			    		            '</h3><div class="event_date"><span class="icontime"></span>'
			    		            +data.datas[i][4]+
			    		            '</div><div class="event_address"><span class="iconplace"></span>'
			    		            +//data.datas[i][3]+
			    		            '</div><div class="event_foot"><img class="iconface" src="images/default_face.png"><span class="linkman">'
			    		            +data.datas[i][2]+
			    		            '</span><span class="click_quantity">'
			    		            +//data.datas[i][5]+
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
			else if(data.state == 1){
                alert("请用正常渠道进入本页！");
                window.location.href='index.html';
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