<?php
require_once('common.php');
C('webtitle', '邀请注册');
C('pageid', 'reginfo');
include_once 'core.head.php';
$dates = date('Y-m-d');
if($_POST['do'] == 'reg'){
    if(get_isvip($userrow['vip'], $userrow['vipend'])){
        exit("<script language='javascript'>alert('您已是VIP会员,VIP用户无法参与本活动');history.go(-1);</script>");
    }else{
        $num = get_count('reg', 'uid=:uid', 'id', array(':uid' => $userrow['uid']));
        if($num > 0x000004){
            if($userrow['vip'] != 1){
                $vipend = date('Y-m-d', strtotime('+ 3 day', strtotime($userrow['vipend'])));
                $db -> query("update {$prefix}users set vipend='$vipend' where uid='" . $userrow['uid'] . "'");
            }else{
                $vipstart = date('Y-m-d');
                $vipend = date('Y-m-d', strtotime('+ 3 day'));
                $db -> query("update {$prefix}users set vip='1',vipstart='$vipstart',vipend='$vipend' where uid='" . $userrow['uid'] . "'");
            }
            exit("<script language='javascript'>alert('恭喜本次获得VIP3日体验');history.go(-1);</script>");
        }else{
            exit("<script language='javascript'>alert('您今日的任务尚未完成,暂不能领取当然奖励哦！');history.go(-1);</script>");
        }
    }
}
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">邀请注册</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">邀请好友提示</div>
          <div class="panel-wrapper">
              <div class="list-group-item">
                  <p>通过推广地址每天邀请<kbd>5人</kbd>注册即可领取3天VIP!</p>

<?php
 if(get_isvip($userrow['vip'], $userrow['vipend'])){
    echo '<p>系统检测到您已是VIP用户,强行邀请无法领取该奖励！</p>';
}
?>
				  <hr>
                  <p><code>您的专属推广地址：</code>
                  </p>
                  <p class="bg-info-light" style="padding: 10px;">http://<?php echo $domain?>/Function/Index/reg.php?uid=<?php echo $userrow['uid']?></p>
                  <p>把以上链接发给您的好友、朋友圈、QQ群、贴吧邀请网友进行注册登陆使用。</p>
                  <p>被邀请注册的好友会获取<kbd>7天</kbd>的VIP体验资格！您也可以从中获得积分奖励！</p>
                  <p class="text-danger">注意：全程有记录，恶意刷邀请量将作封号处理，且行且珍惜！</p>
              </div>
          </div>
      </div>

      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">奖励领取</div>
          <div class="panel-wrapper">
          <form action="?" method="post" class="form-horizontal ng-pristine ng-valid">
            <div class="list-group-item bb">
                <div class="input-group">
                    <span class="fa fa-th-list" aria-hidden="true"> 总邀请人数:<?php echo $userrow['yq']?>人</span>
                    <span class="fa fa-th-list" aria-hidden="true" style="margin-left:10px;"> 系统实时记录已邀请人数:<?php echo get_count('reg', 'uid=:uid', 'id', array(':uid' => $row['uid']))?>人</span>
                </div>
            </div>

            <div class="list-group-item">
			<input type="hidden" name="do" value="reg">
				<input type="submit" name="submit" value="点此领取" class="btn btn-primary btn-block">
            </div>

          </form>
          </div>
      </div>
</div>
<div class="col-md-6">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">推广达人排行榜前20</div>
          <div class="panel-wrapper">
              <table class="table table-bordered">
                  <tbody>

<?php
$rowss = $db -> query("select * from {$prefix}users where 1=1 order by yq desc limit 20");
while($row = $rowss -> fetch(PDO :: FETCH_ASSOC)){
    $i = $i + 0x001;
    ?>
                  <tr>
                          <td style="padding-left:8px;"><span class="fa fa-user"></span>&nbsp;&nbsp;<font color="#FF3399"><?php echo $row['user']?></font>邀请了<font color="#FF3399"><?php echo $row['yq']?></font>人</td>
                  </tr>

<?php }
?>
					  </tbody>
              </table>
          </div>
      </div>
 </div>
</div>
</div>
<?php
include_once 'core.foot.php';
?>