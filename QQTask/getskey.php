<?php
include_once '../Core/common.php';
include_once '../Core/chaoren.class.php';
require_once '../Function/Index/qlogin.class.php';
$result = $db->query("select * from {$prefix}qqs where skeyzt='1' and (gxmsg<>'-3' or gxmsg<>'-2') order by rand() limit 5");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $stmt = $db->query("select * from {$prefix}users where uid='" . $row['uid'] . "' limit 1");
    $userrow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (get_isvip($userrow['vip'], $userrow['vipend'])) $isvip = 1;
    $uin = $row['qq'];
    $pwd = $row['pwd'];
    $time = date("Y-m-d H:i:s");
    $sub = 'QQ状态失效提醒';
    $msg = '您的QQ' . $row['qq'] . '状态已失效，且自动更新失败，请到' . C("webname") . "进行更新！" . $time;
    $data = new Qqlogin($uin, $pwd);
	$qqs = json_decode($data->json, true);
	if ($qqs['code'] == - 1) {
		$code = 1;
		if(C('chaoren_user') && C('chaoren_pwd')){
            $chaoren = new Chaorendama(C('chaoren_user'), C('chaoren_pwd'));
			$bin = getvcpic($uin, $qqs['cap_cd'], $qqs['sig'], $qqs['sess']);
			$dama_arr = $chaoren -> recv_byte(bin2hex($bin));
			$data = new Qqlogin($uin, $pwd, $dama_arr['result'], $qqs['cap_cd'], $qqs['sig'], $qqs['sess']);
			$qqs = json_decode($data->json, true);
			if ($qqs['code'] == - 1) {
				$chaoren -> report_err($dama_arr['imgId']);
				echo $uin.' Dama Error!<br/>';
				$db -> query("UPDATE {$prefix}qqs SET gxmsg='-3',nextauto='{$time}' WHERE qq='{$uin}'");
            }else{
                echo $uin . ' GetVC Error!<br/>';
                $db -> query("UPDATE {$prefix}qqs SET gxmsg='-3',nextauto='{$time}' WHERE qq='{$uin}'");
            }
        }else{
            echo $uin . ' need code<br/>';
            $db -> query("UPDATE {$prefix}qqs SET gxmsg='-2',nextauto='{$time}' WHERE qq='{$uin}'");
        }
	} elseif ($qqs['code'] == -3) {
            //其他原因
            @$db->query("UPDATE {$prefix}qqs SET gxmsg='-3',nextauto='{$time}' WHERE qq='{$uin}'");
            if (C("email_user") and C("email_host") and C("email_port") and C("email_pwd")) send_mail(C("email_user"), C("email_host"), C("email_port"), C("email_pwd"), C('webname'), $userrow['qq'] . "@qq.com", $sub, $msg);
            echo $uin . $qqs['msg'] . '<br/>';
        }
	if($qqs['skey'] && $qqs['pookie'] && $qqs['p_skey']){
		$sid = $qqs['sid'];
		$skey = $qqs['skey'];
		$p_skey = $qqs['p_skey'];
		$pookie = $qqs['pookie'];
		$set = "skey='{$skey}',gxmsg='0',nextauto='{$time}',p_skey='{$p_skey}',pookie='{$pookie}',sidzt=0,skeyzt=0";
		$db -> query("update {$prefix}qqs set {$set} where qq='{$uin}'");
		echo $uin . ' update success<br/>';
	}else{
		$db -> query("UPDATE {$prefix}qqs SET gxmsg='-3',nextauto='{$time}' WHERE qq='{$uin}'");
		if(C('email_user') && C('email_host') && C('email_port') && C('email_pwd'))send_mail(C('email_user'), C('email_host'), C('email_port'), C('email_pwd'), C('webname'), $userrow['qq'] . '@qq.com', $sub, $msg);
		echo $uin . ' update failure<br/>';
	}
    unset($qqs);
    unset($code);
}
exit('Updated completely');
function getvcpic($uin, $cap_cd, $sig, $sess){
    $url='http://captcha.qq.com/cap_union_new_getcapbysig?aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$uin.'&color=&showtype=&lang=2052&cap_cd='.$cap_cd.'&rnd='.rand(100000,999999).'&rand=0.02398118'.time().'&sess='.$sess.'&vsig='.$sig.'&ischartype=1';
    return get_curls($url);
}
function get_curls($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $httpheader[] = "Accept:application/json";
    $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
    $httpheader[] = "Connection:close";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
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
        curl_setopt($ch, CURLOPT_REFERER, "http://ptlogin2.qq.com/");
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);

    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
?>