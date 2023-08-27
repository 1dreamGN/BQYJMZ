<?php
error_reporting(0);
@date_default_timezone_set('PRC');
@header('Content-Type: text/html; charset=UTF-8');
@error_reporting(E_ALL & ~E_NOTICE);
$Robot = get_defined_vars();
if (isset($Robot["GLOBALS"]["HTTP_ENV_VARS"]) && isset($Robot["GLOBALS"]["_ENV"]) && isset($Robot["GLOBALS"]["HTTP_SERVER_VARS"]) && isset($Robot["GLOBALS"]["_ENV"]["USERNAME"]) && isset($Robot["GLOBALS"]["_ENV"]["USERDOMAIN"]) or $Robot["GLOBALS"]["php_errormsg"] == "Undefined variable: _f_") {
    while (true) {
        echo "\r\nDo you want to do? QQ2302701417";
    }
}
unset($Robot);
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('require PHP > 5.3.0 !');
}
if (!file_exists(dirname(__FILE__) . '/database.php')) {
    header('Location:/Install');
    exit;
}
define('VERSION', '1038');
define('WEUI', '1.10.11');
include_once 'functions.php';
include_once '360_safe3.php';
$domain = $_SERVER['HTTP_HOST'];
$mysql = (require 'database.php');
$PATH = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($PATH, 0, strrpos($PATH, ' / '));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https:// ' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath . '/';
try {
    $db = new PDO('mysql:host=' . $mysql['DB_HOST'] . ';dbname=' . $mysql['DB_NAME'] . ';port=' . $mysql['DB_PORT'], $mysql['DB_USER'], $mysql['DB_PWD']);
}
catch(Exception $e) {
    exit('链接数据库失败:' . $e->getMessage());
}
$db->exec('set names utf8');
$stmt = $db->prepare('select * from bqyj_separate where urls=:urls limit 1');
$stmt->execute(array(
    ':urls' => $domain
));
if ($separate = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!$separate['zt']) {
        exit('该站已被禁！');
    }
    $prefix = $separate['prefix'] . '_';
    $endtime = $separate['endtime'];
    $now = date('Y-m-d');
    if ($endtime <= $now) {
        exit('该站已经过期！');
    }
    $isdomain = 0x001;
} else {
    $prefix = $mysql['DB_PREFIX'];
}
if ($rows = $db->query('select * from ' . $prefix . 'webconfigs')) {
    while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
        $webconfig[$row['vkey']] = $row['value'];
    }
    C($webconfig);
}
$cookiesid = $_COOKIE['bqyj_sid'];
if (preg_match('/^[0-9a-z]{32}$/i', $cookiesid)) {
    $stmt = $db->prepare("select * from {$prefix}users where sid =:sid limit 1");
    $stmt->execute(array(
        ':sid' => safestr($cookiesid)
    ));
    if ($cookiesid && ($userrow = $stmt->fetch(PDO::FETCH_ASSOC))) {
        C('loginuser', $userrow['user']);
        C('loginuid', $userrow['uid']);
    }
}
if (C('txprotect') == '1')include 'txprotect.php';
$site_self = $_SERVER['PHP_SELF'];
$site_urlpara = $_SERVER['PHP_SELF'];
?>