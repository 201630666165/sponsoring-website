$.ajax({
        url:"event_session.php",
        type:"GET",
        data:{activity_id:0},
        async:false,
        success:function(objsnd) {
            if (objsnd.result==0) {
                $.ajax({
                    url:"event.php",
                    type:"POST",
                    data:{activity_id:objsnd.activity_id},
                    async:false,
                    success:function(data) {
                        if (data.state==200) {
                            if (data.datas[0]!='') {
                                $("img#event_logo").attr('src',data.datas[0]);
                            }
                            $(".media-heading").html(data.datas[1]);
                            $("span#event_time").html(data.datas[2]+" ～ "+data.datas[3]);
                            $("span#event_address").html("（"+data.datas[4]+"）"+data.datas[5]);
                            var category;
                            switch(data.datas[6]){
                            case "1":
                                category="校园赞助";
                                break;
                            case "2":
                                category="慈善赞助";
                                break;
                            case "3":
                                category="体育竞技";
                                break;
                            case "4":
                                category="文化演出";
                                break;
                            case "5":
                                category="会展论坛";
                                break;
                            case "6":
                                category="影视赞助";
                                break;
                            case "7":
                                category="节庆活动";
                                break;
                            case "8":
                                category="商业活动";
                                break;  
                            case "9":
                                category="其他";
                                break;
                            default:
                                break;
                            }
                            $("span#event_category").html(category);
                            var money;
                            switch(data.datas[7]){
                            case "1":
                                money="0-5000";
                                break;
                            case "2":
                                money="5000-10000";
                                break;
                            case "3":
                                money="10000-20000";
                                break;
                            case "4":
                                money="20000-50000";
                                break;
                            case "5":
                                money="50000-10万";
                                break;
                            case "6":
                                money="10万-20万";
                                break;
                            case "7":
                                money="20万-200万";
                                break;
                            case "8":
                                money="200万以上";
                                break;
                            default:
                                break;
                            }
                            $("span#event_money").html(money);
                            $("span#event_username").html(data.datas[17]);
                            $("#user_a").click(function() {
                                enteruser(data.datas[14]);
                            });
                            $("#user_img").attr('src',data.datas[16]);
                            $("span#click_quantity").html(data.datas[9]+" 人浏览");
                            $("div#event_desc_page1").html(data.datas[10]);
                            //百度地图api
                            var map = new BMap.Map("container");
                            var point = new BMap.Point(data.datas[11],data.datas[12]);
                            map.centerAndZoom(point,12);
    
                            //创建标注
                            var marker = new BMap.Marker(point);    // 创建标注
                            map.addOverlay(marker);                 // 将标注添加到地图中
             
                            //允许缩放地图
                            map.enableScrollWheelZoom(true);
                            if (data.datas[13]!='') {
                                $("span.uploading").html('<i class="uploaded_ico word_ico" id="file_ico"></i><a download="'+findname(data.datas[13])+'" href="'+data.datas[13]+'">'+findname(data.datas[13])+'</a>');
                            }
                            else{
                                $("span.uploading").html('无');
                            }
                            $("span#event_linkman").html(data.datas[8]);
                            $("span#event_tel").html(data.datas[14]);
                            if (data.datas[15]!='') {
                                $("div.tags").html('');
                                var tags = (data.datas[15]).split(' ');
                                for (var i = 0; i < tags.length; i++) {
                                    $("div.tags").append('<a>'+tags[i]+'</a>');
                                }
                            }
                            switch((findtype(data.datas[13]).toLowerCase())){
                            case "doc":
                                break;
                            case "docx":
                                break;
                            case "pdf":
                                $("i#file_ico").css({"background-position-x":"-105px","background-position-y":"3px"});
                                break;
                            case "txt":
                                $("i#file_ico").css({"background-position-x":"-163px","background-position-y":"3px"});
                                break;
                            case "ppt":
                                $("i#file_ico").css({"background-position-x":"-55px","background-position-y":"3px"});
                                break;
                            case "pps":
                                $("i#file_ico").css({"background-position-x":"-55px","background-position-y":"3px"});
                                break;
                            case "pptx":
                                $("i#file_ico").css({"background-position-x":"-55px","background-position-y":"3px"});
                                break;
                            default:
                                break;
                            }
                        }
                        else if (data.state==204) {
                            alert(data.errormsg);
                            window.close();
                        }
                        else {
                            alert(data);
                            window.close();
                        }
                    },
                    error:function(xhr,msg,exc){
                        alert(msg);
                        window.close();
                        return false;
                    }
                });
            }
            else{
            	alert(objsnd);
                alert(objsnd.errormsg);
                window.close();
            }
        },
        error:function(xhr,msg,exc){
            alert(msg);
            window.close();
            return false;
        }
    });

function findname(str) {
    return (str.substr(21));
}
function findtype(str) {
    return (str.substr(str.lastIndexOf(".")+1));
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