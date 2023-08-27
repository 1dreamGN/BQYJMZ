<?php
error_reporting(0);
@date_default_timezone_set('PRC');
@header('Content-Type: text/html; charset=UTF-8');
@ignore_user_abort(true);
@set_time_limit(0);

include_once "function.php";
$mysql = (require "../Core/database.php");

try {
    $db = new PDO("mysql:host=" . $mysql['DB_HOST'] . ";dbname=" . $mysql['DB_NAME'] . ";port=" . $mysql['DB_PORT'], $mysql['DB_USER'], $mysql['DB_PWD']);
} catch (Exception $e) {
    exit('链接数据库失败:' . $e->getMessage());
}
$domain = $_SERVER['HTTP_HOST'];
$db->exec("set names utf8");
$stmt = $db->prepare("select * from bqyj_separate where urls=:urls limit 1");
$stmt->execute(array(':urls' => $domain));
if ($separate = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!$separate['zt']) {
        exit("该站已被禁！");
    }
    $prefix = $separate['prefix'] . "_";
    $endtime = $separate['endtime'];
    $now = date("Y-m-d");
    if ($endtime <= $now) {
        exit("该站已经过期！");
    }
    $isdomain = 1;
} else {
    $prefix = $mysql['DB_PREFIX'];
}
if ($rows = $db->query('select * from ' . $prefix . 'webconfigs')) {
    while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
        $webconfig[$row['vkey']] = $row['value'];
    }
    C($webconfig);
}
if ($_GET['cron'] != C('cronrand') && $crontype != 1) {
    exit('监控识别码不正确！');
}