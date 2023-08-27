<?php
require_once ('common.php');
C('webtitle', '网站管理后台');
C('pageid', 'index');
$index = '1';
include_once 'common.head.php';
if ($_GET['type'] == "add") {
	$con = $_POST['con'];
	$addtime = date('Y-m-d');
	if ($db->query("insert into {$prefix}gonggao (con,addtime) values ('$con','$addtime')")) {
		exit("<script language='javascript'>alert('公告添加成功！');window.location.href='ggset.php';</script>");
	} else {
		exit("<script language='javascript'>alert('添加公告失败');window.location.href='ggset.php';</script>");
	}
}
if ($_GET['type'] == "edits") {
	$id = $_GET['id'];
	$con = $_POST['con'];
	if ($db->query("update {$prefix}gonggao set con='{$con}' where id='$id'")) {
		exit("<script language='javascript'>alert('公告编辑成功！');window.location.href='ggset.php';</script>");
	} else {
		exit("<script language='javascript'>alert('编辑公告失败');window.location.href='ggset.php';</script>");
	}
}
if ($_GET['type'] == 'del') {
	$id = $_GET['id'];
	if (!$db->query("delete from {$prefix}gonggao where id='$id'")) {
		exit("<script language='javascript'>alert('删除公告成功！');window.location.href='ggset.php';</script>");
	}
}
?>

	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">公告设置</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
			<?php
			if($_GET['type']!="edit"){
			?>
<div class="panel panel-default">
			<div class="panel-heading">
                    发布公告
			</div>
			<div class="panel-body">
			<div class="list-group">
			<form action="?type=add" role="form" class="form-horizontal" method="post">
			<input type="hidden" name="do" value="new">
			<div class="list-group-item">
				<div class="input-group">
					<div class="input-group-addon">公告内容</div>
					<textarea class="form-control" name="con" rows="5" placeholder="输入公告内容"></textarea>
				</div>
			</div>

			<div class="list-group-item">
				<input type="submit" name="submit" value="添加" class="btn btn-primary btn-block">
			</div>
			</form>
		</div>
</div></div>
<?php
			}else{
			$id=$_GET['id'];
			$gg=$db->query("select * from {$prefix}gonggao where id='$id' limit 1");
			if(!$row=$gg->fetch(PDO::FETCH_ASSOC)){
			exit("<script language='javascript'>alert('要编辑的公告不存在！');window.location.href='ggset.php';</script>");
			}
?>
<div class="panel panel-default">
			<div class="panel-heading">
                    公告编辑
			</div>
			<div class="panel-body">
			<div class="list-group">
			<form action="?type=edits&id=<?=$id?>" role="form" class="form-horizontal" method="post">
			<input type="hidden" name="do" value="new">
			<div class="list-group-item">
				<div class="input-group">
					<div class="input-group-addon">公告内容</div>
					<textarea class="form-control" name="con" rows="5" placeholder="编辑公告内容"><?=$row['con']?></textarea>
				</div>
			</div>

			<div class="list-group-item">
				<input type="submit" name="submit" value="修改" class="btn btn-primary btn-block">
			</div>
			</form>
		</div>
</div></div>
<?php
			}
?>
    <div class="panel panel-default panel-demo">
       <div class="panel-heading">
          <div class="panel-title">平台公告</div>
       </div>
       <div class="panel-body bg-gonggao-p">
          <div class="col-lg-12 bg-gonggao">
		  <?php
		  $rows = $db->query("select * from {$prefix}gonggao where 1=1 order by id desc");
		  while($row = $rows->fetch(PDO::FETCH_ASSOC)){
		  ?>
              <p><a href="?type=edit&id=<?=$row['id']?>"> [编辑] </a> <a href="?type=del&id=<?=$row['id']?>"> [删除] </a><?=$row['con']?>[<?=$row['addtime']?>]</p>
		  <?php }?>
		  </div>
          <div class="col-md-4"><a href="/Function/Index/mzlist.php" title="QQ秒赞墙"><p class="bg-primary-light"> [热]QQ秒赞墙，秒赞cqy的可以交友哦</p></a></div>
		  <div class="col-md-4"><a href="/Function/Index/qd.php" title="每日签到"><p class="bg-primary-light"> [热]签到送VIP会员与积分中,去看看</p></a></div>
		  <div class="col-md-4"><a href="/Function/Index/reginfo.php" title="邀请好友"><p class="bg-primary-light"> [邀请好友] 注册得积分，送VIP活动中</p></a></div>
       </div>
    </div>
		</div>
	  <?php
include_once 'common.foot.php';
?>