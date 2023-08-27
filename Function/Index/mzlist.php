<?php
require_once('common.php');
C('webtitle', 'CQY交友墙');
C('pageid', 'mzlist');
include_once 'core.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">CQY交友墙</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="row">
<div class="col-md-12">
      <div class="panel panel-primary">
          <div class="panel-heading portlet-handler ui-sortable-handle">交友墙提示</div>
          <div class="panel-wrapper">
              <div class="list-group-item bb">本页面展示最近更新状态的300个秒赞QQ号</div>
              <div class="list-group-item">手机用户点击按钮无效请手动复制QQ号进行添加好友~</div>
          </div>
      </div>
  </div>
<div class="col-md-12">
    <!-- START panel-->
    <div id="panelDemo14" class="panel panel-default">
          <div role="tabpanel">
             <!-- Tab panes-->
             <div class="tab-content">
                <div role="tabpanel" class="tab-pane js active">
                   <table class="table table-striped">
                      <tbody>


<?php
 $rowss = $db -> query("select * from {$prefix}users where 1=1 order by uid desc limit 200");
while($row = $rowss -> fetch(PDO :: FETCH_ASSOC)){
    ?>
                         <tr>
                            <td class="text-center">
                                <img src="http://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $row['qq']?>&amp;spec=100" alt="avatar" class="img-circle thumb64">
                            </td>
                            <td style="padding:8px 0;">
                               <?php echo $row['qq']?><br><small><?php echo $row['addtime']?></small>
                            </td>
                            <td>
                               <a target="_blank" href="tencent://AddContact/?fromId=45&amp;fromSubId=1&amp;subcmd=all&amp;uin=<?php echo $row['qq']?>&amp;website=<?php echo $domain?>" class="btn btn-square btn-primary btn-xs mb-sm" style="font-size:12px;">加好友</a>
                               <a target="_blank" href="http://<?php echo $row['qq']?>.qzone.qq.com" class="btn btn-square btn-primary btn-xs mb-sm" style="font-size:12px;">看空间</a>
                               <a target="_blank" href="mzrz.php?qq=<?php echo $row['qq']?>" class="btn btn-square btn-primary btn-xs mb-sm" style="font-size:12px;">秒赞认证</a>
                            </td>
                         </tr>

<?php }
?>
						 </tbody>
                   </table>

                </div>
             </div>
          </div>
    </div>


    <!-- END panel-->
 </div>
</div>

<?php
include_once 'core.foot.php';
?>