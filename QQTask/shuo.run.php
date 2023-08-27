<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and isshuo>0 and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uid = $row['uid'];
	$result2 = $db->query("SELECT * FROM {$prefix}users where uid='{$uid}' limit 1");
	$result2 = $result2->fetch(PDO::FETCH_ASSOC);
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$do = $row['isshuo'];
	$now = date("Y-m-d-H:i:s");
	$next = date("Y-m-d H:i:s", time() + (60 * $row['shuorate']) - 10);
	$db->query("update {$prefix}qqs set lastshuo='$now',nextshuo='$next' where qid='$qid'");
	$gg = $row['shuogg'];
	if (get_isvip($result2[vip], $result2[vipend])) {
		$con = get_con($row['shuoshuo']). $gg;
	} else {
		$con = get_con($row['shuoshuo']). C('shuogg');
	}
	$pic = $row['shuopic'];
	if ($pic == '[图片]') {
		$row = file('../Status/data/pic.txt');
		shuffle($row);
		$pic = $row[0];
		$type = 0;
	} else {
		$type = stripos('z' . urlencode($pic), 'http') ? 0 : 1;
	}
	$pic = trim($pic);
	include_once "qqtool.class.php";
	echo $pic;
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
	if ($do == 2) {
		$qzone->shuo('pc', $con, $pic);
	} else {
		$qzone->shuo(0, $con, $pic);
	}
	foreach ($qzone->msg as $result) {
		echo $result . '<br/>';
	}
	include_once "autoclass.php";
	exit('success');
} else {
	exit('failure');
}
?>