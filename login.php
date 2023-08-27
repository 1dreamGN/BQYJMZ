<?php
require_once('Core/common.php');
if($_POST['do']=='login'){
	$user=safestr($_POST['user']);
	$pwd=safestr($_POST['pwd']);
	$ip=getip();
	if(!$user || !$pwd){
		$msgs = 'sweetAlert("温馨提示", "账号或密码不能为空", "warning");';
	}elseif(strlen($user) < 5){
		$msgs = 'sweetAlert("温馨提示", "用户名太短！", "warning");';
	}elseif(strlen($pwd) < 5){
		$msgs = 'sweetAlert("温馨提示", "密码太简单！", "warning");';
	}else{
		$pwd=md5(md5($pwd).md5('1340176819'));
		$where="(user=:user or qq=:user) and pwd=:pwd";
		$stmt = $db->prepare("select * from {$prefix}users where {$where} limit 1");
		$stmt->execute(array(':user'=>$user,':pwd'=>$pwd));
		if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$sid=md5(get_sz(4).uniqid().rand(1,1000));
			$now=date("Y-m-d H:i:s");
			$ip=getip();
			$db->query("update {$prefix}users set sid='$sid',lasttime='$now',lastip='$ip' where uid='{$row[uid]}'");
			setcookie("bqyj_sid",$sid,time()+3600*24*14,'/');
			$ntime=date("G"); //取得现在的时间
	if($ntime>=0 and $ntime<4){exit("<script language='javascript'>alert('尊敬的{$row[user]}，午夜好！');window.location.href='../Function/Index/';</script>");}
	if($ntime>=4 and $ntime<11){exit("<script language='javascript'>alert('尊敬的{$row[user]}，早上好！');window.location.href='../Function/Index/';</script>");}
	if($ntime>=11 and $ntime<14){exit("<script language='javascript'>alert('尊敬的{$row[user]}，中午好！');window.location.href='../Function/Index/';</script>");}
	if($ntime>=14 and $ntime<18){exit("<script language='javascript'>alert('尊敬的{$row[user]}，下午好！');window.location.href='../Function/Index/';</script>");}
	if($ntime>=18 and $ntime<24){exit("<script language='javascript'>alert('尊敬的{$row[user]}，晚上好！');window.location.href='../Function/Index/';</script>");}
	exit;
		}else{
			$msgs = 'sweetAlert("温馨提示", "账号或密码错误！", "warning");';
			
		}
	}
}
if($_POST['do']=='reg'){
	session_start();
	$user=safestr($_POST['user']);
	$qq=safestr($_POST['qq']);
	$pwd=safestr($_POST['pwd']);
	$code=safestr($_POST['code']);
	$ip=getip();
	$stmt = $db->query("select uid from {$prefix}users where qq='{$qq}' or user='{$user}' limit 1");
	if(strlen($user) < 5){
		$msg = 'sweetAlert("温馨提示", "用户名太短", "warning");';
	}elseif(strlen($user) > 10){
		$msg = 'sweetAlert("温馨提示", "用户名太长", "warning");';
	}elseif(strlen($qq) > 10){
		$msg = 'sweetAlert("温馨提示", "QQ账号没有10位以上", "warning");';
	}elseif(!$code || strtolower($_SESSION['bqyj_code'])!=strtolower($code)){
		$msg = 'sweetAlert("温馨提示", "验证码错误", "warning");';
	}elseif(strlen($pwd) < 5){
		$msg = 'sweetAlert("温馨提示", "密码太简单！", "warning");';
	}elseif(strlen($pwd) > 15){
		$msg = 'sweetAlert("温馨提示", "密码太长！", "warning");';
	}elseif($stmt->fetch(PDO::FETCH_ASSOC)){
		$msg = 'sweetAlert("温馨提示", "QQ或用户名已存在", "warning");';
	}else{
		$_SESSION['bqyj_code'] =md5(rand(100,500).time());
		$sid=md5(get_sz(4).uniqid().rand(1,1000));
		$pwd=md5(md5($pwd).md5('1340176819'));
		$now=date("Y-m-d H:i:s");
		$nowdate=date("Y-m-d");
		$city=get_ip_city($ip);
		$active=1;
		$peie=C('regpeie');
		$rmb=C('regrmb');
		if ($db->query("insert into {$prefix}users (user,pwd,sid,active,peie,rmb,qq,city,regip,lastip,regtime,lasttime,aqproblem,aqanswer,yq,adddate) values ('$user','$pwd','$sid','$active','$peie','$rmb','$qq','$city','$ip','$ip','$now','$now','','','0','$nowdate')")) {
			$msg = 'sweetAlert("温馨提示", "注册成功，您的用户名为:'.$user.'", "success");';
		}else{
			$msg = 'sweetAlert("温馨提示", "注册失败，数据处理时出错", "warning");';
		}
	}
}
if($_GET["do"]!="reg"){
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>登陆 | <?=C("webname")?></title>
<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet"href="/Template/login/bootstrap.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/animate.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font-awesome.min.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/simple-line-icons.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/app.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/sweetalert.css"type="text/css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<div class="app app-header-fixed ">
<div class="container w-xxl w-auto-xs"ng-controller="SigninFormController"ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t"><?=C("webname")?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>您将在这里登陆,请输入客户端的帐号信息!</strong>
</div>
<form name="form"class="form-validation"method="post">
<input type="hidden" name="do" value="login"/>
<div class="text-danger wrapper text-center"ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text"name="user"placeholder="Username"class="form-control no-border"required>
</div>
<div class="list-group-item">
<input type="password"name="pwd"placeholder="Password"class="form-control no-border"required>
</div>
</div>
<button type="submit"class="btn btn-lg btn-primary btn-block">现在登入</button>
<div class="text-center m-t m-b"><a  href="find.php">忘记密码?</a></div>
<div class="line line-dashed"></div>
<p class="text-center"><small>还没有一个账户?</small></p>
<a href="?do=reg"ui-sref="access.signup"class="btn btn-lg btn-default btn-block">创建一个账户</a>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><?=C("webname")?><br>&copy; 2016

</small>
</p>
</div>
</div>
</div>
<script src="/Template/login/jquery.min.js"></script>
<script src="/Template/login/sweetalert.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
<?php
if($msgs){
	echo "<script type='text/javascript'>{$msgs}</script>";
}
?>
</body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>注册用户 | <?=C("webname")?></title>
<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet"href="/Template/login/bootstrap.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/animate.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font-awesome.min.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/simple-line-icons.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/app.css"type="text/css"/>
<script src="/Template/login/jquery.2.1.1.js"></script>
<link rel="stylesheet"href="/Template/login/sweetalert.css"type="text/css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<div class="app app-header-fixed ">
<div class="container w-xxl w-auto-xs"ng-controller="SigninFormController"ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t"><?=C("webname")?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>您将在这里注册,您登陆客户端的帐号信息!</strong>
</div>
<form name="form"class="form-validation"method="post">
<input type="hidden" name="do" value="reg"/>
<div class="text-danger wrapper text-center"ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text"name="user"placeholder="请输入用户名"class="form-control no-border"required>
</div>
<div class="list-group-item">
<input type="password"name="pwd"placeholder="请输入密码"class="form-control no-border"required>
</div>
<div class="list-group-item">
<input type="text"name="qq"placeholder="请输入QQ号"class="form-control no-border"required>
</div>
<div class="list-group-item">
<input type="text"name="code"placeholder="请输入下方验证码" maxlength="5" onkeyup="this.value=this.value.replace(/\D/g,'')"class="form-control no-border"required>
</div>
<div class="list-group-item">
<img title="点击刷新" src="/Status/code/code.php?+Math.random();" onclick="this.src='/Status/code/code.php?'+Math.random();" class="img-rounded"> <small> 看不清？点击图片更换</small>
</div>
<button type="submit"class="btn btn-lg btn-primary btn-block">现在注册</button>
<div class="line line-dashed"></div>
<p class="text-center"><small>有账户?</small></p>
<a href="login.php"ui-sref="access.signup"class="btn btn-lg btn-default btn-block">点击立即登陆</a>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><?=C("webname")?><br>&copy; 2016</small>
</p>
</div>
</div>
</div>
<script src="/Template/login/jquery.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
<script src="/Template/login//sweetalert.min.js"></script>
</body>
</html>
<?php if(!empty($msg))echo "<script type='text/javascript'>{$msg}</script>";?>
</body>
</html>
<?php
}
?>