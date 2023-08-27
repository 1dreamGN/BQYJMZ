<?php
require_once('../../Core/common.php');

//判断是否登录
if(!C('loginuid')){
	exit("<script language='javascript'>alert('您没有登陆');window.location.href='/login.php';</script>");
}elseif($userrow['active']!=9){
	exit("<script language='javascript'>alert('您没有资格');window.location.href='/login.php';</script>");
}
