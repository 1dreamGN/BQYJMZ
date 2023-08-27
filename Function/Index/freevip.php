<?php
require_once('common.php');
C('webtitle', '免费会员');
C('pageid', 'freevip');
include_once 'core.head.php';
$dates = date('Y-m-d');
if($_POST['do'] == 'freevip'){
    if(get_isvip($userrow['vip'], $userrow['vipend'])){
        $msg = 'sweetAlert("温馨提示", "您已是VIP会员,VIP用户无法参与本活动", "warning");';
    }else{
        $addtime = date('Y-m-d H:i:s');
        $adddate = date('Y-m-d');
        $viptime = date('Y-m-d', strtotime('+1 month'));
        $db -> query("update {$prefix}users set vip='1',vipend='{$viptime}' where user='" . $userrow['user'] . "'");
        $db -> query("insert into {$prefix}vips (user,adddate,addtime) values ('" . $userrow['user'] . "','" . $adddate . "','" . $addtime . "')");
        $msg = 'sweetAlert("温馨提示", "恭喜你，成功领取VIP会员一个月", "success");';
    }
}
$rowss = get_results("select * from {$prefix}vips where user=:user limit 1", array(':user' => $userrow['user']));
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">免费会员</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading portlet-handler ui-sortable-handle">领取提示</div>
            <div class="panel-wrapper">
                <div class="list-group-item bb">每个月可无限领取 前提是非VIP用户即可每月领取1个月的VIP会员。</div>
                <div class="list-group-item bb">
<?php if(get_isvip($userrow['vip'], $userrow['vipend'])){
    echo "<font color='red'>系统已检测到你已是VIP会员，无法领取奖励</font>";
}else{
    echo '您是免费用户，可领取一个月视线的VIP会员';
}
?></div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading portlet-handler ui-sortable-handle">VIP领取</div>
            <div class="panel-wrapper">
                <form action="#" role="form" class="form-horizontal" method="post">
                    <input type="hidden" name="do" value="freevip">
                    <div class="list-group-item bb"><a href="/Function/Index/qd.php" class="pull-right btn btn-success btn-xs"
                                                       style="margin-left:5px;">签到领余额</a><a href="/Function/Index/reginfo.php"
                                                                                            class="pull-right btn btn-success btn-xs">邀请好友领余额</a>
                        <span class="fa fa-user"
                              aria-hidden="true">&nbsp;
<?php if(get_isvip($userrow['vip'], $userrow['vipend'])){
    echo '包月VIP会员 ' . $userrow['vipend'];
}else{
    echo '免费用户';
}
?></span>
                    </div>
					<div class="list-group-item bb">
                <div class="input-group">
                    <span class="fa fa-th-list" aria-hidden="true"> 全站总共领取次数:<font color="green" size="3"><?php echo get_count('vips', '1=:1', 'addtime', array(':1' => '1'))?></font>次</span>
                </div>
            </div>
                    <div class="list-group-item bb">
                        <input type="submit" name="submit" value="马上领取" onClick="this.value='提交中...'"
                               class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading portlet-handler ui-sortable-handle">全站领取记录</div>
            <div class="panel-wrapper">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>领取记录</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>

<?php
 $rowss = $db -> query("select * from {$prefix}vips where 1 order by adddate desc limit 10");
while($row = $rowss -> fetch(PDO :: FETCH_ASSOC)){
    ?>
                        <tr>
                            <td style="padding-left:8px;"><span class="fa fa-user"></span>&nbsp;&nbsp;<font
                                    color="#FF3399"><?php echo $row['user']?></font>领取了<b>30</b>天VIP会员！
                            </td>
                            <td style="padding-left:8px;"><?php echo $row['addtime']?></td>
                        </tr>

<?php }
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once 'core.foot.php';
?>