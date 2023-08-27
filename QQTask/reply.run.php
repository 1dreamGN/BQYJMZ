<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and (isreply>0) and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$type = $row['istype'];
	$zanlist = $row['zanlist'];
	$pookie = $row['pookie'];
	$now = date("Y-m-d-H:i:s");
	$next = date("Y-m-d H:i:s", time() + 60 * $row['replyrate'] - 10);
	$sql = '';
	if ($row['isreply']) $sql.= "lastreply='$now',";
	$db->query("update {$prefix}qqs set {$sql}nextreply='$next' where qid='$qid'");
	include_once "qzone.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
	$con = get_con($row['replycon']);
	if ($row['isreply']) {
		if ($row['isreply'] == 2) {
			$richval = 0;
			$qzone->reply('pc', $con, $richval);
		} else {
			$qzone->reply(0, $con, $uin, $cellid, $appid, $param);
		}
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