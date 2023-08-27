<?php
require_once ('../../Core/common.php');
$uid = $_GET['uid'];
if (!$uid) exit("<script language='javascript'>alert('邀请人不能为空');history.go(-1);</script>");
if ($_POST['do'] == 'reg') {
	session_start();
	$user = safestr($_POST['user']);
	$uid = safestr($_POST['uid']);
	$qq = safestr($_POST['qq']);
	$pwd = safestr($_POST['pwd']);
	$code = safestr($_POST['code']);
	$ip = getip();
	$stmt = $db->query("select uid from {$prefix}users where qq='{$qq}' or user='{$user}' limit 1");
	$stmts = $db->query("select uid from {$prefix}users where regip='{$ip}' or lastip='{$ip}' limit 1");
	if (strlen($user) < 5) {
		exit("<script language='javascript'>alert('用户名太短');history.go(-1);</script>");
	}elseif(strlen($user) > 10){
		exit("<script language='javascript'>alert('用户名太长');history.go(-1);</script>");
	}elseif(strlen($qq) > 10){
		exit("<script language='javascript'>alert('QQ账号没有10位以上');history.go(-1);</script>");
	} elseif (!$code || strtolower($_SESSION['bqyj_code']) != strtolower($code)) {
		exit("<script language='javascript'>alert('验证码错误');history.go(-1);</script>");
	} elseif (strlen($pwd) < 5) {
		exit("<script language='javascript'>alert('密码太简单！');history.go(-1);</script>");
	} elseif ($stmts->fetch(PDO::FETCH_ASSOC)) {
		exit("<script language='javascript'>alert('一个IP只能注册一次');history.go(-1);</script>");
	} elseif ($stmt->fetch(PDO::FETCH_ASSOC)) {
		exit("<script language='javascript'>alert('用户名或QQ已存在！');history.go(-1);</script>");
	} else {
		$_SESSION['bqyj_code'] = md5(get_sz(4) . rand(100, 500) . time());
		$sid = md5(get_sz(4) . uniqid() . rand(1, 1000));
		$pwd = md5(md5($pwd) . md5('1340176819'));
		$now = date("Y-m-d H:i:s");
		$city = get_ip_city($ip);
		$active = 1;
		$peie = C('regpeie');
		$rmb = C('regrmb');
		$vipstart = date('Y-m-d');
		$vipend = date('Y-m-d', strtotime('+ 7 day'));
		if ($db->query("insert into {$prefix}users (user,pwd,sid,active,peie,rmb,qq,city,regip,lastip,regtime,lasttime,aqproblem,aqanswer,vip,vipstart,vipend,yq,adddate) values ('$user','$pwd','$sid','$active','$peie','$rmb','$qq','$city','$ip','$ip','$now','$now','','','1','$vipstart','$vipend','0','$vipstart')")) {
			$userrows = get_results("select user,uid,regip,regtime from {$prefix}users where user =:user limit 1",array(":user"=>$user));
			$reguid = $userrows[uid];
			$regip = $userrows[regip];
			$addtime = $userrows[regtime];
			$auser = get_results("select yq,uid from {$prefix}users where uid =:uid limit 1",array(":uid"=>$uid));
			$yq = $auser[yq] + 1;
			$uidn = $auser[uid];
			$db->query("insert into {$prefix}reg (uid,reguid,regip,addtime) values ('$uidn','$reguid','$regip','$addtime')");
			@mysql_query("update {$prefix}users set yq='$yq' where uid='$uidn'");
			exit("<script language='javascript'>alert('注册成功,7天vip已到账！');window.location.href='/login.php';</script>");
		} else {
			exit("<script language='javascript'>alert('注册失败');history.go(-1);</script>");
		}
	}
}
$userrow = get_results("select user,uid from {$prefix}users where uid=:uid limit 1",array(":uid"=>$uid));
?>
<!DOCTYPE html>
<!-- 
模板来自[QQ秒赞网]
 -->
<html lang="zh-cn"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="keywords" content="<?=C('webname')?>好友邀请注册-秒赞平台">
	<meta name="description" content="开始你在<?=C('webname')?>的旅程 - <?=C('webname')?>好友邀请注册-秒赞平台">
	<title>开始你在<?=C('webname')?>的旅程 - <?=C('webname')?>好友邀请注册-秒赞平台</title>
	<link rel="stylesheet" href="../../Template/user/public.css">
	<link rel="stylesheet" href="../../Template/user/friend.css">	
</head>
<body>
    <p style="display:none;">发个福利，用我的邀请链接注册<?=C('webname')?>，可以领取7天VIP，免费使用网站里所有的功能，机不可失失不再来！</p>
    <div class="wrapper page-w1000">
		<div class="head-banner" id="headBanner">
			<div class="wrap">
				<h2 class="joinin">接受<span id="userName"><?=$userrow[user]?></span>的邀请加入<?=C('webname')?></h2>
				<div class="form">
					<h2>
						<span>免费领取VIP</span>这种好事<br>只有在此页注册才有哦！
					</h2>
					<form action="#" method="POST">
					<input type="hidden" name="do" value="reg"/>
					<input type="hidden" name="uid" value="<?=$uid?>"/>
					<ul class="inputlist">
						<li>
							<label for=""><i>*</i>用户名</label>
							<input type="text" name="user" maxlength="16" class="input" placeholder="用户名，最长16位">
						</li>
						<li>
							<label for=""><i>*</i>密码</label>
							<input type="password" name="pwd" maxlength="16" class="input" placeholder="密码，6-16位">
						</li>
						<li>
							<label for=""><i>*</i>QQ</label>
							<input type="text" name="qq" class="input" placeholder="请填写QQ号">
						</li>
						<li>
							<label for=""><i>*</i>验证码</label>
							<input type="text" name="code" class="w84" placeholder="输入验证码" >
							<a class="autocode" href="javascript:;">
								<img  title="点击刷新" src="../../Status/code/code.php?+Math.random();" style="width: 90px;" align="absbottom" onclick="this.src='../../Status/code/code.php?'+Math.random();"></img>
							</a>
						</li>
					</ul>
					<input class="get-vip" id="subTel" type="submit" value="立即注册 领取VIP" >
					</form>
				</div>
			</div>
		</div>
		<div class="module-lessons">
			<div class="wrap">
				<h2 class="text-hide">全网最大的QQ秒赞网，实力保证</h2>
				<p class="text-hide">覆盖13+热门技术，多项签到，秒赞认证，全自动化处理</p>
			</div>
		</div>

		<div class="module-learn">
			<div class="wrap">
				<h2>简单快速上手，支持手机/平板/PC电脑一站式管理服务</h2>
			</div>
		</div>
		<div class="module-join">
			<div class="wrap">
				<h2>加入<?=C('webname')?>,和数万名用户一起享受24小时离线托管带来的便捷！</h2>
				<a class="link text-hide" href="#top">领取7天VIP</a>
			</div>
		</div>
    </div>
</body>
</html>