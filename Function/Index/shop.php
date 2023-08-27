<?php
require_once('common.php');
if($do = $_POST['do']){
    if($do == 'shop'){
        $shop = is_numeric($_POST['shop'])?$_POST['shop']:'0';
        if($shop == 99){
            $rmb = C('price_1dvip');
            $buyms = 1;
            $buyday = 1;
        }elseif($shop == 1){
            $rmb = C('price_1vip');
            $buyms = 1;
        }elseif($shop == 2){
            $rmb = C('price_3vip');
            $buyms = 3;
        }elseif($shop == 3){
            $rmb = C('price_6vip');
            $buyms = 6;
        }elseif($shop == 4){
            $rmb = C('price_12vip');
            $buyms = 12;
        }elseif($shop == 5){
            $rmb = C('price_1peie');
            $buypeie = 1;
        }elseif($shop == 6){
            $rmb = C('price_3peie');
            $buypeie = 3;
        }elseif($shop == 7){
            $rmb = C('price_5peie');
            $buypeie = 5;
        }elseif($shop == 8){
            $rmb = C('price_10peie');
            $buypeie = 10;
        }else{
            exit("<script language='javascript'>alert('请先选择你需要购买 的商品！');history.go(-1);</script>");
        }
        if($userrow['rmb'] < $rmb){
            echo"<script language='javascript'>alert('余额不足，请联系QQ" . C('webqq') . "充值！');</script>";
        }else{
            if($buyms){
                if(get_isvip($userrow['vip'], $userrow['vipend'])){
                    if($buyday){
                        $vipend = date('Y-m-d', strtotime("+ $buyday days", strtotime($userrow['vipend'])));
                        echo"<script language='javascript'>alert('成功续费{$buyms}天VIP');</script>";
                    }else{
                        $vipend = date('Y-m-d', strtotime("+ $buyms months", strtotime($userrow['vipend'])));
                        echo"<script language='javascript'>alert('成功续费{$buyms}个月VIP');</script>";
                    }
                    $db -> query("update {$prefix}users set rmb=rmb-{$rmb},vip=1,vipend='{$vipend}' where uid='{$userrow[uid]}'");
                }else{
                    if($buyday){
                        $vipend = date('Y-m-d', strtotime("+ $buyday days"));
                        echo"<script language='javascript'>alert('成功开通{$buyday}天VIP');</script>";
                    }else{
                        $vipend = date('Y-m-d', strtotime("+ $buyms months"));
                        echo"<script language='javascript'>alert('成功开通{$buyms}个月VIP');</script>";
                    }
                    $db -> query("update {$prefix}users set rmb=rmb-{$rmb},vip=1,vipstart='" . date('Y-m-d') . "',vipend='{$vipend}' where uid='{$userrow[uid]}'");
                }
            }elseif($buypeie){
                $db -> query("update {$prefix}users set rmb=rmb-{$rmb},peie=peie+$buypeie where uid='{$userrow[uid]}'");
                echo"<script language='javascript'>alert('成功购买{$buypeie}个配额');</script>";
            }
            $userrow = get_results("select * from {$prefix}users where uid=:uid limit 1", array(':uid' => $uid));
        }
    }
}
C('webtitle', '自助商城');
C('pageid', 'shop');
include_once 'core.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">自助购买</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">

        <div class="col-md-6">
            <div class="panel panel-default panel-demo">
                <div class="panel-heading">
                    <div class="panel-title">
                        平台公告
                    </div>
                </div>
                <div class="panel-body bg-gonggao-p">
                    <div class="col-lg-12 bg-gonggao">
                        <?php echo stripslashes(C('web_shop_gg'))?>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    自助购买
                </div>
                <div class="panel-body">
                    <form action="?" role="form" class="form-horizontal" method="post">
                        <input type="hidden" name="do" value="shop">
                        <div class="form-group">
                            <div class="col-lg-2 control-label">
                                我的会员
                            </div>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" placeholder="
<?php if(get_isvip($userrow['vip'], $userrow['vipend'])){
    echo $userrow['vipend'];
}else{
    echo'不是VIP';
}
?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2 control-label">
                                当前余额
                            </div>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" placeholder="<?php echo $userrow['rmb']?>" readonly>
                            </div>
                        </div>
						<div class="form-group">
                            <div class="col-lg-2 control-label">
                                我的配额
                            </div>
                            <div class="col-lg-10">
                                <input class="form-control" type="text" placeholder="<?php echo $userrow['peie']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">购买服务</label>
                            <div class="col-lg-10">
                                <select multiple="multiple" class="form-control m-bot15" name="shop">
                                    <option value='99'>
                                        1天试用VIP(<?php echo C('price_1dvip')?>
                                        元)
                                    </option>
                                    <option value='1'>
                                        1个月VIP(<?php echo C('price_1vip')?>
                                        元)
                                    </option>
                                    <option value='2'>
                                        3个月VIP(<?php echo C('price_3vip')?>
                                        元)
                                    </option>
                                    <option value='3'>
                                        6个月VIP(<?php echo C('price_6vip')?>
                                        元)
                                    </option>
                                    <option value='4'>
                                        12个月VIP(<?php echo C('price_12vip')?>
                                        元)
                                    </option>
                                    <option value='5'>
                                        1个配额(<?php echo C('price_1peie')?>
                                        元)
                                    </option>
                                    <option value='6'>
                                        3个配额(<?php echo C('price_3peie')?>
                                        元)
                                    </option>
                                    <option value='7'>
                                        5个配额(<?php echo C('price_5peie')?>
                                        元)
                                    </option>
                                    <option value='8'>
                                        10个配额(<?php echo C('price_10peie')?>
                                        元)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <input type="submit" name="submit" value="确认购买" class="btn btn-info btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>



<?php
include_once 'core.foot.php';
?>