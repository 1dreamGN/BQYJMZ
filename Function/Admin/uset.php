<?php
require_once('common.php');
$uid = is_numeric($_GET['uid']) ? $_GET['uid'] : '0';
$stmt = $db->query("select * from {$prefix}users where uid='$uid' limit 1");
if (!$uid || !$user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    exit("<script language='javascript'>alert('用户不存在！');window.location.href='ulist.php';</script>");
}
if ($do = $_POST['do']) {
    $rmb = is_numeric($_POST['rmb']) ? $_POST['rmb'] : '0';
    if ($do == 'update') {
        $vip = is_numeric($_POST['vip']) ? $_POST['vip'] : '0';
        $qq = is_numeric($_POST['qq']) ? $_POST['qq'] : '0';
        $peie = is_numeric($_POST['peie']) ? $_POST['peie'] : '0';
        $vipend = safestr($_POST['vipend']);
        $set = "rmb='{$rmb}',qq='{$qq}',vip='{$vip}',peie='{$peie}',vipend='{$vipend}'";
        if ($_POST['pwd']) {
            $pwd = md5(md5($_POST['pwd']) . md5('1340176819'));
            $set .= ",pwd='{$pwd}'";
        }
        $db->query("update {$prefix}users set {$set} where uid='$uid'");
        echo "<script language='javascript'>alert('修改成功');window.location.href='ulist.php';</script>";
    } elseif ($do == 're') {
        $db->query("update {$prefix}users set rmb=rmb+{$rmb} where uid='$uid'");
        echo "<script language='javascript'>alert('成功充值{$rmb}元');window.location.href='ulist.php';</script>";
    } elseif ($do == 'cut') {
        $db->query("update {$prefix}users set rmb=rmb-{$rmb} where uid='$uid'");
        echo "<script language='javascript'>alert('成功扣取{$rmb}元');window.location.href='ulist.php';</script>";
    } elseif ($do == 'vip') {
        $ms = is_numeric($_POST['ms']) ? $_POST['ms'] : '1';
        if (get_isvip($user[vip], $user[vipend])) {
            $vipend = date("Y-m-d", strtotime("+ $ms months", strtotime($user[vipend])));
            $db->query("update {$prefix}users set vip=1,vipend='{$vipend}' where uid='$uid'");
            echo "<script language='javascript'>alert('成功为他续费{$ms}个月VIP');window.location.href='ulist.php';</script>";
        } else {
            $vipend = date("Y-m-d", strtotime("+ $ms months"));
            $db->query("update {$prefix}users set vip=1,vipstart='" . date("Y-m-d") . "',vipend='{$vipend}' where uid='$uid'");
            echo "<script language='javascript'>alert('成功为他开通{$ms}个月VIP');window.location.href='ulist.php';</script>";
        }
    }
}
C('webtitle', $user[user] . '-用户修改');
C('pageid', 'adminuser');
include_once 'common.head.php';
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">用户修改</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading portlet-handler ui-sortable-handle">资料修改</div>
                <div class="panel-wrapper">
                    <form action="?uid=<?= $uid ?>&xz=update" role="form" class="form-horizontal ng-pristine ng-valid"
                          method="post">
                        <input type="hidden" name="do" value="update">
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">UID</div>
                                <input class="form-control" type="text" value="<?= $user['uid'] ?>" readonly>
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">用户名</div>
                                <input class="form-control" type="text" value="<?= $user['user'] ?>" readonly>
                            </div>
                        </div>
						<div class="list-group-item bb">
						<div class="form-group">
									<div class="col-sm-9 checkbox i-checks">
										
											<label class="i-checks">
												<input type="radio" name="vip" value="0" checked=""><i></i> 普通用户 
											</label>
											<label class="i-checks">
												<input type="radio" name="vip" value="1" <?php if ($user['vip'] == 1) echo 'checked=""'; ?>><i></i>
												VIP会员 
											</label>
										
									</div>
								</div>

</div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">VIP到期时间</div>
                                <input class="form-control" type="text" name="vipend" value="<?= $user['vipend'] ?>">
                            </div>
                        </div>
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">配额(个)</div>
                                <input class="form-control" type="text" name="peie" value="<?= $user['peie'] ?>">
                            </div>
                        </div>

                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">余额(元)</div>
                                <input class="form-control" type="text" name="rmb" value="<?= $user['rmb'] ?>">
                            </div>
                        </div>
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">绑定QQ</div>
                                <input class="form-control" type="text" name="qq" value="<?= $user['qq'] ?>">
                            </div>
                        </div>
                        <div class="list-group-item">
                            <button class="btn btn-primary btn-block" type="submit" name="submit" value="1">下一步</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-info">
                <div class="panel-heading portlet-handler ui-sortable-handle">账户充值</div>
                <div class="panel-wrapper">
                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">当前余额</div>
                            <input type="text" class="form-control" placeholder="<?= $user[rmb] ?>" readonly>
                            <div class="input-group-addon">￥</div>
                        </div>
                    </div>
                    <form action="?uid=<?= $uid ?>&xz=re" role="form" class="form-horizontal ng-pristine ng-valid"
                          method="post">
                        <input type="hidden" name="do" value="re">
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">充值</div>
                                <input type="text" name="rmb" class="form-control" value="1">
                                <div class="input-group-addon"><input type="submit" value="充值"></div>
                                <div class="input-group-addon">￥</div>
                            </div>
                        </div>
                    </form>


                    <form action="?uid=<?= $uid ?>&xz=re" role="form" class="form-horizontal ng-pristine ng-valid"
                          method="post">
                        <input type="hidden" name="do" value="cut">
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">扣取</div>
                                <input type="text" name="rmb" class="form-control" value="1">
                                <div class="input-group-addon"><input type="submit" value="扣取"></div>
                                <div class="input-group-addon">￥</div>
                            </div>
                        </div>
                    </form>
                    <div class="list-group-item bb">
                        <div class="input-group">
                            <div class="input-group-addon">VIP信息</div>
                            <input class="form-control" type="text"
                                   placeholder="<?php if (get_isvip($user[vip], $user[vipend])) {
                                       echo "{$user[vipend]}";
                                   } else {
                                       echo "不是VIP";
                                   } ?>" readonly>
                        </div>
                    </div>

                    <form action="?uid=<?= $uid ?>&xz=re" class="form-horizontal ng-pristine ng-valid" method="post">
                        <input type="hidden" name="do" value="vip">
                        <div class="list-group-item bb">
                            <div class="input-group">
                                <div class="input-group-addon">开通月数</div>
                                <input class="form-control" type="text" name="ms" value="1">
                            </div>
                        </div>
                        <div class="list-group-item">
                            <button class="btn btn-primary btn-block" type="submit" name="submit" value="1">确认开通
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
<?php
include_once 'common.foot.php';
?>