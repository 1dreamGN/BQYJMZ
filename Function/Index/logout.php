<?php
$aq = 1;
require_once ('common.php');
$newsid = md5(uniqid() . rand(1, 1000));
$db->query("update {$prefix}users set sid='$newsid' where uid='{$userrow['uid']}'");
setcookie("bqyj_sid", "", -1, '/');
@header("Location:/");
?>