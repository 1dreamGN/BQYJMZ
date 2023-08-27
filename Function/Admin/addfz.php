<?php
require_once('common.php');
C('webtitle', '添加分站');
C('pageid', 'addfz');
include_once 'common.head.php';
if ($isdomain) exit("<script language='javascript'>alert('您没有总站权限');window.location.href='/Function/Admin';</script>");
if ($_GET['type'] == 'add') {
    if (!$_POST['d_name'] || !$_POST['d_url'] || !$_POST['d_qq'] || !$_POST['d_user_name'] || !$_POST['d_user_pwd'] || !$_POST['d_end']) exit("<script language='javascript'>alert('任何一项不能为空');window.location.href='addfz.php';</script>");
    $d_name = $_POST['d_name'];
    $d_url = $_POST['d_url'];
    if ($d_url == $_SERVER['HTTP_HOST']) exit("<script language='javascript'>alert('分站域名不能与主站相同');window.location.href='/Function/Admin';</script>");
    $d_qq = $_POST['d_qq'];
    $d_user_name = $_POST['d_user_name'];
    $d_user_pwd = $_POST['d_user_pwd'];
    $d_pwd = md5(md5($d_user_pwd) . md5('1340176819'));
    $endtime = $_POST['d_end'];
    $prefix = get_sz(3);
    if (get_results("select * from bqyj_separate where name=:name or urls=:url limit 1", array(":name" => $d_name, ":url" => $d_url))) exit("<script language='javascript'>alert('该分站已存在');window.location.href='addfz.php';</script>");
    $sqls = file_get_contents("../../Install/separate.sql");
    $sqls = str_replace("admin', '1', '1', null, '2020-12-30', '0', '127', '26ff3a5be026305db95aac0adc3ca352", $d_user_name . "', '1', '1', null, '2020-12-30', '0', '127', '" . $d_pwd, $sqls);
    $sqls = str_replace("bqyj_", $prefix . "_", $sqls);
    $sqls = str_replace("冰清玉洁秒赞", $d_name, $sqls);
    $sqls = str_replace("2302701417", $d_qq, $sqls);
    $sqls = str_replace("http://blog.qq-bq.cn/", $d_url, $sqls);
    $explode = explode(";", $sqls);
    $num = count($explode);
    foreach ($explode as $sql) {
        if ($sql = trim($sql)) {
            $db->query($sql);
        }
    }
    $now = date("Y-m-d");
    if ($db->query("insert into bqyj_separate (name,urls,adminname,adminpwd,kfqq,zt,prefix,addtime,endtime) values('$d_name','$d_url','$d_user_name','$d_user_pwd','$d_qq',1,'$prefix','$now','$endtime')")) exit("<script language='javascript'>alert('添加分站[$d_name]成功');window.location.href='fzlist.php';</script>");
}
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">添加分站</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-info">
            <div class="panel-heading portlet-handler ui-sortable-handle">创建一个新子站</div>
            <div class="panel-wrapper">
                <form action="?type=add" role="form" class="form-horizontal ng-pristine ng-valid" method="post">

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">绑定域名</div>
                            <input type="text" class="form-control" name="d_url"
                                   placeholder="无需加http:// 和域名最后的斜杠 例如：www.baidu.com">
                        </div>
                    </div>

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">网站名称</div>
                            <input type="text" class="form-control" name="d_name"
                                   placeholder="网站名称不建议过长，最好在14个字符内 一个汉字=2个字符">
                        </div>
                    </div>

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">站长扣扣</div>
                            <input type="text" class="form-control" name="d_qq" placeholder="联系站长的QQ号码，例如：260200057">
                        </div>
                    </div>

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">管理账号</div>
                            <input type="text" class="form-control" name="d_user_name"
                                   placeholder="管理员登陆账号，管理员名称 例如：admin">
                        </div>
                    </div>

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">管理密码</div>
                            <input type="password" class="form-control" name="d_user_pwd" placeholder="管理员登陆密码，管理员密码">
                        </div>
                    </div>

                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">到期时间</div>
                            <input type="date" class="form-control" name="d_end"
                                   value="<?= date("Y-m-d", time() + (43200 * 60)) ?>">
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
