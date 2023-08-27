<?php
error_reporting(0);
function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1");
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

@header("Content-Type: text/html; charset=UTF-8");
$domain = $_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_REFERER']!="http://{$domain}/Function/Index/qqmusic.php")exit("Error".$_SERVER['HTTP_REFERER']);
include_once "../../Core/authcode.php";
define('authcode', $authcode);
if ($_GET['type'] == "music") {
    $qq = $_POST['qq'];
    if (!$qq) {
        exit('{"code":-1,"msg":"QQ不能为空"}');
    } else {
        $data = get_curl("http://api.qq-admin.cn/?mod=QQMusicJs&qq=" . $qq);
        exit('{"code":1,"msg":"加速成功咯，建议您手动打开QQ音乐保证正常到账"}');
    }
}
?>
