<?php
require_once('common.php');
$uid = is_numeric($_GET['uid']) ? $_GET['uid'] : '0';
if ($_GET['do'] == 'del') {
    $db->query("delete from {$prefix}users where uid='$uid'");
    echo "<script language='javascript'>alert('删除成功！');window.location.href='ulist.php';</script>";
} elseif ($_GET['do'] == 'dell') {
    $db->query("delete from {$prefix}users where vip='0'");
    echo "<script language='javascript'>alert('删除成功！');window.location.href='ulist.php';</script>";
} elseif ($_GET['do'] == 'daili') {
    $stmt = $db->query("select daili from {$prefix}users where uid='$uid'");
    if ($uid && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['daili']) {
            $db->query("update {$prefix}users set daili=0 where uid='{$uid}'");
            echo "<script language='javascript'>alert('取消代理成功！');window.location.href='ulist.php';</script>";
        } else {
            $db->query("update {$prefix}users set daili=1 where uid='{$uid}'");
            echo "<script language='javascript'>alert('设为代理成功！');window.location.href='ulist.php';</script>";
        }
    }
} elseif ($_GET['do'] == 'fuzhan') {
    $stmt = $db->query("select fuzhan from {$prefix}users where uid='$uid'");
    if ($uid && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['fuzhan']) {
            $db->query("update {$prefix}users set fuzhan=0 where uid='{$uid}'");
            echo "<script language='javascript'>alert('取消副站长成功！');window.location.href='ulist.php';</script>";
        } else {
            $db->query("update {$prefix}users set fuzhan=1 where uid='{$uid}'");
            echo "<script language='javascript'>alert('设为副站长成功！');window.location.href='ulist.php';</script>";
        }
    }
}
$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp = $p + 8;
$pagesize = 12;
$start = ($p - 1) * $pagesize;
if ($_GET['do'] == 'search' && $s = safestr($_GET['s'])) {
    $pagedo = 'seach';
    $users = $db->query("select * from {$prefix}users where uid='{$s}' or user like'%{$s}%' order by (case when uid='{$s}' then 8 else 0 end)+(case when user like '%{$s}%' then 3 else 0 end) desc limit 20");
} else {
    $pages = ceil(get_count('users', '1=:1', 'uid', array(":1" => "1")) / $pagesize);
    $users = $db->query("select * from {$prefix}users order by uid desc limit $start,$pagesize");
}
if ($_GET['c'] == "daili") $users = $db->query("select * from {$prefix}users where daili='1' order by uid desc limit $start,$pagesize");
if ($_GET['c'] == "fuzhan") $users = $db->query("select * from {$prefix}users where fuzhan='1' order by uid desc limit $start,$pagesize");
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
C('pageid', 'adminuser');
C('webtitle', '用户列表');
include_once 'common.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3"><?=C('webtitle')?></h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
        <?php while ($user = $users->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?= $user['qq'] ?>&amp;spec=100" width="80"
                                 height="80" class="img-circle circle-border m-t-xxs" alt="profile">
                            <h4 class="font-bold no-margins"><?= $user['user'] ?></h4>
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
                                        #ID : <?= $user['uid'] ?>
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
                                            配额信息：已用<b><?= get_count('qqs', "uid=:uid", 'qid', array(":uid" => $user['uid'])) ?></b>个，共有<b><?= $user['peie'] ?></b>个
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
                                        <small>用户类型：<?php if (get_isvip($user['vip'], $user['vipend'])) {
                                                echo "包月VIP";
                                            } else {
                                                echo "免费用户";
                                            } ?>&nbsp;<?= $user['vipend'] ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>剩余余额：<?= $user['rmb'] ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>QQ账号：<?= $user['qq'] ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>
                                            <a href="?do=daili&p=<?= $p ?>&uid=<?= $user[uid] ?>"
                                               onClick="if(!confirm('确认更改？')){return false;}"
                                               class="btn btn-default btn-xs"><?php if ($user[daili]) {
                                                    echo '取消代理';
                                                } else {
                                                    echo '设为代理';
                                                } ?></a>
                                            <a href="?do=fuzhan&p=<?= $p ?>&uid=<?= $user[uid] ?>"
                                               onClick="if(!confirm('确认更改？')){return false;}"
                                               class="btn btn-default btn-xs"><?php if ($user[fuzhan]) {
                                                    echo '取消副站长';
                                                } else {
                                                    echo '设为副站长';
                                                } ?></a></small>
                                    </div>
                                </div>
                            </div>

                            <div class="media-box" style="margin-top:6px;">
                                <div class="pull-left" style="margin:auto 5px;">
                                    <span class="circle circle-success circle-lg text-left"></span>
                                </div>
                                <div class="media-box-body clearfix">
                                    <div class="media-box-heading m0">
                                        <small>等级权限：<?php
                                            if ($user[fuzhan] == 1) {
                                                echo '副站长 ';
                                            }
                                            if ($user[daili] == 1) {
                                                echo '代理 ';
                                            }
                                            if ($user[daili] == 0 && $user[fuzhan] == 0) {
                                                echo '普通用户';
                                            }
                                            ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        <a href="uset.php?xz=update&uid=<?= $user[uid] ?>" title="用户配置"
                           class="btn btn-square btn-primary btn-block btn-xs">编辑</a>
                        <a href="?do=del&p=<?= $p ?>&uid=<?= $user[uid] ?>" title="用户配置"
                           class="btn btn-square btn-primary btn-block btn-xs">删除</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php if ($pagedo != 'seach') { ?>
    <div class="panel-footer">
        <div class="row">
            <div class="col-lg-2">
                <form action="?" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="do" value="search">
                        <input type="text" name='s' placeholder="用户uid、用户名" class="form-control">
		<span class="input-group-btn">
		<input type="submit" class="btn btn-primary" value="搜索">
		</span>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
                <form action="?" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="do" value="daili">
                        <input type="text" name='uid' placeholder="用户uid" class="form-control">
		<span class="input-group-btn">
		<input type="submit" class="btn btn-primary" value="设为代理">
		</span>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
                <form action="?" method="GET">
                    <div class="input-group">
                        <input type="hidden" name="do" value="fuzhan">
                        <input type="text" name='uid' placeholder="用户uid" class="form-control">
		<span class="input-group-btn">
		<input type="submit" class="btn btn-primary" value="设为副站长">
		</span>
                    </div>
                </form>
            </div>
            <div class="col-lg-4"></div>
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