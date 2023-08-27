<?php
require_once('common.php');
if(!$userrow['daili']){
    exit("<script language='javascript'>alert('你不是代理！');window.location.href='/Function/Index/';</script>");
}
C('webtitle', '代理专区');
include_once 'core.head.php';
if($_GET['do'] == 'del'){
    $kid = is_numeric($_GET['kid'])?$_GET['kid']:'0';
    if($kid && $row = $db -> get_results("select * from {$prefix}kms where kid=:kid and daili=:daili limit 1", array(':kid' => $kid, ':daili' => $userrow['uid']))){
        if($db -> query("delete from {$prefix}kms where kid='{$kid}' and daili='{$userrow[uid]}'")){
            if($row['isuse'] == 0 && $row['ms'] > 0){
                $db -> query("delete from {$prefix}qqs where qid='$qid'");
                $db -> query("update {$prefix}users set rmb=rmb+{$row[ms]} where uid='{$userrow[uid]}'");
                $ms = round($row['ms'] - ($row['ms'] * C('dailikm')));
                $userrow['rmb'] = $userrow['rmb'] + $row['ms'];
                echo "<script language='javascript'>alert('删除卡密成功！，由于该卡密没有使用，余额{$row[ms]}元已退回至你的账户中！');window.location.href='daili.php';</script>";
            }else{
                echo "<script language='javascript'>alert('删除卡密成功！');window.location.href='daili.php';</script>";
            }
        }else{
            echo "<script language='javascript'>alert('删除卡密失败！');window.location.href='daili.php';</script>";
        }
    }else{
        echo "<script language='javascript'>alert('要删除的卡密不存在！');window.location.href='daili.php';</script>";
    }
}
if($_POST['do'] == 'add'){
    $num = is_numeric($_POST['num'])?$_POST['num']:'1';
    $rmb = is_numeric($_POST['rmb'])?$_POST['rmb']:'1';
    if($num > 0x014)exit("<script language='javascript'>alert('一次性最多生成20个！');window.location.href='daili.php';</script>");
    if($rmb > 0x064)exit("<script language='javascript'>alert('卡密最大面额为100元！');window.location.href='daili.php';</script>");
    $now = date('Y-m-d H:i:s');
    for($i = 0;$i < $num;$i++){
        $km = get_sz();
        $dailikm = round(($rmb * 0x064));
        $nrmb = $userrow['rmb'] - $rmb;
        if($userrow['rmb'] > 0 && $nrmb >= 0){
            if($db -> query("insert into  {$prefix}kms (kind,daili,km,ms,isuse,uid,addtime) values (0,'$userrow[uid]','$km','$rmb',0,0,'$now')")){
                $db -> query("update {$prefix}users set rmb=rmb-{$rmb} where uid='{$userrow[uid]}'");
                $userrow['rmb'] = $nrmb;
                $kmmsg .= "<li class='list-group-item'>{$km}</li>";
            }
        }else{
            echo "<script language='javascript'>alert('账户余额不足！');window.location.href='daili.php';</script>";
        }
    }
}
$p = is_numeric($_GET['p'])?$_GET['p']:'1';
$pp = $p + 0x00008;
$pagesize = 10;
$start = ($p-1) * $pagesize;
$pages = ceil(get_count('kms', 'daili=:daili', 'kid', array(':daili' => $userrow['uid'])) / $pagesize);
if(!$pages)$pages = 1;
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
$rows = $db -> query("select * from {$prefix}kms where daili='" . $userrow['uid'] . "' order by kid desc limit $start,$pagesize");
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">代理中心</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                    卡密生成
			</div>
			<div class="panel-body">
				<form action="?" class="form-horizontal" method="post">
					<input type="hidden" name="do" value="add">
					<div class="list-group-item">
						<div class="input-group">
							<div class="input-group-addon">
								当前余额
							</div>
							<input type="text" class="form-control" value="<?php echo $userrow['rmb']?>" readonly>
						</div>
					</div>
					<div class="list-group-item">
						<div class="input-group">
							<div class="input-group-addon">
								生成个数
							</div>
							<input type="text" class="form-control" name="num" value="1">
						</div>
					</div>
					<div class="list-group-item">
						<div class="input-group">
							<div class="input-group-addon">
								卡密余额
							</div>
							<input type="text" class="form-control" name="rmb" value="1">
						</div>
					</div>
					<div class="hr-line-dashed">
					</div>
					<div class="form-group">
						<div class="col-sm-12 col-sm-offset-10">
							<button class="btn btn-primary" type="submit">生成充值卡</button>

<?php if($kmmsg){
    ?>
							<a data-toggle="modal" class="btn btn-danger" href="#modal-form">查看已生成卡密</a>

<?php }
?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                    卡密列表
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
					<thead>
					<tr>
						<th>
							#KID
						</th>
						<th>
							卡密
						</th>
						<th>
							余额
						</th>
						<th>
							生成时间
						</th>
						<th>
							是否使用
						</th>
						<th>
							使用时间
						</th>
						<th>
							操作
						</th>
					</tr>
					</thead>
					<tbody>

<?php while($km = $rows -> fetch(PDO :: FETCH_ASSOC)){
    ?>
					<tr>
						<td>
							<?php echo $km['kid']?>
						</td>
						<td>
							<?php echo $km['km']?>
						</td>
						<td>
							<?php echo $km['ms']?>
						</td>
						<td>
							<?php echo $km['addtime']?>
						</td>
						<td>
							<?php if($km['isuse']){
        echo'<font color="red">已使用</font>';
    }else{
        echo'<font color="green">未使用</font>';
    }
    ?>
						</td>
						<td>
							<?php echo $km['usetime']?>
						</td>
						<td>
							<a href="?do=del&p=<?php echo $p?>&kid=<?php echo $km['kid']?>" class="btn btn-danger" onClick="if(!confirm('确认删除？')){return false;}">删除</a>&nbsp;
						</td>
					</tr>

<?php }
?>
					</tbody>
					</table>
				</div>
				<div class="row" style="text-align:center;">
				<ul class="pagination pagination-lg">
					<li
<?php if($p == 1){
    echo'class="disabled"';
}
?>><a href="?p=1&do=km">首页</a></li>
					<li
<?php if($prev == $p){
    echo'class="disabled"';
}
?>><a href="?p=<?php echo $prev?>&do=km">&laquo;</a></li>
					<?php for($i = $p;$i <= $pp;$i++){
    ?>
					<li <?php if($i == $p){
        echo'class="active"';
    }
    ?>><a href="?p=<?php echo $i?>&do=km"><?php echo $i?></a></li>
					<?php }
?>
					<li <?php if($next == $p){
    echo'class="disabled"';
}
?>><a href="?p=<?php echo $next?>&do=km">&raquo;</a></li>
					<li
<?php if($p == $pages){
    echo'class="disabled"';
}
?>><a href="?p=<?php echo $pages?>&do=km">末页</a></li>
				</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'core.foot.php';
?>
<div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div id="collapseshop" class="panel-body">
						<h3 class="m-t-none m-b">已生成卡密</h3>
						<ul>
							<?php echo $kmmsg?>
						</ul>
						<a data-toggle="modal" class="btn btn-white pull-right" href="#modal-form">返回</a>
						</div>
                    </div>
                </div>
            </div>
        </div>
	</div>