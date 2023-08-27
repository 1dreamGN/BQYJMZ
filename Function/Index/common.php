<?php
require_once ('../../Core/common.php');
//判断是否登录
if (!C('loginuid')) {
	exit("<script language='javascript'>window.location.href='/login.php';</script>");
} elseif ($userrow['aqproblem'] == '' or $userrow['aqanswer'] == '') {
	if ($aq != 1) exit("<script language='javascript'>alert('请先设置安全问题！');window.location.href='uset.php';</script>");
}
?>