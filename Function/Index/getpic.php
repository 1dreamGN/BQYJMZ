<?php
error_reporting(0);
$uin = empty($_GET['uin']) ? exit('{"saveOK":-1,"msg":"uin不能为空"}') : $_GET['uin'];
$cap_cd = empty($_GET['cap_cd']) ? exit('{"saveOK":-1,"msg":"cap_cd不能为空"}') : $_GET['cap_cd'];
$sig = empty($_GET['sig']) ? exit('{"saveOK":-1,"msg":"sig不能为空"}') : $_GET['sig'];
$sess = empty($_GET['sess']) ? exit('{"saveOK":-1,"msg":"sess不能为空"}') : $_GET['sess'];
header('content-type:image/jpeg');
$url='http://captcha.qq.com/cap_union_new_getcapbysig?aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$uin.'&color=&showtype=&lang=2052&cap_cd='.$cap_cd.'&rnd='.rand(100000,999999).'&rand=0.02398118'.time().'&sess='.$sess.'&vsig='.$sig.'&ischartype=1';
echo get_curl($url);
function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if ($referer) {
		curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
	} else {
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; MI 4C Build/KTU84P) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.4 TBS/025469 Mobile Safari/533.1 V1_AND_SQ_5.9.1_272_YYB_D QQ/5.9.1.2535 NetType/WIFI WebP/0.3.0 Pixel/1080');
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1); //主要头部
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
