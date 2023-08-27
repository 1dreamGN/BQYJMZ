<?php
require_once('Core/common.php');
if ($_GET['do'] == 'qrfind') {
    $uin = safestr($_GET['uin']);
    $skey = safestr($_GET['skey']);
    $gtk = getGTK($skey);
    $url = "http://mobile.qzone.qq.com/friend/mfriend_list?g_tk=" . $gtk . "&res_uin=" . $uin . "&res_type=normal&format=json&count_per_page=10&page_index=0&page_type=0&mayknowuin=&qqmailstat=";
    $json = get_curl($url, 0, 'http://m.qzone.com/infocenter?g_ut=3&g_f=6676', 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . ';');
    $json = mb_convert_encoding($json, "UTF-8", "UTF-8");
    $arr = json_decode($json, true);
    if (array_key_exists('code', $arr) && $arr['code'] == 0) {
        $_pwd = get_sz(8);
        $pwd = md5(md5(safestr($_pwd)) . md5('1340176819'));
        if ($db->query("update {$prefix}users set pwd='{$pwd}' where qq='{$uin}'")) {
            $msg = 'sweetAlert("温馨提示", "密码已重置，您的新密码为：' . $_pwd . '", "success");';
            $url = '/login.php';
        } else {
            $msg = 'sweetAlert("温馨提示", "密码修改失败，没有找到绑定该QQ的用户", "warning");';
        }
    } else {
        $msg = 'sweetAlert("温馨提示", "验证失败，您貌似不是该账户的主人哦！", "warning");';
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>找回密码 | <?=C("webname")?></title>
<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet"href="/Template/login/bootstrap.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/animate.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font-awesome.min.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/simple-line-icons.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/app.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/sweetalert.css"type="text/css">
</head>
<body>
<script src="/Template/login/jquery.min.js"></script>
<script src="/Template/login/sweetalert.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
<?php if (!empty($msg)) echo "<script type='text/javascript'>{$msg}</script>"; ?>
</body>
</html>

    <?php
} elseif ($_POST['do'] == 'find') {
    session_start();
    $user = safestr($_POST['user']);
    $aqanswer = safestr($_POST['aqanswer']);
    $pwd = md5(md5(safestr($_POST['pwd'])) . md5('1340176819'));
    $code = safestr($_POST['code']);
    if (!$code || strtolower($_SESSION['bqyj_code']) != strtolower($code)) {
        $msgs = 'sweetAlert("温馨提示", "验证码错误", "warning");';
    } else {
		$stmt = $db->prepare("select * from {$prefix}users where aqanswer=:aqanswer and user=:user limit 1");
        $stmt->execute(array(
            ':aqanswer' => $aqanswer,
            ':user' => $user
        ));
		if($stmt->fetch(PDO::FETCH_ASSOC)){
			if ($db->query("update {$prefix}users set pwd='{$pwd}' where user='{$user}'")) {
				$msgs = 'sweetAlert("温馨提示", "密码修改成功", "success");';
			} else {
				$msgs = 'sweetAlert("温馨提示", "密码修改失败", "warning");';
			}
		} else {
			$msgs = 'sweetAlert("温馨提示", "验证失败，您貌似不是该账户的主人哦！", "warning");';
		}
		        
    }
    ?>
	
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>找回密码 | <?=C("webname")?></title>
<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet"href="/Template/login/bootstrap.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/animate.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font-awesome.min.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/simple-line-icons.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/font.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/app.css"type="text/css"/>
<link rel="stylesheet"href="/Template/login/sweetalert.css"type="text/css">
</head>
<body>
<script src="/Template/login/jquery.min.js"></script>
<script src="/Template/login/sweetalert.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
<?php if (!empty($msgs)) echo "<script type='text/javascript'>{$msgs}</script>"; ?>
</body>
</html>
    <?php
} elseif ($_POST['do'] == 'finds') {
    $user = safestr($_POST['user']);
    $stmt = $db->prepare("select * from {$prefix}users where user=:user limit 1");
    $stmt->execute(array(':user' => $user));
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $aqproblem = $row['aqproblem'];
    } else {
        $msg2 = 'sweetAlert("温馨提示", "该用户不存在", "warning");';
    }
    ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>找回密码 | <?=C("webname")?></title>
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
<body>
<div class="app app-header-fixed ">
<div class="container w-xxl w-auto-xs"ng-controller="SigninFormController"ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t"><?=C("webname")?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>您将在这里找回密码,请输入客户端的帐号信息!</strong>
</div>
<form name="form"class="form-validation"method="post">
<input type="hidden" name="do" value="find">
<input type="hidden" name="user" value="<?= $user ?>">
<div class="text-danger wrapper text-center"ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text" class="form-control no-border" value="<?= $aqproblem ?>" readonly>
</div>	
<div class="list-group-item">
<input type="password"name="pwd"class="form-control no-border"placeholder="请输入新密码"
onkeydown="if(event.keyCode==32){return false;}"required>
</div>	   
<div class="list-group-item">
<input type="text"name="aqanswer"class="form-control no-border"placeholder="请输入密保答案"required autofocus>
</div>
<div class="list-group-item">
<img src="/Status/code/code.php?+Math.random();" onclick="this.src='/Status/code/code.php?'+Math.random();" title="点击更换验证码"
                             style="margin-bottom:5px;border: 1px solid #5CAFDE;">
<input type="text"name="code" maxlength="5"class="form-control no-border"placeholder="输入验证码(不分大小写)"
                               onkeydown="if(event.keyCode==32){return false;}"required>
</div>							   
</div>
</div>
<button type="submit"class="btn btn-lg btn-primary btn-block"id="sub">找回密码</button>
<div class="text-center m-t m-b"><a  href="/login.php">用户登录</a></div>
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
<?php if (!empty($msg2)) echo "<script type='text/javascript'>{$msg2}</script>"; ?>
</body>
</html>
    <?php
} elseif ($_GET['do'] == 'qrlogin') {
    ?>
    <!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>找回密码 | <?=C("webname")?></title>
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
<strong>通过QQ扫码找回密码</strong>
</div>
            <form id="form-login" method="post" class="form-horizontal" onsubmit="?">
                <div class="panel-body" style="text-align: center;">
                    <div class="list-group">
                        <div class="list-group-item"><img
                                src="http://android-artworks.25pp.com/fs01/2015/02/02/11/110_3395e627ca83ae423d7dad98a5768ede.png"
                                width="80px"></div>
                        <div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
                            <span id="loginmsg">使用QQ手机版扫描二维码</span><span id="loginload"
                                                                         style="padding-left: 10px;color: #790909;">.</span>
                        </div>
                        <div class="list-group-item" id="qrimg">
                        </div>

                    </div>
                </div>
            </form>
<div class="text-center m-t m-b"><a  href="login.php">用户登录</a></div>
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
 <script src="../Status/qrlogin/qrlogin.js"></script>
<script src="/Template/login//sweetalert.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
</body>
</html>
    <?php
} else {
    ?>
   <!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<title>找回密码 | <?=C("webname")?></title>
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
<strong>您将在这里找回密码,请输入客户端的帐号信息!</strong>
</div>
<form name="form"class="form-validation"method="post">
<input type="hidden" name="do" value="finds"/>
<div class="text-danger wrapper text-center"ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text"name="user"class="form-control no-border"placeholder="请输入需要找回用户账号"onkeydown="if(event.keyCode==32){return false;}" required autofocus>
</div>
<div class="list-group-item">
<a href="find.php?do=qrlogin">使用QQ扫码找回</a>
</div>
</div>
<button type="submit"class="btn btn-lg btn-primary btn-block"id="sub">下一步</button>
<div class="text-center m-t m-b"><a  href="login.php">用户登录</a></div>
<div class="line line-dashed"></div>
<p class="text-center"><small>还没有一个账户?</small></p>
<a href="/login.php?do=reg"ui-sref="access.signup"class="btn btn-lg btn-default btn-block">创建一个账户</a>
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
<script src="/Template/login//sweetalert.min.js"></script>
<script src="/Template/login/bootstrap.js"></script>
<script src="/Template/login/ui-load.js"></script>
<script src="/Template/login/ui-jp.config.js"></script>
<script src="/Template/login/ui-jp.js"></script>
<script src="/Template/login/ui-nav.js"></script>
<script src="/Template/login/ui-toggle.js"></script>
</body>
</html>
<?php } ?>