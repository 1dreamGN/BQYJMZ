<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.qqmiaozan.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 天涯 <454701103@qq.com>
// +----------------------------------------------------------------------
// | QQ: 454701103
// +----------------------------------------------------------------------
// | 领取腾讯图书VIP礼包并使用。传入QQ SID码，输出结果并返回
// +----------------------------------------------------------------------
// | 如需修改和引用，请保留此头部信息！
// +----------------------------------------------------------------------
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

$sid = $_GET['sid'] ? urlencode($_GET['sid']) : exit('No Sid!');

$url = 'http://ebook.3g.qq.com/user/v3/normalLevel/recieveMonthGifts?sid=' . $sid . '&g_ut=2';
$data = get_curl($url, 0, $url);
// echo $data;
$url = 'http://ebook.3g.qq.com/user/usecard?sid=' . $sid . '&g_ut=2';
$data2 = get_curl($url, 0, $url);
// echo 3;exit;
if (strstr($data, "领取成功") || strstr($data, "您本月已经领取过礼包")) {
    if (strstr($data2, '使用成功')) {
        echo "<script>alert('图书VIP领取成功！');history.go(-1);</script>";
    } elseif (strstr($data2, '本月已经领取')) {
        echo "<script>alert('图书VIP领取失败，原因：本月您已领取过');history.go(-1);</script>";
    } elseif (strstr($data2, '您已经是包月VIP')) {
        echo "<script>alert('您已拥有图书VIP，不能领取');history.go(-1);</script>";
    } else {
        echo "<script>alert('本月已经领取过了，下个月再来吧！');history.go(-1);</script>";
    }
} else {
    echo "<script>alert('今日礼包已发完，明天早点来领哦。');history.go(-1);</script>";
}
?>