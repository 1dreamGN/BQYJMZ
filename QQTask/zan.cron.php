<?php
include_once "conn.php";
$n = isset($_GET['n']) ? $_GET['n'] : exit('No Net!');
$nurl = str_replace('zan.cron.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$look = $_GET['get'] ? '&get=1' : '';
$now = date("Y-m-d-H:i:s");
$result = $db->query("SELECT qid FROM {$prefix}qqs where zannet='$n' and iszan>0 and (nextzan<'$now' or nextzan IS NULL) and skeyzt=0");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$urls[] = "{$nurl}zan.run.php?cron=" . $_GET['cron'] . "&qid={$row['qid']}{$look}";
}
if ($urls) {
	$get = duo_curl($urls);
}
if ($_GET['get'] == 1) {
	print_r($get);
}
exit('success');
?>