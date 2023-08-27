<?php
require_once ('common.php');
C('webtitle', 'QQ列表');
C('pageid', 'deputyqq');
include_once '../Index/core.head.php';
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : '0';
if ($_GET['do'] == 'del') {
	$db->query("delete from {$prefix}qqs where qid='$qid'");
	echo "<script language='javascript'>alert('删除成功！');</script>";
}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp = $p + 8;
$pagesize = 10;
$start = ($p - 1) * $pagesize;
$pages = ceil(get_count('qqs', '1=:1', 'qid', array(":1" => "1")) / $pagesize);
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
$qqs = $db->query("select * from {$prefix}qqs order by qid desc limit $start,$pagesize");
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">QQ列表</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
		<div class="col-sm-12">
	      <div class="panel body">
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
				<tr>
					<th>#QID</th>
					<th>QQ</th>
					<th>SID/SKEY</th>
					<th>所属用户</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php while($qq = $qqs->fetch(PDO::FETCH_ASSOC)){?>
				<tr>
					<td><?=$qq['qid']?></td>
					<td><?=$qq['qq']?></td>
					<td><?php if($qq['sidzt']){echo"<font color='red'>失效</font>";}else{echo"<font color='green'>正常</font>";}?>/<?php if($qq['skeyzt']){echo"<font color='red'>失效</font>";}else{echo"<font color='green'>正常</font>";}?></td>
					<td>UID:<?=$qq['uid']?></td>
					<td><?=$qq['addtime']?></td>
					<td><a href="?do=del&p=<?=$p?>&qid=<?=$qq[qid]?>" class="btn btn-danger" onClick="if(!confirm('确认删除？')){return false;}">删除</a>&nbsp;</td>
				</tr>
				<?php }?>
				</tbody>
				</table>
			</div>
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
		</div>
	</div>
</div>
<?php
include_once '../Index/core.foot.php';
?><?php 