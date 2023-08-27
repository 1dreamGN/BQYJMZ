<?php
require_once ('common.php');
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : '0';
if ($_GET['do'] == 'del') {
	$db->query("delete from {$prefix}qqs where qid='$qid'");
	echo "<script language='javascript'>alert('删除成功！');window.location.href='qlist.php';</script>";
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
if ($_GET['do'] == 'search' && $s = safestr($_GET['s'])) {
	$pagedo = 'seach';
	$qqs = $db->query("select * from {$prefix}qqs where qid='{$s}' or qq like'%{$s}%' order by (case when qid='{$s}' then 8 else 0 end)+(case when qq like '%{$s}%' then 3 else 0 end) desc limit 20");
} else {
	$pages = ceil(get_count('qqs', '1=:1', 'qid', array(":1" => "1")) / $pagesize);
	$qqs = $db->query("select * from {$prefix}qqs order by qid desc limit $start,$pagesize");
}
if ($_GET['zt'] == '1') {
	$qqs = $db->query("select * from {$prefix}qqs where sidzt=0 and skeyzt=0 order by qid desc limit $start,$pagesize");
} else {
	$qqs = $db->query("select * from {$prefix}qqs order by qid desc limit $start,$pagesize");
}
C('pageid', 'adminqq');
C('webtitle', 'QQ列表');
include_once 'common.head.php';
?>	
<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">QQ列表</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
	  
	            <div class="col-lg-3">
                <div class="panel panel-default">
				<?php while ($qq = $qqs->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?= $qq['qq'] ?>&amp;spec=100" width="80"
                                 height="80" class="img-circle circle-border m-t-xxs" alt="profile">
                            <h4 class="font-bold no-margins">QID：<?= $qq[qid] ?></h4>
                        </div>
                    </div>
                    <div class="list-group">
                        <div class="list-group-item but-br">
                            <div class="media-box">
                                <div class="pull-left" style="margin:0;">
                   <span class="fa-stack" style="width:1px;">
                   </span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading text-purple text-center m0" style="line-height:22px;">
                                        #QQ : <?= $qq['qq'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item but-br">

                            <div class="media-box">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>
                                            状态：<?php if ($qq[sidzt]) {
                                            echo "<font color='red'>失效</font>";
                                        } else {
                                            echo "<font color='green'>正常</font>";
                                        } ?>/<?php if ($qq[skeyzt]) {
                                            echo "<font color='red'>失效</font>";
                                        } else {
                                            echo "<font color='green'>正常</font>";
                                        } ?>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>所属用户： <?php
                                        $users = $db->query("select user from {$prefix}users where uid='" . $qq[uid] . "' limit 1");
                                        $users = $users->fetch(PDO::FETCH_ASSOC);
                                        echo $users['user'];
                                        ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>添加时间：<?= $qq[addtime] ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>skey：<?= $qq['skey'] ?></small>
                                    </div>
                                </div>
                            </div>
							<div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>p_skey：<?= $qq['p_skey'] ?></small>
                                    </div>
                                </div>
                            </div>
							<div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>MD5QQ密码：<?= $qq['pwd'] ?></small>
                                    </div>
                                </div>
                            </div>
                             <br>
                    <div class="panel-footer clearfix">
                        <a href="?do=del&p=<?= $p ?>&uid=<?= $user[uid] ?>" title="用户配置"
                           class="btn btn-square btn-primary btn-block btn-xs">删除</a>
                    </div>
                </div>
            </div>
			  </div>
                </div>
            </div>
			<?php } ?>
			<?php if ($pagedo != 'seach') { ?>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-lg-2">
                                <form action="?" method="GET">
                                    <div class="input-group">
                                        <input type="hidden" name="do" value="search">
                                        <input type="text" name='s' placeholder="QQ qid、QQ账号" class="form-control">
		<span class="input-group-btn">
		<input type="submit" class="btn btn-primary" value="搜索">
		</span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8"></div>
                            <div class="col-lg-2 text-right">
                                <ul class="pagination pagination-sm">
                                    <li <?php if ($p == 1) {
                                        echo 'class="disabled"';
                                    } ?>><a href="?p=1">首页</a></li>
                                    <li <?php if ($prev == $p) {
                                        echo 'class="disabled"';
                                    } ?>><a href="?p=<?= $prev ?>">&laquo;</a></li>
                                    <?php for ($i = $p; $i <= $pp; $i++) { ?>
                                        <li <?php if ($i == $p) {
                                            echo 'class="active"';
                                        } ?>><a href="?p=<?= $i ?>"><?= $i ?></a></li>
                                    <?php } ?>
                                    <li <?php if ($next == $p) {
                                        echo 'class="disabled"';
                                    } ?>><a href="?p=<?= $next ?>">&raquo;</a></li>
                                    <li <?php if ($p == $pages) {
                                        echo 'class="disabled"';
                                    } ?>><a href="?p=<?= $pages ?>">末页</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
<?php } ?>
                
<?php
include_once 'common.foot.php';
?>