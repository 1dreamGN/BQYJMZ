<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and iswyqd>0 and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$do = $row['isshuo'];
	$now = date("Y-m-d-H:i:s");
	$next = date("Y-m-d H:i:s", time() + 60 * 8 * 10 - 10);
	@$db->query("update {$prefix}qqs set lastwyqd='$now',nextwyqd='$next' where qid='$qid'");
	include_once "qqtool.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
	$qzone->wyqd();
	foreach ($qzone->msg as $result) {
		echo $result . '<br/>';
	}
	include_once "autoclass.php";
	exit('success');
} else {
	exit('failure');
}
?>