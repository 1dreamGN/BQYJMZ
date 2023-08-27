<?php
require_once('common.php');
C('webtitle', '分站信息修改');
C('pageid', 'adminfz');
include_once 'common.head.php';
if ($isdomain) exit("<script language='javascript'>alert('您没有总站权限');window.location.href='/admin';</script>");
$d_url = $_GET['url'];
if (!$drows = get_results("select * from bqyj_separate where urls=:url limit 1", array(":url" => $d_url))) exit("<script language='javascript'>alert('该分站不存在');window.location.href='fzlist.php';</script>");
$type = $_GET['type'];
if ($type == 'del') {
    if ($db->query("delete from bqyj_separate where urls='$d_url'")) exit("<script language='javascript'>alert('分站已删除');window.location.href='fzlist.php';</script>");
} elseif ($type == 'set') {
    if (!$_POST['d_name'] || !$_POST['d_url'] || !$_POST['d_qq'] || !$_POST['d_user_pwd'] || !$_POST['d_end']) exit("<script language='javascript'>alert('任何一项不能为空');window.location.href='fzset.php?url=" . $drows['urls'] . "';</script>");
    $d_name = $_POST['d_name'];
    $d_url = $_POST['d_url'];
    $d_qq = $_POST['d_qq'];
    $endtime = $_POST['d_end'];
    $d_user_pwd = $_POST['d_user_pwd'];
    $d_pwd = md5(md5($d_user_pwd) . md5('1340176819'));
    $d_zt = $_POST['d_zt'];
    if ($d_user_pwd != $drows['adminpwd']) $db->query("update " . $drows['prefix'] . "_users set pwd='$d_pwd' where user='" . $drows['adminname'] . "'");
    if ($db->query("update bqyj_separate set name='$d_name',kfqq='$d_qq',adminpwd='$d_user_pwd',zt='$d_zt',endtime='$endtime' where urls='$d_url'")) exit("<script language='javascript'>alert('修改分站[$d_name]成功');window.location.href='fzlist.php';</script>");
}
?>
                    	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">分站信息修改</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading portlet-handler ui-sortable-handle">子站信息修改</div>
                <div class="panel-wrapper">
                    <form action="?type=set&url=<?= $drows['urls'] ?>" role="form"
                          class="form-horizontal ng-pristine ng-valid" method="post">

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">绑定域名</div>
                                <input type="text" class="form-control" name="d_url" value="<?= $drows['urls'] ?>"
                                       readonly>
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">网站名称</div>
                                <input type="text" class="form-control" name="d_name" value="<?= $drows['name'] ?>">
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">站长扣扣</div>
                                <input type="text" class="form-control" name="d_qq" value="<?= $drows['kfqq'] ?>">
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">管理账号</div>
                                <input type="text" class="form-control" name="d_user_pwd"
                                       value="<?= $drows['adminname'] ?>" readonly>
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">管理密码</div>
                                <input type="text" class="form-control" name="d_user_pwd"
                                       value="<?= $drows['adminpwd'] ?>">
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">到期时间</div>
                                <input type="date" class="form-control" name="d_end" value="<?= $drows['endtime'] ?>">
                            </div>
                        </div>
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">子站状态</div>
                                <select class="form-control" name="d_zt">

                                    <?php if ($drows['zt'] == 1) { ?>
                                        <option value="1">1_开放</option>
                                        <option value="0">0_禁止</option>
                                    <?php } else { ?>
                                        <option value="0">0_禁止</option>
                                        <option value="1">1_开放</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <button class="btn btn-primary btn-block" type="submit" name="submit" value="1">下一步</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
include_once 'common.foot.php';
?>