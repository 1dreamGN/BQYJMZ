<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and istx>0 and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$now = date("Y-m-d-H:i:s");
	$sql = '';
	if ($row['istx']) $sql.= "lasttx='$now'";
	@$db->query("update {$prefix}qqs set {$sql} where qid='$qid'");
	include_once "qqtool.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
	if ($row['istx']) {
		$qzone->tx();
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