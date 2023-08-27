<?php
$aq = 1;
require_once ('common.php');
if ($do = $_POST['do']) {
	if ($do == 'update') {
		$qq = safestr($_POST['qq']);
		$aqproblem = safestr($_POST['aqproblem']);
		$aqanswer = safestr($_POST['aqanswer']);
		$player = safestr($_POST['player']);
		if ($aqproblem == '' or $aqanswer == '') exit("<script language='javascript'>alert('安全问题不能为空！');window.location.href='uset.php';</script>");
		$set = "qq='{$qq}',aqproblem='{$aqproblem}',aqanswer='{$aqanswer}',player='{$player}'";
		if ($_POST['pwd']) {
			$pwd = md5(md5($_POST['pwd']) . md5('1340176819'));
			$set.= ",pwd='{$pwd}'";
		}
		$stmt = $db->prepare("select * from {$prefix}users where qq=:qq and uid!=:uid limit 1");
		$stmt->execute(array(':qq' => $qq, ':uid' => $userrow['uid']));
		if ($stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<script language='javascript'>alert('QQ号已存在！');window.location.href='uset.php';</script>";
		} else {
			$db->query("update {$prefix}users set {$set} where uid='{$userrow['uid']}'");
			echo "<script language='javascript'>alert('修改成功');window.location.href='uset.php';</script>";
		}
	}
}
C('webtitle', $userrow['user'] . '-用户修改');
C('pageid', 'uset');
include_once 'core.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">资料修改</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="col-md-7">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">资料修改</div>
          <div class="panel-wrapper">
          <form action="?" role="form" class="form-horizontal ng-pristine ng-valid" method="post">
		  <input type="hidden" name="do" value="update">
            <div class="list-group-item bb">
                <div class="input-group">
                  <div class="input-group-addon">用户码</div>
                  <input type="text" class="form-control" value="<?=$userrow['uid']?>" disabled="disabled">
                </div>
            </div>
          
            <div class="list-group-item bb">
                <div class="input-group">
                    <div class="input-group-addon">用户名</div>
                    <input type="text" class="form-control" value="<?=$userrow['user']?>" disabled="disabled">
                </div>
            </div>
			
            <div class="list-group-item bb">
                <div class="input-group">
                    <div class="input-group-addon">QQ账号</div>
                    <input type="text" class="form-control" maxlength="12" name="qq" value="<?=$userrow['qq']?>">
                </div>
            </div>

            <div class="list-group-item bb">
				<span class="help-block m-b-none">所有信息都与此QQ进行绑定，填写后可显示对应头像以及用来找回密码，加入Vip售后群时将以此QQ号进行验证</span>
            </div>

            <div class="list-group-item bb">
                <div class="input-group">
                    <div class="input-group-addon">新密码</div>
                    <input type="text" class="form-control" name="pwd" placeholder="不修改请留空">
                </div>
            </div>
			
            <div class="list-group-item bb">
                <div class="input-group <?=$error?>">
                    <div class="input-group-addon">密保问题</div>
                    <input type="text" class="form-control" name="aqproblem" placeholder="此处必填" value="<?=$userrow['aqproblem']?>">
                </div>
            </div>
			
            <div class="list-group-item bb">
                <div class="input-group <?=$error?>">
                    <div class="input-group-addon">密保答案</div>
                    <input type="text" class="form-control" name="aqanswer" placeholder="此处必填"value="<?=$userrow['aqanswer']?>">
                </div>
            </div>
			<div class="list-group-item bb">
                <div class="input-group">
                    <div class="input-group-addon">音乐播放器开关</div>
                    <input class="form-control" type="text" name="player" value="<?=$userrow['player']?>">
                </div>
            </div>
			<div class="list-group-item bb">
				<span class="help-block m-b-none"><font color=red>关闭前台PJAX+音乐播放器【个人用户】请填入 0 开启前台PJAX+音乐播放器【个人用户】请填入 1 <br>前台后台一起开启会导致css或js冲突</font></span>
            </div>
            <div class="list-group-item">
				<button class="btn btn-primary btn-block" type="submit" name="submit" value="1">确认修改</button>
            </div>
          
          </form>
          </div>
      </div>
  </div>
  
	  <?php
include_once 'core.foot.php';
?>