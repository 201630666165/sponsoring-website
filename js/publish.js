$.ajax({
	url:"session.php",
	type:"GET",
	data:{association_name:0,id:0},
	async:false,
	success:function(objsnd) {
	    if(objsnd.result==0) {
	    	if (objsnd.association_name.length>4) {
	    		$("#hello").html("<a>"+objsnd.association_name.substr(0,3)+"…</a><b> | </b><a id='logoff'>注销</a>");
	    	}
	    	else{
	    		$("#hello").html("<a>"+objsnd.association_name+"</a><b> | </b><a id='logoff'>注销</a>");
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