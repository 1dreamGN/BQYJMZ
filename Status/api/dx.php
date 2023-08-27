<?php
//单项检测
function getGTK($skey)
{
    $len = strlen($skey);
    $hash = 5381;
    for ($i = 0; $i < $len; $i++) {
        $hash += ($hash << 5) + ord($skey[$i]);
    }
    return $hash & 0x7fffffff;//计算g_tk
}

function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    //echo '左边:'.$left;
    $right = strpos($str, $rightStr, $left);
    //echo '<br>右边:'.$right;
    if ($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}

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
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$uin = $_REQUEST['uin'];
$skey = $_REQUEST['skey'];
$p_skey = $_REQUEST['p_skey'];
$gtk = getGTK($skey);
$url = "http://mobile.qzone.qq.com/friend/mfriend_list?g_tk=" . $gtk . "&res_uin=" . $uin . "&res_type=normal&format=json&count_per_page=10&page_index=0&page_type=0&mayknowuin=&qqmailstat=";
$json = get_curl($url, 0, 'http://m.qzone.com/infocenter?g_ut=3&g_f=6676', 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . ';');
$json = mb_convert_encoding($json, "UTF-8", "UTF-8");
$arr = json_decode($json, true);
if ($arr['code'] == -3000) {
    exit('{"code":-1,"msg":"SID过期！"}');
}
$hycount = count($arr['data']['list']);
$dxrow[code] = 0;
$dxrow[msg] = 'suc';
$n = 1;
$i = 0;
foreach ($arr['data']['list'] as $row) {
    $touin = $row[uin];
    $i++;
    if (!isset($_SESSION["o" . $uin]["$touin"])) {
        $url = "http://social.show.qq.com/cgi-bin/qqshow_camera_noname?g_tk=" . $gtk;
        $post = "uin=" . $touin . "%7C" . $uin . "&friend=1";
        $json = get_curl($url, $post, $url, 'uin=o0' . $uin . '; skey=' . $skey . '; p_skey=' . $p_skey . ';');
        $code = getSubstr($json, 'friend="1" xfriend="', '"></node>');
        $_SESSION['o' . $uin]["$touin"] = "2016-3-16";
        if ($code == 0) {
            $dxrow[dxrow][] = $row;
            $_SESSION['bqyj_dxrow']["$uin"][] = $row;
        }
        $n++;
    }
    if ($n > 10) break;
}
if ($i == $hycount) {
    $dxrow['finish'] = 1;
} else {
    $dxrow['finish'] = 0;
}
$dxrow['count'] = $i;
$dxrow['dxcount'] = count($_SESSION['bqyj_dxrow']["$uin"]);
exit(json_encode($dxrow));


 