<?php
include_once "conn.php";
$nurl = str_replace('qbqd.cron.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$look = $_GET['get'] ? '&get=1' : '';
$now = date("Y-m-d-H:i:s");
$result = $db->query("SELECT qid FROM {$prefix}qqs where isqb>0 and sidzt=0");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$urls[] = "{$nurl}qbqd.run.php?cron=" . $_GET['cron'] . "&qid={$row['qid']}{$look}";
}
if ($urls) {
	$get = duo_curl($urls);
}
if ($_GET['get'] == 1) {
	print_r($get);
}
exit('success');
?>