<?php
//好友移动分组1
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8');
@ignore_user_abort(true);
@set_time_limit(0);
$uin = $_REQUEST['uin'] ? $_REQUEST['uin'] : exit('{"code":-10,"msg":"No Uin！"}');
$skey = $_REQUEST['skey'] ? $_REQUEST['skey'] : exit('{"code":-1,"msg":"No Skey！"}');
$p_skey = $_REQUEST['p_skey'] ? $_REQUEST['p_skey'] : exit('{"code":-1,"msg":"No p_skey"}');
$gpid = $_REQUEST['gpid'] ? $_REQUEST['gpid'] : 0;
$touin = $_REQUEST['touin'] ? $_REQUEST['touin'] : exit('{"code":-1,"msg":"请先选择好友!"}');
exit(get_curl("http://{$_SERVER['HTTP_HOST']}/Status/api/fenzus.php", "uin={$uin}&skey={$skey}&p_skey={$p_skey}&gpid={$gpid}&uins={$touin}"));

function get_curl($url, $post = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
} 