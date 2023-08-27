<?php
require_once('common.php');
C('webtitle', '用户中心');
C('pageid', 'user');
include_once 'core.head.php';
for($i = 0;$i < 0x000009;$i++){
    $j = $i + 0x001;
    $userrs .= get_count('users', 'adddate=:date', 'uid', array(':date' => date('Y-m-d', strtotime("-{$j} day")))) . ',';
}
for($i = 0;$i < 0x000009;$i++){
    $j = $i + 0x001;
    $qqrs .= get_count('qqs', 'adddate=:date', 'qid', array(':date' => date('Y-m-d', strtotime("-{$j} day")))) . ',';
}
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">用户中心</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="col-sm-12">
        <div class="row">
<div class="col-md-6">
<div class="panel b-a">
<div class="panel-heading no-border bg-primary">
<span class="text-lt">欢迎回来 <?=$userrow['user']?> 上次登录:<?=$userrow['lasttime']?></span>
</div>
<div class="item m-l-n-xxs m-r-n-xxs">
<div ng-init="x = 3"class="top text-right padder m-t-xs w-full">
<rating ng-model="x"max="5"state-on="'fa fa-star text-white'"state-off="'fa fa-star-o text-white'"></rating>
</div>
<div class="center text-center w-full"style="margin-top:-60px">
<div ui-jq="easyPieChart"ui-refresh="x"ui-options="{
                percent: 0,
                lineWidth: 60,
                trackColor: 'rgba(255,255,255,0)',
                barColor: 'rgba(35,183,229,0.7)',
                scaleColor: false,
                size: 120,
                lineCap: 'butt',
                rotate: 0,
                animate: 1000
              }"class="inline">
</div>
</div>
<img src="<?=C('index_pic_yhzx')?>" class="img-full">
</div>
<div class="hbox text-center b-b b-light text-sm">
<a href="/Function/Index/qq.php" class="col padder-v text-muted b-r b-light">
<i class="glyphicon glyphicon-leaf icon block m-b-xs fa-2x"></i>
<span>挂机管理</span>
</a>
<a href="/Function/Index/uindex.php?uid=<?=$userrow['uid']?>" class="col padder-v text-muted b-r b-light">
<i class="icon-user block m-b-xs fa-2x"></i>
<span>账户信息</span>
</a>
<a href="/Function/Index/shop.php" class="col padder-v text-muted">
<i class="icon-cursor block m-b-xs fa-2x"></i>
<span>用户商城</span>
</a>
</div>
<div class="hbox text-center text-sm">
<a href="/Function/Index/mzlist.php" class="col padder-v text-muted b-r b-light">
<i class="icon-plus block m-b-xs fa-2x"></i>
<span>QQ秒赞墙</span>
</a>
<a href="/Function/Index/daili.php" class="col padder-v text-muted b-r b-light">
<i class="icon-like block m-b-xs fa-2x"></i>
<span>代理后台</span>
</a>
<a href="/Function/Admin/index.php" class="col padder-v text-muted">
<i class="icon-link block m-b-xs fa-2x"></i>
<span>后台管理</span>
</a>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="panel panel-default">
<div class="panel-heading">
<div class="clearfix">
<a href class="pull-left thumb-md avatar b-3x m-r">
<img src="http://q1.qlogo.cn/g?b=qq&nk=<?=$userrow['qq']?>&s=100&t=1420118110"alt="...">
</a>
<div class="clear">
<div class="h3 m-t-xs m-b-xs"style="text-transform:uppercase;">
                    <?=$userrow['user']?>                    <i class="fa fa-circle text-success pull-right text-xs m-t-sm"></i>
</div>
<small class="text-muted">QQ-member: <?=$userrow['qq']?></small>
</div>
</div>
</div>
<div class="list-group no-radius alt">
<a href="/Function/Index/uindex.php"class="list-group-item">
<i class="fa fa-user fa-fw"></i> 
                查看资料
              </a>
<a href="/Function/Index/add.php"class="list-group-item">
<i class="fa fa-plus fa-fw"></i> 
                添加挂机
              </a>
<a href="/Function/Index/mzlist.php"class="list-group-item">
<i class="fa fa-thumbs-up fa-fw"></i> 
                QQ秒赞墙
              </a>
<a class="list-group-item"href="http://wpa.qq.com/msgrd?v=3&uin=<?= C('webqq') ?>&site=qq&menu=yes">
<i class="fa fa-shield fa fa-qq fa-fw"></i> 
                联系客服
              </a>
</div>
</div>
</div>
<div class="col-md-6">
          <div class="row row-sm text-center">
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="h1 text-info font-thin h1"><?php echo get_count('users', '1=:1', 'uid', array(':1' => '1'))?></div>
                <span class="text-muted text-xs">总用户</span>
                <div class="top text-right w-full">
                  <i class="fa fa-caret-down text-warning m-r-sm"></i>
                </div>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="block panel padder-v bg-primary item">
                <span class="text-white font-thin h1 block"><?php echo get_count('users', 'adddate=:date', 'uid', array(':date' => date('Y-m-d')))?></span>
                <span class="text-muted text-xs">新注册</span>
                <span class="bottom text-right w-full">
                  <i class="fa fa-cloud-upload text-muted m-r-sm"></i>
                </span>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="block panel padder-v bg-info item">
                <span class="text-white font-thin h1 block"><?php echo get_count('qqs', '1=:1', 'uid', array(':1' => '1'))?></span>
                <span class="text-muted text-xs">全部QQ</span>
                <span class="top text-left">
                  <i class="fa fa-caret-up text-warning m-l-sm"></i>
                </span>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="font-thin h1"><?php echo get_count('qqs', 'iszan=:2 or iszan=:1', 'qid', array(':1' => '1', ':2' => '2'))?></div>
                <span class="text-muted text-xs">秒赞QQ数量</span>
                <div class="bottom text-left">
                  <i class="fa fa-caret-up text-warning m-l-sm"></i>
                </div>
              </div>
            </div>
			<div class="col-xs-12">
              <div class="panel padder-v item">
                <div class="font-thin h1"><?php echo get_count('qqs', "isreply='2' or isreply='1'", 'qid', array(':1' => '1', ':2' => '2'))?></div>
                <span class="text-muted text-xs">秒评QQ数量</span>
                <div class="bottom text-left">
                  <i class="fa fa-caret-up text-warning m-l-sm"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
</div>
<div class="panel hbox hbox-auto-xs no-border">
<div class="col wrapper">
<i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
<h4 class="m-n font-thin h3">最新公告</h4>
<span class="m-b block text-sm text-muted"></span><br>
<div class="table-panel">
<?php
 $rows = $db -> query("select * from {$prefix}gonggao where 1=1 order by id desc");
while($row = $rows -> fetch(PDO :: FETCH_ASSOC)){
    ?>
                    <p><?php echo $row['con']?>[<?php echo $row['addtime']?>]</p>
                    <?php
    }
?></thead>
</div>
</div>
</div>
</div></div>


<?php
include_once 'core.foot.php';
?>