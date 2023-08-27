<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and isdell>0 and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$do = $row['isdel'];
	$now = date("Y-m-d-H:i:s");
	$next = date("Y-m-d H:i:s", time() + 60 * 3 - 10);
	$db->query("update {$prefix}qqs set lastdell='$now',nextdell='$next' where qid='$qid'");
	include_once "qzone.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
	if ($do == 2) {
		$qzone->delll('pc');
	} else {
		$qzone->delll();
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
