<?php
include_once "conn.php";
$n = isset($_GET['n']) ? $_GET['n'] : exit('No Net!');
$nurl = str_replace('shuo.cron.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$look = $_GET['get'] ? '&get=1' : '';
$now = date("Y-m-d-H:i:s");
$result = $db->query("SELECT qid FROM {$prefix}qqs where shuonet='$n' and isshuo>0 and (nextshuo<'$now' or nextshuo IS NULL) and skeyzt=0");
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$urls[] = "{$nurl}shuo.run.php?cron=" . $_GET['cron'] . "&qid={$row['qid']}{$look}";
}
if ($urls) {
	$get = duo_curl($urls);
}
if ($_GET['get'] == 1) {
	print_r($get);
}
exit('success');
?>