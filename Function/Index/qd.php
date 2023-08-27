<?php
require_once ('common.php');
C('webtitle', '每日签到');
C('pageid', 'qd');
include_once 'core.head.php';
$dates = date('Y-m-d');
if ($_POST['do'] == 'qd') {
	if (get_isvip($userrow[vip], $userrow[vipend])) {
		exit("<script language='javascript'>alert('您已是VIP会员,VIP用户无法参与本活动');history.go(-1);</script>");
	}
	$qq = $_POST['uin'];
	if (!$qq) {
		exit("<script language='javascript'>alert('请先选择要用于发布签到信息的QQ！');history.go(-1);</script>");
	} elseif (get_results("select * from {$prefix}qds where uid=:uid and adddate='" . date('Y-m-d') . "' limit 1",array(":uid"=>$userrow['uid']))) {
		exit("<script language='javascript'>alert('您今天已经签到,请勿重复签到！');history.go(-1);</script>");
	} else {
		if (!$qqrow = get_results("select * from {$prefix}qqs where qq=:qq and uid=:uid limit 1",array(":uid"=>$userrow['uid'],":qq"=>$qq))) {
			exit("<script language='javascript'>alert('此QQ不存在！');history.go(-1);</script>");
		} else {
			include_once "../../QQTask/qzone.class.php";
			$qzone = new qzone($qqrow['qq'], $qqrow['sid'], $qqrow['skey'], $qqrow['p_skey'],$qqrow['pookie']);
			$qdgg = C('qdgg');
			if (!$qdgg) $qdgg = get_con();
			$pic = trim('');
			$qzone->shuo(1, $qdgg, $pic);
			if ($qzone->zt == 1) {
				$times = date('Y-m-d', strtotime('- 1 days', time()));
				$msg = 'sweetAlert("温馨提示", "签到成功,获得1余额！", "success");';
				if ($qqrows = get_results("select * from {$prefix}qds where uid=:uid and adddate=:time limit 1",array(":uid"=>$userrow['uid'],":time"=>$times))) {
					$lx = $qqrows['lx'] + 1;
					$addtime = date('Y-m-d H:i:s');
					$adddate = date('Y-m-d');
					$rmb = $userrow[rmb] + 1;
					@mysqli_query("update {$prefix}users set rmb='$rmb' where uid='" . $userrow[uid] . "'");
					$db->query("insert into {$prefix}qds (uid,lx,adddate,addtime) values ('" . $userrow[uid] . "','$lx','$adddate','$addtime')");
				} else {
					$addtime = date('Y-m-d H:i:s');
					$adddate = date('Y-m-d');
					$rmb = $userrow[rmb] + 2;
					@mysqli_query("update {$prefix}users set rmb='$rmb' where uid='" . $userrow[uid] . "'");
					$db->query("insert into {$prefix}qds (uid,lx,adddate,addtime) values ('" . $userrow[uid] . "','1','$adddate','$addtime')");
					$msg = 'sweetAlert("温馨提示", "首次签到成功,获得2余额！", "success");';
				}
			} else {
				$msg = 'sweetAlert("温馨提示", "签到失败！可能状态已过期", "warning");';
			}
		}
	}
}
$rowss = get_results("select * from {$prefix}qds where uid=:uid limit 1",array(":uid"=>$userrow['uid']));
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">每日签到</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">签到提示</div>
          <div class="panel-wrapper">
              <div class="list-group-item bb">每日签到可获取1余额，余额可开通VIP资格和余额奖励。!</div>
			  <div class="list-group-item bb">当前已连续签到活跃<strong><?php if($rowss['lx']==''){echo '0';}else{ echo $rowss['lx'];}?>天！</strong>，总签到<strong><?=get_count('qds',"uid=:uid",'id',array(":uid"=>$row['uid']))?>天</strong></div>
          </div>
      </div>
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">签到</div>
          <div class="panel-wrapper">
		  <form action="#" role="form" class="form-horizontal" method="post">
              <div class="list-group-item bb">	<a href="#/choujiang/" ui-sref="choujiang" class="pull-right btn btn-success btn-xs" style="margin-left:5px;">积分抽奖</a><a href="#/duihuan/" ui-sref="duihuan" class="pull-right btn btn-success btn-xs">积分兑换</a>
                  <span class="fa fa-th-list" aria-hidden="true">&nbsp;可用余额：<font color="green" size="3"><?=$userrow[rmb]?></font>元</span>
              </div>
              <div class="list-group-item bb">签到会在你所选择的QQ空间内发布一条本平台的推广广告说说，如不能接受，请勿签到！</div>
              <div class="list-group-item bb">
                        <input type="hidden" name="do" value="qd">
                  <div class="input-group">
                      <div class="input-group-addon">选择QQ</div>
                      <select name="uin" class="form-control">
					  <?php
					  $rowss = $db->query("select * from {$prefix}qqs where uid='$userrow[uid]' order by qid desc");
					  while($row = $rowss->fetch(PDO::FETCH_ASSOC)){
					  ?>
					<option value="<?=$row[qq]?>"><?=$row[qq]?></option>
					<?php }?>
					</select>
                  </div>
              </div>
              <div class="list-group-item bb">
				  <input type="submit" name="submit" value="同意签到" onClick="this.value='提交中...'" class="btn btn-primary btn-block">
              </div>
			  </form>
          </div>
      </div>
	 </div>
	  <div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">全站签到记录</div>
          <div class="panel-wrapper">
					  <?php
					  $rowss = $db->query("select * from {$prefix}qds where 1 order by lx desc limit 10");
					  while($row = $rowss->fetch(PDO::FETCH_ASSOC)){
						  $user =get_results("select * from {$prefix}users where uid =:uid limit 1",array(":uid"=>$row['uid']));
					  ?>
          <li class="list-group-item bb"><span class="badge bg-inverse-light"><small>连续<?=$row[lx]?>天</small></span><span class="fa fa-user"></span>&nbsp;&nbsp;<font color="#FF3399"><?=$user[user]?></font>在<?=$row[addtime]?>进行了签到!</li>
		  <?php }?>
          </div>
      </div>
    </div>
  </div>
  </div>
	  <?php
include_once 'core.foot.php';
function get_con(){
	$row=file('../../Status/1.txt');
	shuffle($row);
	return $row[0];
}
function getMonthNum( $date1, $date2, $tags='-' ){
  $date1 = explode($tags,$date1);
  $date2 = explode($tags,$date2);
  return abs($date1[0] - $date2[0]) * 12 + abs($date1[1] - $date2[1]);
 }
?>