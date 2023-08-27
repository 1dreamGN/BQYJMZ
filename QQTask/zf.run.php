<?php
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' and (iszf>0) and skeyzt=0 limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$uin = $row['qq'];
	$sid = $row['sid'];
	$skey = $row['skey'];
	$p_skey = $row['p_skey'];
	$pookie = $row['pookie'];
	$now = date("Y-m-d-H:i:s");
	$next = date("Y-m-d H:i:s", time() + 60 * $row['replyrate'] - 10);
	$db->query("update {$prefix}qqs set lastzf='$now',nextzf='$next' where qid='$qid'");
	include_once "qzone.class.php";
	$qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
        $uins=explode(',',$row['zfok']);
        if ($row['iszf'] == 2) {
            $qzone->zhuanfa(2, $uins, get_con($row['zfcon']));
        } else {
            $qzone->zhuanfa(0, $uins, get_con($row['zfcon']));
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