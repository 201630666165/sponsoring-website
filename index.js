$.ajax({
	url:"session.php",
	type:"GET",
	data:{association_name:0,id:0},
	async:false,
	success:function(objsnd) {
	    if(objsnd.result==0) {
	    	if (objsnd.association_name.length>4) {
	    		$("#hello").html("<a onclick='enteruser("+objsnd._id+")'>"+objsnd.association_name.substr(0,3)+"…</a><b> | </b><a id='logoff'>注销</a>");
	    	}
	    	else{
	    		$("#hello").html("<a onclick='enteruser("+objsnd._id+")'>"+objsnd.association_name+"</a><b> | </b><a id='logoff'>注销</a>");
	    	}
	    	$("input#sessionid").val(objsnd._id);
	    }
	    else if (objsnd.result==1) {
	    }
	    else{
	    	alert("请求出错");
	    }
    },
    error:function(xhr,msg,exc){
	    alert("请求超时-"+msg);
	}
});
$("a#logoff").click(function () {
	$.post("session_destroy.php");
	window.location.href='login.html';
});
$("#searchEventArea form button").click(function() {
	var sremsg = $("#mainSearchTextbox1").val();
	if (sremsg=="") {return;}
	$.ajax({
		url:"sr_session.php",
		type:"GET",
		data:{
			sremsg:sremsg,
			sromsg:0
		},
		async:false,
		success:function(objsnd) {
	        if(objsnd.result==0) {
	    	    window.open("sre.html");
	        }
	        else if (objsnd.result==1) {
	        	window.location.href="index.html";
	        }
	        else{
	    	    alert("请求出错");
	        }
        },
        error:function(xhr,msg,exc){
	        alert("请求超时-"+msg);
	    }
	});
});
$("#searchSponsorArea form button").click(function() {
	
});
$("#searchOrgArea form button").click(function() {
	var sromsg = $("#mainSearchTextbox3").val();
	if (sromsg=="") {return;}
	$.ajax({
		url:"sr_session.php",
		type:"GET",
		data:{
			sremsg:0,
			sromsg:sromsg
		},
		async:false,
		success:function(objsnd) {
	        if(objsnd.result==0) {
	    	    window.open("sro.html");
	        }
	        else if (objsnd.result==1) {
	        	window.location.href="index.html";
	        }
	        else{
	    	    alert("请求出错");
	        }
        },
        error:function(xhr,msg,exc){
	        alert("请求超时-"+msg);
	    }
	});
});
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