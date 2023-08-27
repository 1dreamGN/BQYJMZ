<?php
require_once('common.php');
C('webtitle', '分站列表');
C('pageid', 'fzlist');
include_once 'common.head.php';
if ($isdomain) exit("<script language='javascript'>alert('您没有总站权限');window.location.href='/admin';</script>");
function get_dzt($zt)
{
    if ($zt == 1) return "开放";
    else return "禁止";
}

$p = is_numeric($_GET['p']) ? $_GET['p'] : '1';
$pp = $p + 8;
$pagesize = 10;
$start = ($p - 1) * $pagesize;
$pages = ceil(get_count('separate', '1=:1', 'fid', array(":1" => "1")) / $pagesize);
if (!$pages) $pages = 1;
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
    $rows = $db->query("select * from bqyj_separate where urls='{$s}' order by (case when urls='{$s}' then 8 else 0 end) desc limit 20");
} else {
    $pages = ceil(get_count('separate', '1=:1', 'fid', array(":1" => "1")) / $pagesize);
    $rows = $db->query("select * from bqyj_separate where 1=1 order by fid desc limit $start,$pagesize");
}
$fid = is_numeric($_GET['fid']) ? $_GET['fid'] : '0';
if ($_GET['do'] == 'zt') {
    if ($fid && $row = get_results("select zt from bqyj_separate where fid=:fid", array(":fid" => $fid))) {
        if ($row['zt']) {
            $db->query("update bqyj_separate set zt=0 where fid='{$fid}'");
            echo "<script language='javascript'>alert('网站封禁成功！');window.location.href='fzlist.php';</script>";
        } else {
            $db->query("update bqyj_separate set zt=1 where fid='{$fid}'");
            echo "<script language='javascript'>alert('网站激活功！');window.location.href='fzlist.php';</script>";
        }
    }
}
$title = "分站管理";
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">分站列表</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="col-sm-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            我的分站列表
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane ng-scope active" id="yd">
                    <table class="table m-b-none default footable">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">分站名称</th>
                            <th class="text-center">绑定网址</th>
                            <th class="text-center">联系方式</th>
                            <th class="text-center">状态</th>
                            <th class="text-center">到期时间</th>
                            <th class="text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($ds = $rows->fetch(PDO::FETCH_ASSOC)) { ?>

                            <tr>
                                <td class="text-center"><?= $ds['fid'] ?></td>
                                <td class="text-center"><?= $ds['name'] ?></td>
                                <td class="text-center"><?= $ds['urls'] ?></td>
                                <td class="text-center">QQ:<?= $ds['kfqq'] ?><a
                                        href="http://wpa.qq.com/msgrd?v=3&uin=<?= $ds['kfqq'] ?>&site=qq&menu=yes">[?]</a>
                                </td>
                                <td class="text-center"><a href="?do=zt&p=<?= $p ?>&fid=<?= $ds[fid] ?>" onClick="if(!confirm('确认更改？')){return false;}" class="badge <?php if ($ds[zt]) { echo 'bg-success'; } else { echo 'bg-info'; } ?>"><?php if ($ds['zt']) { echo '正常'; } else { echo '封禁'; } ?></a></td>
                                <td class="text-center"><?= $ds['endtime'] ?></td>
                                <td class="text-center"><a href="fzset.php?url=<?= $ds['urls'] ?>" class="btn btn-xs btn-info active"><i class="fa fa-check text-active"></i> 编辑</a>&nbsp;&nbsp;&nbsp;<a href="fzset.php?type=del&url=<?= $ds['urls'] ?>" class="btn btn-xs btn-danger active" onClick="if(!confirm('确定删除？')){return false;}"><i class="fa fa-trash-o text-active"></i> 删除</a></td>
                            </tr>
                        <?php } ?>
                        <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-2">
                        <form action="?" method="GET">
                            <div class="input-group">
                                <input type="hidden" name="do" value="search">
                                <input type="text" name='s' placeholder="分站域名" class="form-control">
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

        </div>
    </div>
</div>

<?php
include_once 'common.foot.php';
?>
