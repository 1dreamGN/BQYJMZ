<?php
require_once ('common.php');
$uid = is_numeric($_GET['uid']) ? $_GET['uid'] : '0';
C('pageid', 'deputyuser');
C('webtitle', '用户列表');
include_once '../Index/core.head.php';
if ($_GET['do'] == 'daili') {
	$stmt = $db->query("select * from {$prefix}users where uid='$uid'");
	if ($uid && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($row['active'] > 7) {
			exit("<script language='javascript'>alert('禁止对管理员进行修改！');window.location.href='ulist.php';</script>");
		}
		if ($row['daili']) {
			$db->query("update {$prefix}users set daili=0 where uid='{$uid}'");
			echo "<script language='javascript'>alert('取消代理成功！');</script>";
		} else {
			$db->query("update {$prefix}users set daili=1 where uid='{$uid}'");
			echo "<script language='javascript'>alert('设为代理成功！');</script>";
		}
	}
}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp = $p + 8;
$pagesize = 10;
$start = ($p - 1) * $pagesize;
if ($_GET['do'] == 'search' && $s = safestr($_GET['s'])) {
	$pagedo = 'seach';
	$users = $db->query("select * from {$prefix}users where uid='{$s}' or user like'%{$s}%' order by (case when uid='{$s}' then 8 else 0 end)+(case when user like '%{$s}%' then 3 else 0 end) desc limit 20");
} else {
	$pages = ceil(get_count('users', '1=:1', 'uid',array(":1"=>"1")) / $pagesize);
	$users = $db->query("select * from {$prefix}users order by uid desc limit $start,$pagesize");
}
if ($pp > $pages) $pp = $pages;
if ($p == 1) {
	$prev = 1;
} else {
	$prev = $p - 1;
}
if ($p == $pages) {
	$next = $p;
} else {
	$next = $p + 1;
}
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">用户列表</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
            <div class="col-sm-12">
			<form action="?" method="GET">
		<div class="input-group">
		<input type="hidden" name="do" value="search">
		<input type="text" name='s' placeholder="用户uid、用户名" class="form-control">
		<span class="input-group-btn">
		<input type="submit" class="btn btn-primary" value="搜索">
		</span>
		</div>
		</form>
		<hr>
                <div class="panel panel-default">
			<div class="panel-heading">
                    用户列表
			</div>
			<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
				<tr>
					<th>#UID</th>
					<th>用户名</th>
					<th>代理</th>
					<th>用户等级</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php while($user = $users->fetch(PDO::FETCH_ASSOC)){?>
				<tr>
					<td><?=$user['uid']?></td>
					<td><?=$user['user']?></td>
					<td><a href="?do=daili&p=<?=$p?>&uid=<?=$user['uid']?>" onClick="if(!confirm('确认更改？')){return false;}" class="btn <?php if($user['daili']){echo'btn-danger';}else{echo'btn-success';}?> btn-xs"><?php if($user['daili']){echo'取消';}else{echo'设为';}?></a></td>
					<td><?php if(get_isvip($userrow['vip'],$userrow['vipend'])){ echo "<font color='red'>VIP用户</font>";}else{echo"<font color='green'>免费用户</font>";}?></td>
					<td><a href="uset.php?xz=update&uid=<?=$user['uid']?>" class="btn btn-info">修改</a></td>
				</tr>
				<?php }?>
				</tbody>
				</table>
			</div>
			<?php if($pagedo!='seach'){?>
			<div class="row" style="text-align:center;">
				<ul class="pagination pagination-lg">
					<li <?php if($p==1){echo'class="disabled"';}?>><a href="?p=1">首页</a></li>
					<li <?php if($prev==$p){echo'class="disabled"';}?>><a href="?p=<?=$prev?>">&laquo;</a></li>
					<?php for($i=$p;$i<=$pp;$i++){?>
					<li <?php if($i==$p){echo'class="active"';}?>><a href="?p=<?=$i?>"><?=$i?></a></li>
					<?php }?>
					<li <?php if($next==$p){echo'class="disabled"';}?>><a href="?p=<?=$next?>">&raquo;</a></li>
					<li <?php if($p==$pages){echo'class="disabled"';}?>><a href="?p=<?=$pages?>">末页</a></li>
				</ul>
			</div>
			<?php }?>
		</div></div>
		</div></div>
<?php
include_once '../Index/core.foot.php';
?><?php 