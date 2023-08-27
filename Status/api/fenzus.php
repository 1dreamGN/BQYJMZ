<?php
//好友移动分组2
error_reporting(0);
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

$uin = $_REQUEST['uin'] ? $_REQUEST['uin'] : exit('{"code":-1,"msg":"No Uin！"}');
$skey = $_REQUEST['skey'] ? $_REQUEST['skey'] : exit('{"code":-1,"msg":"No Skey！"}');
$p_skey = $_REQUEST['p_skey'] ? $_REQUEST['p_skey'] : exit('{"code":-1,"msg":"No p_skey"}');
$gpid = $_REQUEST['gpid'] ? $_REQUEST['gpid'] : 0;
$uins = $_REQUEST['uins'] ? $_REQUEST['uins'] : exit('{"code":-1,"msg":"No friend!"}');
$gtk = getGTK($p_skey);
$cookie = "uin=o0{$uin}; skey={$skey}; p_skey={$p_skey};";
$url = "http://user.qzone.qq.com/p/r/cgi-bin/tfriend/friend_show_qqfriends.cgi?uin={$uin}&follow_flag=0&groupface_flag=0&fupdate=1&g_tk={$gtk}&format=json";
$data = get_curl($url, 0, 1, $cookie);
$json = str_replace(array(
    '&quot;',
    '_Callback(',
    ');'
), array(
    '',
    '',
    ''
), $data);
$json = mb_convert_encoding($json, "UTF-8", "UTF-8");
$arr = json_decode($json, true);
$narr = array();
if ($arr['code'] == -99997) {
    exit('{"code":-1,"msg":"系统繁忙，请稍后重试！"}');
} elseif ($arr['code'] == -3000) {
    exit('{"code":-2,"msg":"SKEY过期请更新！"}');
} elseif ($arr['data']) {
    foreach ($arr["data"]["items"] as $row) {
        $narr["$row[uin]"] = $row;
    }
    if ($narr["$uins"]["groupid"] != $gpid) {
        $url = "http://w.cnc.qzone.qq.com/cgi-bin/tfriend/friend_chggroupid.cgi?g_tk=" . $gtk;
        $post = "qzreferrer=" . urlencode("http://cm.qzs.qq.com/qzone/v8/pages/friends/friend_msg_setting.html?mode=pass1&ouin={$uins}&id=&flag=102&key=0&time=") . "&gpid={$gpid}&ifuin={$uins}&uin={$uin}&flag=102&key=0&rd=0." . time() . "141986&remark=" . $narr["$uins"]["remark"] . "&fupdate=1&format=json";
        $json = get_curl($url, $post, "http://cm.qzs.qq.com/qzone/v8/pages/friends/friend_msg_setting.html?mode=pass1&ouin={$uins}&id=&flag=102&key=0&time=", $cookie);
    }
    exit('{"code":0,"msg":"' . $uins . $arr['code'] . '移动完成！"}');
} elseif (!array_key_exists('message', $arr)) {
    exit('{"code":-1,"msg":"网络繁忙！"}');
} else {
    exit('{"code":-1,"msg":"' . $arr['message'] . '！"}');
}

 