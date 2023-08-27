<?php
require_once('common.php');
C('webtitle', '用户主页');
C('pageid', 'uindex');
include_once 'core.head.php';
$uid = is_numeric($_GET['uid'])?$_GET['uid']:'0';
if($_GET['do'] == 'search'){
    if(!$_POST['user'] || !$userrows = get_results("select * from {$prefix}users where user=:user limit 1", array(':user' => $_POST['user']))){
        exit("<script language='javascript'>alert('用户不存在！');window.location.href='/Function/Index/';</script>");
    }
}else{
    if(!$uid || !$userrows = get_results("select * from {$prefix}users where uid=:uid limit 1", array(':uid' => $uid))){
        exit("<script language='javascript'>alert('用户不存在！');window.location.href='/Function/Index/';</script>");
    }
}
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">个人资料</h1>
</div><div class="wrapper-md ng-scope"><div class="row">

<div class="col-sm-6">
          <div class="panel b-a">
            <div class="panel-heading bg-info dk no-border wrapper-lg">
              
            </div>
            <div class="text-center m-b clearfix">
              <div class="thumb-lg avatar m-t-n-xxl">
                <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $userrows['qq']?>&spec=100" class="b b-3x b-white">
                <div class="h4 font-thin m-t-sm"><?php echo $userrows['qq']?></div>
              </div>
            </div>
            <div class="hbox text-center b-b b-light text-sm">     
          <div class="list-group">
          <div class="list-group-item but-br">
             <div class="media-box">
                <div class="pull-left" style="margin:auto 5px;">
                   <span class="circle circle-success circle-lg text-left"></span>
                </div>
                <div class="media-box-body clearfix">
                   <div class="media-box-heading m0"><small>查询时间：<?php echo date('Y-m-d H:i:s')?></small></div>
                </div>
             </div>
          </div>
          <div class="list-group-item but-br">
             <div class="media-box">
                <div class="pull-left" style="margin:auto 5px;">
                   <span class="circle circle-success circle-lg text-left"></span>
                </div>
                <div class="media-box-body clearfix">
                   <div class="media-box-heading m0"><small>注册时间：<?php echo $userrows['regtime']?></small></div>
                </div>
             </div>
          </div>
          <div class="list-group-item but-br">
             <div class="media-box">
                <div class="pull-left" style="margin:auto 5px;">
                   <span class="circle circle-success circle-lg text-left"></span>
                </div>
                <div class="media-box-body clearfix">
                   <div class="media-box-heading m0"><small>绑定QQ：<?php echo $userrows['qq']?></small></div>
                </div>
             </div>
          </div>
          <div class="list-group-item but-br">
             <div class="media-box" style="margin-top:5px;">
                <div class="pull-left" style="margin:auto 5px;">
                   <span class="circle circle-success circle-lg text-left"></span>
                </div>
                <div class="media-box-body clearfix">
                   <div class="media-box-heading m0"><small>用 户 组：
<?php if(get_isvip($userrows['vip'], $userrows['vipend'])){
    echo "<font color='red'>VIP用户 " . $userrows['vipend'] . '</font>';
}else{
    echo"<font color='green'>免费用户</font>";
}
?></small></div>
                </div>
             </div>
          </div>
       </div>
        </div>
          </div>
        </div>
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">搜索用户</div>
          <div class="panel-wrapper">
          <form action="?do=search" role="form" class="form-horizontal ng-pristine ng-valid" method="post">
            <div class="list-group-item bb">
                <div class="input-group">
                  <div class="input-group-addon">用户名</div>
                  <input type="text" class="form-control" name="user" value="" placeholder="输入用户名">
                </div>
            </div>

            <div class="list-group-item">
				<button class="btn btn-primary btn-block" type="submit" name="submit" value="1">搜一下</button>
            </div>

          </form>
          </div>
      </div>
  </div>

<?php
include_once 'core.foot.php';
?>