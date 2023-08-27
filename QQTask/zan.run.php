<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and (iszan>0) and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uid = $row['uid'];
	$result2 = $db->query("SELECT * FROM {$prefix}users where uid='{$uid}' limit 1");
	$result2 = $result2->fetch(PDO::FETCH_ASSOC);
	if (!get_isvip($result2[vip], $result2[vipend])) {
		exit('success');
	}
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$now = date("Y-m-d-H:i:s");
	$db->query("update {$prefix}qqs set lastzan='$now',nextzan='$now' where qid='$qid'");
	include_once "qzone.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
		if ($row['iszan'] == '2') {
			$qzone->like('2');
		} else {
			$qzone->like('0');
			//$qzone->like(0);
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