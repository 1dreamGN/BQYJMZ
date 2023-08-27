<?php
require_once ('common.php');
if (!C('web_quanquanjk')) exit("<script>alert('站长没有填写圈圈赞接口');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
date_default_timezone_set('PRC');
header("Content-type:text/html;charset=utf-8");
$qq = $_GET['qq'];
$qid = $_GET['qid'];
$now = date("Y-m-d-H:i:s");
$data = get_curl(C('web_quanquanjk') . $qq);
exit("<script>alert('QQ" . $qq . "提交成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
?>