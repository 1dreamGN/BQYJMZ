<?php
require_once 'common.php';
require_once 'qlogin.class.php';
C('pageid', 'add');
$uin = safestr(is_numeric($_POST['uin']) ? $_POST['uin'] : $_GET['uin']);
$cap_cd = safestr($_POST['cap_cd']);
$_pwd = safestr($_POST['pwd']);
$sig = $_POST['sig'];
$code = $_POST['code'];
$sess = $_POST['sess'];
if ($_GET['type'] == "add") {
    if (!$uin) {
        exit('<script>alert("QQ号码不能为空！");window.location.href="add.php";</script>');
    } elseif (!preg_match("/^[1-9][0-9]{4,11}$/", $uin)) {
        exit('<script>alert("QQ号码不正确！");window.location.href="add.php";</script>');
    } else {
        if ($_GET['auto'] == 1) {
            if (!$qqrow = get_results("select * from {$prefix}qqs where qq=:qq and uid=:uid limit 1", array(":qq" => $uin, ":uid" => $userrow['uid']))) {
                exit("<script language='javascript'>alert('QQ不存在！');window.location.href='add.php';</script>");
            }
            $pwd = $qqrow['pwd'];
        } else {
            $pwd = md5($_pwd);
        }
		$data = new Qqlogin($uin, $pwd, $code, $cap_cd, $sig, $sess);
        $qqs = json_decode($data->json, true);
        if ($qqs['code'] == -1) {
            $vcode = 1;
            $sig = $qqs['sig'];
			$cap_cd = $qqs['cap_cd'];
			$sess = $qqs['sess'];
        } elseif ($qqs['code'] == -3) {
            $msg = $qqs['msg'];
        } else {
            if ($qqs['skey'] && $qqs['p_skey']) {
                $skey = $qqs['skey'];
                $p_skey = $qqs['p_skey'];
                $pookie = $qqs['pookie'];
                $ptsig = $qqs['ptsig'];
                $now = date("Y-m-d H:i:s");
                $nowdate = date("Y-m-d");
                if (C('addqq')) {
                    addfriend($uin, $skey, $p_skey);
                }
                if ($row = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin))) {
                    $set = "skey='{$skey}',p_skey='{$p_skey}',ptsig='{$ptsig}',pwd='{$pwd}',pookie='{$pookie}',sidzt=0,skeyzt=0,addtime='{$now}',adddate='{$nowdate}',gxmsg='0'";
                    $db->query("update {$prefix}qqs set {$set} where qq='$uin'");
                    $rows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin));
                    exit("<script language='javascript'>alert('QQ更新成功！');window.location.href='qqlist.php?qid=" . $rows['qid'] . "';</script>");
                } else {
                    if (get_count('qqs', "uid=:uid", 'qid', array(":uid" => $userrow['uid'])) >= $userrow['peie']) {
                        $peie = $userrow['peie'];
                        exit("<script language='javascript'>alert('对不起，你最大允许添加{$peie}个QQ！');window.location.href='add.php';</script>");
                    }
                    if ($db->query("insert into  {$prefix}qqs (uid,qq,skey,p_skey,ptsig,pwd,sidzt,skeyzt,addtime,pookie,adddate,gxmsg) values ('$userrow[uid]','$uin','$skey','$p_skey','$ptsig','$pwd',0,0,'$now','$pookie','$nowdate','0')")) {
                        $rows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin));
                        exit("<script language='javascript'>alert('QQ添加成功！');window.location.href='qqlist.php?qid=" . $rows['qid'] . "';</script>");
                    } else {
                        $msg = "保存数据库失败，请联系站长";
                    }
                }
            } else {
                $msg = $qqs['msg'];
            }
        }
    }
}
if ($_GET['type'] == "save") {
    $uin = is_numeric($_POST['uin']);
    $pskey = safestr($_POST['pskey']);
    $skey = safestr($_POST['skey']);
    $pookie = safestr($_POST['pookie']);
    $pwd = safestr($_POST['pwd']);
    $now = date("Y-m-d H:i:s");
    $nowdate = date("Y-m-d");
    if (C('addqq')) {
        addfriend($uin, $skey, $pskey);
    }
    if (empty($pwd)) $pwd = '0';
    else $pwd = MD5($pwd);
    if (!$uin) {
        exit('<script>alert("QQ号码不能为空！");window.location.href="add.php";</script>');
    } elseif (!preg_match("/^[1-9][0-9]{4,11}$/", $uin)) {
        exit('<script>alert("QQ号码不正确！");window.location.href="add.php";</script>');
    } else {
        if ($row = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin))) {
            $set = "skey='{$skey}',p_skey='{$pskey}',pwd='{$pwd}',pookie='{$pookie}',sidzt=0,skeyzt=0,gxmsg='0',addtime='{$now}',adddate='{$nowdate}'";
            $db->query("update {$prefix}qqs set {$set} where qq='$uin'");
            $rows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin));
            exit("<script language='javascript'>alert('QQ更新成功！');window.location.href='qqlist.php?qid=" . $rows['qid'] . "';</script>");
        } else {
            if (get_count('qqs', "uid='$userrow[uid]'", 'qid') >= $userrow['peie']) {
                $peie = $userrow['peie'];
                exit("<script language='javascript'>alert('对不起，你最大允许添加{$peie}个QQ！');window.location.href='add.php';</script>");
            }
            if ($db->query("insert into {$prefix}qqs (uid,qq,skey,pwd,p_skey,sidzt,skeyzt,addtime,pookie,adddate,gxmsg) values ('$userrow[uid]','$uin','$skey','$pwd','$pskey',0,0,'$now','$pookie','$adddate','0')")) {
                $rows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(":qq" => $uin));
                exit("<script language='javascript'>alert('QQ添加成功！');window.location.href='qqlist.php?qid=" . $rows['qid'] . "';</script>");
            } else {
                $msg = "保存数据库失败，请联系站长";
            }
        }
    }
}
C('webtitle', '添加挂机');
include_once 'core.head.php';
?>
		<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">添加QQ</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" align="center">警告！</h3>
        </div>
        <div class="panel-body" align="left">
          <p>1、首次使用本网站可能会因为异地登陆而被TX临时冻结QQ，改密即可解冻</p>
          <p>2、添加后会提示<?=get_ip_city(gethostbyname($_SERVER['HTTP_HOST']))?>的异地登陆提醒，以及可能被盗号的安全提醒，本站承诺不盗号读取数据</p>
		  <p>3、若添加过程中不出现验证码,则自动更新功能开启</p>
		  <p>* 帐号配额：已用<font color=green><?=get_count('qqs',"uid=:uid",'qid',array(":uid"=>$userrow['uid']))?></font>个，共有<?=$userrow[peie]?>个</p>
          <strong>添加QQ即代表同意本站协议并自愿使用，不同意以上内容请关闭本网站。</strong>
        </div>
      </div>
    </div>
	<?php
	if($_GET['login']!=2){
	?>
    <div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" align="center">添加 / 更新 <a href="?login=2">[切换到二维码登录]</a></h3>
        </div>
        <div class="panel-body" align="left">
        <form action="?type=add" role="form" class="form-horizontal" method="post">
          <input type="hidden" name="is" value="ok">
		  <?php
if ($msg) { ?><?php echo '<div class="list-group-item">
            <div class="input-group">
              '.$msg.'
            </div>
          </div>' ?><?php
} ?>
                    <div class="list-group-item">
            <div class="input-group">
              <div class="input-group-addon">Q Q</div>
              <input type="text" class="form-control" name="uin" value="<?=$uin?>" required >
            </div>
          </div>
          <div class="list-group-item">
            <div class="input-group">
              <div class="input-group-addon">密码</div>
              <input type="password" class="form-control" name="pwd" value="<?=$_pwd?>" required>
            </div>
          </div>
          <div class="list-group-item <?php
if (!$vcode) { ?> hide <?php
} ?>">
            <div class="input-group">
			<input type="hidden" name="sig" value="<?php echo $sig ?>">
			<input type="hidden" name="cap_cd" value="<?php echo $cap_cd ?>">
			<input type="hidden" name="sess" value="<?php echo $sess ?>">
              <div class="input-group-addon">验证码</div>
              <input type="text" class="form-control" name="code" placeholder="输入验证码">
              <br>
              <img class="form-control" style="height:83px;width: 160px;"
                             src="getpic.php?uin=<?php echo $uin?>&cap_cd=<?php echo $cap_cd?>&sig=<?php echo $sig?>&sess=<?php echo $sess?>">
            </div>
          </div>
          <div class="list-group-item">
            <input type="submit" name="submit" value="确认提交" class="btn btn-primary btn-block">
          </div>
        </form>
      </div>
    </div>
	<?php
	}else{
	?>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="../../Template/qrlogin.js"></script>
	<div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" align="center">添加 / 更新 <a href="?login=1">[切换到正常登录]</a></h3>
        </div>
        <div class="panel-body" align="left">
        <div class="list-group" align="center">
		<div class="list-group-item list-group-item-info" style="font-weight: bold;">
				<span id="loginmsg">二维码可能对个别QQ无效，若出现账号为空 请切换到正常模式</span>
			</div>
			<div class="list-group-item"><img src="http://android-artworks.25pp.com/fs01/2015/02/02/11/110_3395e627ca83ae423d7dad98a5768ede.png" width="80px"></div>
			<div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
				<span id="loginmsg">使用QQ手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
			</div>
			<div class="list-group-item" id="qrimg">
			</div>
			
		</div>
      </div>
    </div>
	</div>
</div>
	<?php
	}
	?>
	  <?php
include_once 'core.foot.php';
function addfriend($uin, $skey, $pskey)
{
$gtk = getGTK($pskey);
$cookie = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . '; p_skey=' . $pskey . '; p_uin=o0' . $uin . ';';
$ua = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
$url = 'http://w.qzone.qq.com/cgi-bin/tfriend/friend_addfriend.cgi?g_tk=' . $gtk;
$post = 'sid=0&ouin=' . C('addqq') . '&uin=' . $uin . '&fupdate=1&rd=0.017492896' . time() . '&fuin=' . C('addqq') . '&groupId=0&realname=&flag=&chat=&key=&im=0&g_tk=' . $gtk . '&from=9&from_source=11&format=json&qzreferrer=http://user.qzone.qq.com/' . $uin . '/myhome/friends/ofpmd';
$data = get_curl($url, $post, 'http://user.qzone.qq.com/' . $uin . '/myhome/friends/ofpmd', $cookie, 0, $ua);
}
?>