<?php
include_once "conn.php";
$time = time();
$date = date("Y-m-d H:i:s");
$sysid = isset($_GET['sys']) ? $_GET['sys'] : 1;
$infoid = $sysid + 500;
$seconds = C("seconds");//秒刷 有限
$loop = C("loop");//秒刷 无限
C('runmodol', "0");//多线程
$selfname = 'QQTask/wztask.php';
$size = C('interval') ? C('interval') : 60;
if (isset($_GET['multi'])) {
    $start = intval($_GET['start']);
    $num = intval($_GET['num']);
    $rs = $db->query("select * from {$prefix}wzjob where sysid={$sysid} and zt=0 and nexttime<={$time} order by nexttime asc limit {$start},{$num}");
} elseif (C('runmodol') == 0) {
    $nump = get_count('wzjob', "sysid=:sysid and zt=:zt and nexttime<=:time", '*', array(":sysid" => $sysid, ":zt" => "0", ":time" => $time));
    $xz = ceil($nump / $size);
    if ($xz > 1) {
        for ($i = 0; $i <= $xz; $i++) {
            $start = $i * $size;
            curl_run($domain . $selfname . '?cron=' . $_GET['cron'] . '&sys=' . $sysid . '&multi=on&start=' . $start . '&num=' . $size);
        }
        exit("Successful opening of {$xz} threads!");
    } else {
        $rs = $db->query("select * from " . $prefix . "wzjob where sysid={$sysid} and zt=0 and nexttime<={$time} order by nexttime asc");
    }
} else {
    $nump = get_count('wzjob', "sysid=:sysid and zt=:zt and nexttime<=:time", '*', array(":sysid" => $sysid, ":zt" => "0", ":time" => $time));
    $xz = curl_run($nump / $size);
    $shu = $db->prepare("select * from {$prefix}info where sysid=:sysid limit 1");
    $shu->execute(array(':sysid' => $infoid));
    $shu = $shu->fetch(PDO::FETCH_ASSOC);
    $shu = $shu['times'];
    $up_shu = $shu + 1;
    if ($shu >= $xz) {
        $db->query("update {$prefix}info set times='1' where sysid='{$infoid}'");
        $shu = 0;
    } else {
        $db->query("update {$prefix}info set times='" . $up_shu . "' where sysid='{$infoid}'");
    }
    $shu = $shu * $size;
    $rs = $db->query("select * from {$prefix}wzjob where sysid={$sysid} and zt=0 and nexttime<={$time} order by nexttime asc limit {$shu},{$size}");
}
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['jobid'];
    $day = date("Ymd");
    if ($row['day'] != $day) {
        $db->query("update {$prefix}wzjob set day='{$day}' where jobid='{$id}'");
    }
    if ($seconds > 1) {
        for ($i = 1; $i <= $seconds; $i++) {
            $sd=run_once($row, 1, 1);
        }
    } else {
        $sd=run_once($row, 1, 5);
    }
	echo $sd;
    if ($row['pl'] < 30) {
        $interval = 30;
    } else {
        $interval = $row['pl'];
    }
    if ($row['start'] > $t) {
        $nexttime = strtotime('+' . ($row['start'] - $t) . ' hours');
    } elseif ($row['stop'] < $t) {
        $nexttime = strtotime('+' . (24 - $row['stop'] + $row['start']) . ' hours');
    } else {
        $nexttime = $time + $interval;
    }
    $db->query("update {$prefix}wzjob set times=times+1,lasttime='{$time}',nexttime='{$nexttime}',result='' where jobid='{$id}'");
}
$db->query("update {$prefix}info set last='{$date}' where sysid='{$infoid}'");
$db->query("update {$prefix}info set times=times+1,last='{$date}' where sysid='0'");
echo "<head><title>success in run</title></head>";
echo $date;
if ($loop == 1 && $seconds == 0 && !isset($_GET['multi'])) {
    dojob();
}