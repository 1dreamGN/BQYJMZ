<?php
//秒赞检测
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8');
@ignore_user_abort(true);
@set_time_limit(0);
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

function getGTK($skey)
{
    $len = strlen($skey);
    $hash = 5381;
    for ($i = 0; $i < $len; $i++) {
        $hash += ($hash << 5) + ord($skey[$i]);
    }
    return $hash & 0x7fffffff;//计算g_tk
}

$qq = $_GET['qq'];
$skey = $_GET['skey'];
$p_skey = $_GET['p_skey'];
$count = 4; //获取说说的条数

$gtk = getGTK($skey);
$cookie = "uin=o0" . $qq . "; skey=" . $skey . ";" . $p_skey;

$url = 'http://m.qzone.com/friend/mfriend_list?g_tk=' . $gtk . '&res_uin=' . $qq . '&res_type=normal&format=json&count_per_page=10&page_index=0&page_type=0&mayknowuin=&qqmailstat=';
$json = get_curl($url, 0, 0, $cookie);
$json = mb_convert_encoding($json, "UTF-8", "UTF-8");
$arr = json_decode($json, true);

if (!$arr) {
    exit('{"code":-1,"msg":"好友列表获取失败！"}');
} elseif ($arr["code"] == -3000) {
    exit('{"code":-1,"msg":"SKEY已失效！"}');
}
$friend = $arr["data"]["list"];
$gpnames = $arr["data"]["gpnames"];
foreach ($gpnames as $gprow) {
    $gpid = $gprow['gpid'];
    $gpname[$gpid] = $gprow['gpname'];
}
$cookie = 'pt2gguin=o0' . $qq . '; uin=o0' . $qq . '; skey=' . $skey . '; p_skey=' . $p_skey . '; p_uin=o0' . $qq . ';';
$url = 'http://sh.taotao.qq.com/cgi-bin/emotion_cgi_feedlist_v6?hostUin=' . $qq . '&ftype=0&sort=0&pos=0&num=4&replynum=0&code_version=1&format=json&need_private_comment=1&g_tk=' . $gtk;
$data = get_curl($url, 0, 0, $cookie);
$arr = json_decode($data, true);
$qqrow = array();
$qquins = array();
if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
    foreach ($arr['msglist'] as $k => $row) {
        $url = 'http://users.cnc.qzone.qq.com/cgi-bin/likes/get_like_list_app?uin=' . $qq . '&unikey=' . urlencode($row['key1']) . '&begin_uin=0&query_count=200&if_first_page=1&g_tk=' . $gtk;
        $data2 = get_curl($url, 0, 0, $cookie);
        if (!$data2) exit('{"code":-1,"msg":"获取失败！SKEY已失效"}');
        $json = str_replace(array('&quot;', '_Callback(', ');'), array('', '', ''), $data2);
        $json = mb_convert_encoding($json, "UTF-8", "UTF-8");
        $arr = json_decode($json, true);
        $data2 = $arr['data']['like_uin_info'];
        foreach ($data2 as $row2) {
            $fuin = $row2['fuin'];
            if (isset($qqrow["$fuin"])) {
                $qqrow["$fuin"] = $qqrow["$fuin"] + 1;
            } else {
                $qqrow["$fuin"] = 1;
                $uins[] = $fuin;
            }
        }
        $n++;
        if ($n > 9) break;
    }
} else {
    exit('{"code":-1,"msg":"获取失败！' . $arr['message'] . '"}');
}
$result['code'] = 0;
$result['msg'] = 'suc';
$result['mzcount'] = count($qqrow);
$result['uins'] = $qquins;
$result['gpnames'] = $gpnames;
foreach ($friend as $row3) {
    $fuin = $row3['uin'];
    if (isset($qqrow["$fuin"])) {
        $list['mz'] = $qqrow["$fuin"];
    } else {
        $list['mz'] = 0;
    }
    $list['uin'] = $row3['uin'];
    $list['nick'] = $row3['nick'];
    if ($row3['remark']) $list['remark'] = $row3['remark'];
    else $list['remark'] = $row3['nick'];
    $result['friend'][] = $list;
    unset($list);
}
rsort($result['friend']);
$json = json_encode($result, true);
exit($json);
?>