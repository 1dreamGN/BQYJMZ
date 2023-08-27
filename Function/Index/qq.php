<?php
require_once('common.php');
C('webtitle', 'QQ列表');
C('pageid', 'qq');
include_once 'core.head.php';
$p = is_numeric($_GET['p'])?$_GET['p']:'1';
$pp = $p + 0x00008;
$pagesize = 10;
$start = ($p-1) * $pagesize;
if($_GET['do'] == 'search' && $s = safestr($_GET['s'])){
    $pagedo = 'seach';
    $qqs = $db -> query("select * from {$prefix}qqs where qq='{$s}' or user like'%{$s}%' order by (case when qq='{$s}' then 8 else 0 end) desc limit 20");
}else{
    $pages = ceil(get_count('qqs', '1=:1', 'qid', array(':1' => '1')) / $pagesize);
    $qqs = $db -> query("select * from {$prefix}qqs where uid=" . $userrow['uid'] . " order by qid desc limit $start,$pagesize");
}
if($pp > $pages)$pp = $pages;
if($p == 1){
    $prev = 1;
}else{
    $prev = $p-1;
}
if($p == $pages){
    $next = $p;
}else{
    $next = $p + 0x001;
}
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">QQ列表</h1>
</div><div class="wrapper-md ng-scope">
<div class="panel panel-default">
<div class="table-responsive">
<table class="table table-striped b-t b-light">
<thead>
<tr>
<th>QQ账号</th>
<th>功能</th>
</tr>
</thead>
<?php while($qq = $qqs -> fetch(PDO :: FETCH_ASSOC)){
    ?>
<tbody>
<tr>
<td><?=$qq['qq']?></td>
<td>
<a href="qqlist.php?qid=<?=$qq['qid']?>" class="btn m-b-xs btn-sm btn-success btn-addon"><i class="icon-login"></i>进入管理</a>
<a href="qqlist.php?do=del&qid=<?=$qq['qid']?>" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-users"></i>删除账号</a>
<a href="mzrz.php?qq=<?php echo $qq['qq']?>" class="btn m-b-xs btn-sm btn-primary btn-addon">秒赞认证<i class="fa fa-cog"></i></a>
</td>
</tr>

</tbody>


<?php }
?>
</table>
</div>
<footer class="panel-footer">
<div class="row">
<div class="col-sm-12">
<a href="add.php" class="btn btn-sm btn-default">添加新QQ</a>
</div>
</div>
</footer>
</div>

<?php
include_once 'core.foot.php';
?>
