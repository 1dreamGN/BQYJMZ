function getqrpic() {
	var getvcurl = '/Status/qrlogin/login.php?do=getqrpic&r=' + Math.random(1);
	$.get(getvcurl, function (d) {
		if (d.saveOK == 0) {
			$('#qrimg').attr('qrsig', d.qrsig);
			$('#qrimg').html('<img onclick="getqrpic()" src="data:image/png;base64,' + d.data + '" title="点击刷新">');
		} else {
			alert(d.msg);
		}
	});
}
function ptuiCB(code, uin, sid, skey, pskey, nick) {
	var msg = '请扫描二维码';
	switch (code) {
	case '0':
		$('#login').html('<div class="alert alert-success">验证成功！' + decodeURIComponent(nick) + '</div><a href="/find.php?do=qrfind&uin=' + decodeURIComponent(uin) + '&skey=' + decodeURIComponent(skey) + '&pskey=' + decodeURIComponent(pskey) + '" class="btn btn-effect-ripple btn-sm btn-danger btn-block" style="overflow: hidden; position: relative;">点击重置密码</a>');
		$('#qrimg').hide();
		$('#submit').hide();
		$('#login').attr("data-lock", "true");
		break;
	case '1':
		getqrpic();
		msg = '请重新扫描二维码';
		break;
	case '2':
		msg = '使用QQ手机版扫描二维码';
		break;
	case '3':
		msg = '扫描成功，请在手机上确认授权登录';
		break;
	default:
		msg = sid;
		break;
	}
	$('#loginmsg').html(msg);
}
function loadScript(c) {
	if ($('#login').attr("data-lock") === "true")
		return;
	var qrsig = $('#qrimg').attr('qrsig');
	c = c || "/Status/qrlogin/login.php?do=qqlogin&qrsig=" + decodeURIComponent(qrsig) + "&r=" + Math.random(1);
	var a = document.createElement("script");
	a.onload = a.onreadystatechange = function () {
		if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
			if (typeof d == "function") {
				d()
			}
			a.onload = a.onreadystatechange = null;
			if (a.parentNode) {
				a.parentNode.removeChild(a)
			}
		}
	};
	a.src = c;
	document.getElementsByTagName("head")[0].appendChild(a)
}
function loginload() {
	if ($('#login').attr("data-lock") === "true")
		return;
	var load = document.getElementById('loginload').innerHTML;
	var len = load.length;
	if (len > 2) {
		load = '.';
	} else {
		load += '.';
	}
	document.getElementById('loginload').innerHTML = load;
}
$(document).ready(function () {
	getqrpic();
	$('#submit').click(function () {
		loadScript();
	});
	window.setInterval(loginload, 1000);
	window.setInterval(loadScript, 3000);
});
