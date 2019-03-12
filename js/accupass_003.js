var defaultQrpath = 'http://weixin.qq.com/r/snSSitPEf44ArZfp9yGg';  //默认易赞助公众号二维码

function isWxBrowser() { var ua = navigator.userAgent.toLowerCase(); return (/micromessenger/.test(ua)) ? true : false; }

function isNotNull(v) { return v != undefined && v != null && $.trim(v) != ""; }

function getQrPath(tid) {
    if (isNotNull(tid)) {
        var qrcode = tid;

        $.ajax({
            type: "POST",
            url: "/weixin/qrpath",
            data: { "qrcode": qrcode },
            success: function (data) {
                if (data != null && data.AjaxErrStatus != null && data.AjaxErrStatus == 1) {
                    initQrPathImg(defaultQrpath);
                }
                else {
                    initQrPathImg(data);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                initQrPathImg(defaultQrpath);
            }
        });
    }
}

function initQrPathImg(qrpath) {
    var src = '';
    var onerror = '';
    if (qrpath == defaultQrpath) {
        src = 'http://s.jiathis.com/qrcode.php?url=' + qrpath;
        onerror = 'javascript:this.onerror=null;this.src=http://qr.liantu.com/api.php?w=100&m=0&text=' + qrpath;
    }
    else {
        src = qrpath;
    }
    if (isWxBrowser()) {
        var img = "<img style='width:160px;;height:160px;position: absolute;left: 94px;top: 223px;' src='" + src + "' onerror='" + onerror + ";'/>";
    }
    else {
        var img = "<img style='width:100px;;height:100px;position: absolute;left: 72px;top: 84px;' src='" + src + "' onerror='" + onerror + ";'/>";
    }
    $("#qrcode_area").html(img);
}