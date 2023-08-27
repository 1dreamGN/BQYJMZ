<?php
require_once('common.php');
C('webtitle', '网站管理后台');
C('pageid', 'index');
$index = '1';
include_once 'common.head.php';
$dt = round(@disk_total_space(".") / (1024 * 1024 * 1024), 3); //总
$df = round(@disk_free_space(".") / (1024 * 1024 * 1024), 3); //可用
$du = $dt - $df; //已用
$hdPercent = (floatval($dt) != 0) ? round($du / $dt * 100, 2) : 0;
if ($_GET['do'] == "clearqq") {
    $db->query("delete from {$prefix}qqs where skeyzt='1' or sidzt='1'");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clear_km_yes") {
    $db->query("delete from {$prefix}kms where isuse='1'");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clear_km_no") {
    $db->query("delete from {$prefix}kms where isuse<>'1'");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clear_km_all") {
    $db->query("delete from {$prefix}kms where 1");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clearnovip") {
    $qqss = $db->query("select * from {$prefix}qqs where 1");
    while ($rowqqs = $qqss->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $db->query("select * from {$prefix}users where uid='{$rowqqs[uid]}' limit 1");
        if ($user_qqs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!get_isvip($user_qqs['vip'], $user_qqs['vipend'])) {
                $db->query("delete from {$prefix}users where uid='{$rowqqs[uid]}'");
            }
        }
    }
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clearnovip_us") {
    $users = $db->query("select * from {$prefix}users where 1");
    while ($rowusers = $users->fetch(PDO::FETCH_ASSOC)) {
        if (!get_isvip($rowusers['vip'], $rowusers['vipend'])) {
            $db->query("delete from {$prefix}users where uid='{$rowusers[uid]}'");
        }
    }
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
} elseif ($_GET['do'] == "clearnoadd_us") {
    $users = $db->query("select * from {$prefix}users where 1");
    while ($rowusers = $users->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $db->query("select * from {$prefix}qqs where uid='{$rowusers[uid]}' limit 1");
        if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
            $db->query("delete from {$prefix}users where uid='{$rowusers[uid]}'");
        }
    }
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
}
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">网站管理后台</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <em class="fa fa-users fa-5x"></em>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="text-lg"><?= get_count('users', "1=:1", "uid", array(":1" => "1")) ?></div>
                            <p class="m0">网站用户数</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="panel-footer bg-gray-dark bt0 clearfix btn-block">
                    <span
                        class="pull-left">今日注册：<?= get_count('users', "adddate=:date", "uid", array(":date" => date("Y-m-d"))) ?>
                        个 Vip会员：<?= get_count('users', "vip=:1", "uid", array(":1" => "1")) ?>
                        个 普通：<?= get_count('users', "vip<>:1", "uid", array(":1" => "1")) ?>个</span>
                        <span class="pull-right">
                           <em class="fa fa-chevron-circle-right"></em>
                        </span>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <em class="fa fa-qq fa-5x"></em>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="text-lg"><?= get_count('qqs', "1=:1", "qid", array(":1" => "1")) ?></div>
                            <p class="m0">网站挂机数</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="panel-footer bg-gray-dark bt0 clearfix btn-block">
                    <span
                        class="pull-left">今日添加：<?= get_count('qqs', "adddate=:date", "qid", array(":date" => date("Y-m-d"))) ?>
                        个 正常：<?= get_count('qqs', "skeyzt=:0 and sidzt=:0", "qid", array(":0" => "0")) ?>
                        个 已失效：<?= get_count('qqs', "skeyzt=:1 or sidzt=:1", "qid", array(":1" => "1")) ?>个</span>
                        <span class="pull-right">
                           <em class="fa fa-chevron-circle-right"></em>
                        </span>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <em class="fa fa-tasks fa-5x"></em>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="text-lg"><?= get_count('kms', "1=:1", "kid", array(":1" => "1")) ?></div>
                            <p class="m0">生成卡密数</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="panel-footer bg-gray-dark bt0 clearfix btn-block">
                    <span class="pull-left">Vip：<?= get_count('kms', "kind=:1", "kid", array(":1" => "1")) ?>
                        个 配额：<?= get_count('kms', "kind=:2", "kid", array(":2" => "2")) ?>
                        个 已用：<?= get_count('kms', "isuse=:1", "kid", array(":1" => "1")) ?>
                        个 未用：<?= get_count('kms', "isuse<>:1", "kid", array(":1" => "1")) ?>个</span>
                        <span class="pull-right">
                           <em class="fa fa-chevron-circle-right"></em>
                        </span>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <em class="fa fa-support fa-5x"></em>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="text-lg"><?= get_count('separate', "1=:1", "fid", array(":1" => "1")) ?></div>
                            <p class="m0">下级分站数</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="panel-footer bg-gray-dark bt0 clearfix btn-block">
                    <span class="pull-left">挂机状态正常数：<?= get_count('separate', "endtime>" . date("Y-m-d") . " and zt=:1", "fid", array(":1" => "1")) ?>个</span>
                        <span class="pull-right">
                           <em class="fa fa-chevron-circle-right"></em>
                        </span>
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="list-group-item bg-info">
                    快捷操作
                </div>
                <div class="panel-body">
                    <div class="btn-group mb-sm">
                        <button type="button" data-toggle="dropdown" class="btn btn-info"
                                aria-expanded="false">卡密管理
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="?do=clear_km_yes">清空已用卡密</a>
                            </li>
                            <li><a href="?do=clear_km_no">清空未用卡密</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="?do=clear_km_all">清空所有卡密</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group mb-sm">
                        <button type="button" data-toggle="dropdown" class="btn btn-danger"
                                aria-expanded="false">QQ管理
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="?do=clearqq">清空已失效QQ</a>
                            </li>
                            <li><a href="?do=clearnovip">清空非Vip的QQ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group mb-sm">
                        <button type="button" data-toggle="dropdown" class="btn btn-success"
                                aria-expanded="false">用户管理
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="?do=clearnovip_us">清理非Vip用户</a>
                            </li>
                            <li><a href="?do=clearnoadd_us">清理没有添加QQ的用户</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    监控说明
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                监控项目
                            </th>
                            <th>
                                监控频率
                            </th>
                            <th>
                                监控地址
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                秒赞监控
                            </td>
                            <td>
                                按频率计算
                            </td>
                            <td>
                                <?php
                                for ($i = 1; $i <= C('zannet'); $i++) {
                                    $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/zan.cron.php?cron=' . C('cronrand') . '&n=' . $i;
                                    echo $data . "<br>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                秒评监控
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                for ($i = 1; $i <= C('replynet'); $i++) {
                                    $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/reply.cron.php?cron=' . C('cronrand') . '&n=' . $i;
                                    echo $data . "<br>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                转发监控
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                for ($i = 1; $i <= C('zfnet'); $i++) {
                                    $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/zf.cron.php?cron=' . C('cronrand') . '&n=' . $i;
                                    echo $data . "<br>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                自动说说
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                for ($i = 1; $i <= C('shuonet'); $i++) {
                                    $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/shuo.cron.php?cron=' . C('cronrand') . '&n=' . $i;
                                    echo $data . "<br>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                自动更新
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/cron.func.php?cron=' . C('cronrand');
                                echo $data;
                                ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                钱包签到
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/qbqd.cron.php?cron=' . C('cronrand');
                                echo $data;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                其他签到
                            </td>
                            <td>
                                1分钟
                            </td>
                            <td>
                                <?php
                                $data = 'http://' . $_SERVER['HTTP_HOST'] . '/QQTask/task.cron.php?cron=' . C('cronrand');
                                echo $data;
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="list-group-item bg-success">函数检测</div>
                <div class="panel-body">
                    被禁用函数：<?= ("" == ($disFuns = get_cfg_var("disable_functions"))) ? "无" : str_replace(",", "<br />", $disFuns) ?>
                    <br><br>
                    php运行方式：<?php echo $_SERVER['SERVER_SOFTWARE']; ?><br><br>
                    服务器IP：<?php echo $_SERVER['SERVER_NAME']; ?>(<?php if ('/' == DIRECTORY_SEPARATOR) {
                        echo $_SERVER['SERVER_ADDR'];
                    } else {
                        echo @gethostbyname($_SERVER['SERVER_NAME']);
                    } ?>)<br><br>
                    操作系统：<?php $os = explode(" ", php_uname());
                    echo $os[0]; ?> &nbsp;内核版本：<?php if ('/' == DIRECTORY_SEPARATOR) {
                        echo $os[2];
                    } else {
                        echo $os[1];
                    } ?><br><br>
                    总空间：<?php echo $dt; ?>&nbsp;G，
                    已用：<font color='#333333'><span id="useSpace"><?php echo $du; ?></span></font>&nbsp;G，
                    空闲：<font color='#333333'><span id="freeSpace"><?php echo $df; ?></span></font>&nbsp;G，
                    使用率：<span id="hdPercent"><?php echo $hdPercent; ?></span>%
                    <br><br>
                    Cookies支持：<?php echo isset($_COOKIE) ? '<font color="green">√</font>' : '<font color="red">×</font>'; ?>
                    <br><br>
                    PHP 版本：</b><?php echo phpversion() ?><?php if (ini_get('safe_mode')) {
                        echo '线程安全';
                    } else {
                        echo '非线程安全';
                    } ?><br><br>
                    程序最大运行时间：<?php echo ini_get('max_execution_time') ?>s<br><br>
                    POST许可：<?php echo ini_get('post_max_size'); ?><br><br>
                    文件上传许可：<?php echo ini_get('upload_max_filesize'); ?><br>
                </div>
            </div>
            <div class="panel panel-default">
                <ul class="list-group sortable">
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em class="<?php
                        $ver = phpversion();
                        if ($ver < 5.3) {
                            echo 'fa fa-fw fa-times mr';
                        } else {
                            echo 'fa fa-fw fa-check mr';
                        }
                        ?>"></em>空间要求 php版本5.3
                    </li>
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em
                            class="<?php echo checkfunc('curl_exec', true); ?>"></em>访问网页 获取信息
                    </li>
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em
                            class="<?php echo checkfunc('file_get_contents', true); ?>"></em>读取文件 读取信息权限
                    </li>
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em
                            class="<?php echo checkclass('ZipArchive'); ?>"></em>ZIP解压 后台在线升级
                    </li>
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em
                            class="<?php if (is_writable('./')) {
                                echo 'fa fa-fw fa-check mr';
                            } else {
                                echo 'fa fa-fw fa-times mr';
                            } ?>"></em>写入文件(1/2)
                    </li>
                    <li class="list-group-item" role="option" aria-grabbed="false" draggable="true"><em
                            class="<?php echo checkfunc('file_put_contents'); ?>"></em>写入文件(2/2)
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php
include_once 'common.foot.php';
?>