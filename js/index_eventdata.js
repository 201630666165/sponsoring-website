$.ajax({
	url:"index.php",
	type:"POST",
	async:false,
	success:function(objsnd) {
	    if(objsnd.state==200) {
	    	for (var i = 0; i < objsnd.counth; i++) {
	    		(function(i) {
	    			$("#hot"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.datash[i][3]);
	    		    });
	    		    if (objsnd.datash[i][0]!='') {
	    		    	$("#hot"+(i+1)+"_logo").attr('src',objsnd.datash[i][0]);
	    		    }
	    		    $("#hot"+(i+1)+"_logo").attr('alt',objsnd.datash[i][1]);
	    		    $("#hot"+(i+1)+"_title").html(objsnd.datash[i][1]);
	    		    $("#hot"+(i+1)+"_click_quantity").html(objsnd.datash[i][2]);
	    		    $("#hot"+(i+1)+"_favorite_quantity").html(objsnd.datash[i][4]);
	    		})(i);
	    	}
	    	for (var i = 0; i < objsnd.countn; i++) {
	    		(function(i) {
	    			$("#new"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.datasn[i][3]);
	    		    });
	    		    if (objsnd.datasn[i][0]!='') {
	    		    	$("#new"+(i+1)+"_logo").attr('src',objsnd.datasn[i][0]);
	    		    }
	    		    $("#new"+(i+1)+"_logo").attr('alt',objsnd.datasn[i][1]);
	    		    $("#new"+(i+1)+"_title").html(objsnd.datasn[i][1]);
	    		    $("#new"+(i+1)+"_date").html(objsnd.datasn[i][2]);
	    		})(i);
	    	}
	    	for (var i = 0; i < objsnd.counto&&i<4; i++) {
	    		(function(i) {
	    			$("#out"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.dataso[i][4]);
	    		    });
	    		    $("#out"+(i+1)+"_a").attr('title',objsnd.dataso[i][1]);
	    		    if (objsnd.dataso[i][0]!='') {
	    		    	$("#out"+(i+1)+"_logo").attr('src',objsnd.dataso[i][0]);
	    		    }
	    		    $("#out"+(i+1)+"_logo").attr('alt',objsnd.dataso[i][1]);
	    		})(i);
	    	}
	    	for (var i = 4; i < objsnd.counto&&i>=4; i++) {
	    		(function(i) {
	    			$("#out"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.dataso[i][4]);
	    		    });
	    		    $("#out"+(i+1)+"_a").attr('title',objsnd.dataso[i][1]);
	    		    $("#out"+(i+1)+"_title").html(objsnd.dataso[i][1]);
	    		    $("#out"+(i+1)+"_intro").html(objsnd.dataso[i][3].substr(0,200));
	    		})(i);
	    	}
	    	for (var i = 0; i < objsnd.countc; i++) {
	    		(function(i) {
	    			$("#cover"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.datasc[i][2]);
	    		    });
	    		    if (objsnd.datasc[i][0]!='') {
	    		    	$("#cover"+(i+1)+"_logo").attr('src',objsnd.datasc[i][0]);
	    		    }
	    		    $("#cover"+(i+1)+"_logo").attr('title',objsnd.datasc[i][1]);
	    		    $("#cover"+(i+1)+"_logo").attr('alt',objsnd.datasc[i][1]);
	    		})(i);
	    	}
	    	for (var i = 0; i < objsnd.countf; i++) {
	    		(function(i) {
	    			$("#fav"+(i+1)+"_a").click(function() {
	    			    enterevent(objsnd.datasf[i][3]);
	    		    });
	    		    if (objsnd.datasf[i][0]!='') {
	    		    	$("#fav"+(i+1)+"_logo").attr('src',objsnd.datasf[i][0]);
	    		    }
	    		    $("#fav"+(i+1)+"_logo").attr('alt',objsnd.datasf[i][1]);
	    		    $("#fav"+(i+1)+"_title").html(objsnd.datasf[i][1]);
	    		    $("#fav"+(i+1)+"_click_quantity").html(objsnd.datasf[i][2]);
	    		    $("#fav"+(i+1)+"_favorite_quantity").html(objsnd.datasf[i][4]);
	    		})(i);
	    	}
	    	for (var i = 0; i < objsnd.counta; i++) {
	    		(function(i) {
	    			$("#ass"+(i+1)+"_a").click(function() {
	    			    enteruser(objsnd.datasa[i][4]);
	    		    });
	    		    $("#ass"+(i+1)+"_a").attr('title',objsnd.datasa[i][1]);
	    		    if (objsnd.datasa[i][3]!='') {
	    		        $("#ass"+(i+1)+"_img").attr('src',objsnd.datasa[i][3]);
	    		    }
	    		    $("#ass"+(i+1)+"_img").attr('alt',objsnd.datasa[i][1]);
	    		    $("#ass"+(i+1)+"_title").html(objsnd.datasa[i][1]);
	    		    $("#ass"+(i+1)+"_intro").html(objsnd.datasa[i][2].substr(0,200));
	    		    $("#ass"+(i+1)+"_span").html(objsnd.datasa[i][0]+'&nbsp;个活动');
	    		})(i);//修改个人中心进入机制
	    	}
	    }
	    else if (objsnd.state==204) {
	    	alert(objsnd.errormsg);
	    }
	    else{
	    	alert("请求出错");
	    	alert(objsnd);
	    }
    },
    error:function(xhr,msg,exc){
	    alert("请求超时-"+msg);
	}
});
function enterevent(activity_id) {//转移自event-list.js
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