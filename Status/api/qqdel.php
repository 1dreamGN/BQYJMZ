<?php
//好友移动分组3
error_reporting(0);
$uin = isset($_GET['uin']) ? $_GET['uin'] : exit('No Uin!');
$skey = isset($_GET['skey']) ? $_GET['skey'] : exit('No Skey!');
$touin = isset($_GET['touin']) ? $_GET['touin'] : exit('No Touin!');
$p_skey = isset($_GET['p_skey']) ? $_GET['p_skey'] : exit('No p_skey!');

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
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        if ($referer == 1) {
            curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

function getGTK($skey)
{
    $len = strlen($skey);
    $hash = 5381;
    for ($i = 0; $i < $len; $i++) {
        $hash += ((($hash << 5) & 0x7fffffff) + ord($skey[$i])) & 0x7fffffff;
        $hash &= 0x7fffffff;
    }
    return $hash & 0x7fffffff; //计算g_tk
}

$gtk = getGTK($p_skey);
$cookie = "uin=o0{$uin}; skey={$skey}; p_skey={$p_skey};";

$url = 'http://w.cnc.qzone.qq.com/cgi-bin/tfriend/friend_delete_qqfriend.cgi?g_tk=' . $gtk;
$post = "uin={$uin}&fupdate=1&num=1&fuin={$touin}&format=json&qzreferrer=http://user.qzone.qq.com/{$uin}/myhome/friends";
$json = get_curl($url, $post, 'http://user.qzone.qq.com/' . $uin . '/myhome/friends', $cookie);
$arr = json_decode($json, true);
if ($arr['code'] == 0) {
    exit("<font color='green'>成功</font>");
} elseif ($arr['code'] == -3000) {
    exit("<font color='red'>Skey过期</font>");
} else {
    exit("<font color='red'>{$arr[message]}</font>");
}
 