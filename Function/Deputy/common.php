<?php
require_once('../../Core/common.php');

//判断是否登录
if(!C('loginuid')){
	exit("<script language='javascript'>alert('请先登录！');window.location.href='/login.php';</script>");
}elseif($userrow['fuzhan']!=1){
	exit("<script language='javascript'>alert('你不是副站长！');window.location.href='/';</script>");
}