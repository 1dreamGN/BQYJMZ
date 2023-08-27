<?php
error_reporting(E_ALL & ~E_NOTICE);
$install = 1;
require_once ('../Core/common.php');
@header('Content-Type: text/html; charset=UTF-8');
$sqls = "
";
$explode = explode(';', $sqls);
$num = count($explode);
foreach ($explode as $sql) {
    if ($sql = trim($sql)) {
        $db->query($sql);
    }
}
$db->query("insert into {$prefix}webconfigs set vkey='version',value='1038' on duplicate key update value='1038'");
exit("<script language='javascript'>alert('网站数据库升级完成！');window.location.href='/index.php';</script>");
?>

