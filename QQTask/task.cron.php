<?php
include_once "conn.php";

$nurl = str_replace('task.cron.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
if(isset($_GET['n']))$look = $_GET['get'] ? '&get=1' : '';
$now = date("Y-m-d-H:i:s");
$job = array("qt","wyqd","vipqd","pf","tx","qipao","qd","ht","qqd","blqd","dldqd","3gqq","del","dell","qzoneqd");
while($jobs=each($job)){
$result = $db->query("SELECT qid FROM {$prefix}qqs where is".$jobs['value'].">0 and (next".$jobs['value']."<'$now' or next".$jobs['value']." IS NULL) and skeyzt=0");
if($result){
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$urls[] = $nurl.$jobs['value'].".run.php?cron=" . $_GET['cron'] . "&qid={$row['qid']}{$look}";
	}
}

}
if ($urls)$get = duo_curl($urls);
exit('success');
