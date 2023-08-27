<?php
require_once('common.php');
if($_POST['do'] == 'rmb'){
    $km = safestr($_POST['km']);
    $stmt = $db -> query("select * from {$prefix}kms where km='" . $km . "' limit 1");
    if(!$row = $stmt -> fetch(PDO :: FETCH_ASSOC)){
        echo "<script language='javascript'>alert('充值卡卡密不存在！');</script>";
    }elseif($row['isuse']){
        echo "<script language='javascript'>alert('该充值卡卡密已使用！');</script>";
    }else{
        $now = date('Y-m-d H:i:s');
        $db -> query("update {$prefix}kms set isuse=1,uid='{$userrow[uid]}',usetime='$now' where kid='{$row['kid']}'");
        $db -> query("update {$prefix}users set rmb=rmb+$row[ms] where uid='{$userrow[uid]}'");
        $userrow['rmb'] = $userrow['rmb'] + $row[ms];
        echo "<script language='javascript'>alert('成功充值{$row['ms']}元！');</script>";
    }
}
C('webtitle', '在线充值');
C('pageid', 'rmb');
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
<div class="col-md-12">
    <div class="panel panel-default panel-demo">
       <div class="panel-heading">
          <div class="panel-title">平台公告</div>
       </div>
       <div class="panel-body bg-gonggao-p">
          <div class="col-lg-12 bg-gonggao">
		  <?php echo stripslashes(C('web_rmb_gg'))?>
		  </div>
       </div>
    </div>
  </div>
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">VIP会员开通</div>
          <div class="panel-wrapper">
              <div class="list-group-item bb">1、开通VIP可使用本站所有功能，无任何限制，可加入VIP售后群享受后续服务。</div>
            <div class="list-group-item but-br">
            <p>请选择付款方式：</p>

                <a href="<?php echo C('kmurl')?>" class="btn btn-danger btn-block">发卡平台</a>

            </div>


            <div class="list-group-item">
                <span style="font-size:10px; color:#999;">发卡平台24小时自助提卡，付款后自动发邮件，无需等待。</span>
            </div>

          </div>
      </div>
  </div>
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">使用卡密</div>
          <div class="panel-wrapper">
		  <form action="?" role="form" class="form-horizontal ng-pristine ng-valid" method="post">
          <input type="hidden" name="do" value="rmb">
            <div class="list-group-item bb" id="load">
                除代挂卡密外，其它卡密均可以在此使用，代挂卡密请在添加代挂页面使用
            </div>

            <div class="list-group-item bb">
                <div class="input-group">
                  <div class="input-group-addon">卡密</div>
                  <input type="text" class="form-control" name="km" value="" placeholder="请输入卡密">
                </div>
            </div>
            <div class="list-group-item">
                <input type="submit" name="submit" value="确认使用" class="btn btn-primary btn-block">
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