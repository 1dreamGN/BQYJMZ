<?php
require_once('common.php');
C('webtitle', '聊天室');
C('pageid', 'chat');
include_once 'core.head.php';
if($_POST['infos']=="ye"){
$info=$_POST['info'];
$qid=$userrow['qq'];
$user=$userrow['user'];
$time=date("Y-m-d H:i:s");
	if($info==""){
    exit("<script language='javascript'>alert('喂喂，说话啊。⊙△⊙？【请输入信息】');window.location.href='/Mz';</script>");
	}else{
		if($db->query("INSERT INTO `{$prefix}chat` (`id`, `uid`, `user`, `info`, `time`, `qid`) VALUES (NULL, '{$row[uid]}', '$user', '$info', '$time', '$qid')")){

				}
			}
}
if($_GET['do']=="info"){
$id = $_GET['id'];
	if($userrow['active']!=9){
		exit("<script language='javascript'>alert('权限不足！');window.location.href='/Mz';</script>");
	}else{
		if(!$id){
			exit("<script language='javascript'>alert('id不能为空！');window.location.href='/Mz';</script>");
		}
		if($db->query("delete from `{$prefix}chat` where id=$id")){
		}else{
			exit("<script language='javascript'>alert('删除失败！');window.location.href='/Mz';</script>");
		}
	}
}
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">用户中心</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
 <div class="col-lg-4">
    <div class="panel panel-default">
       <div class="panel-heading">
          <div class="panel-title">CQY聊天室</div>
       </div>
	   <?php
$rowss = $db->query("select * from {$prefix}chat where 1=1 order by uid desc limit 20");
?>
<?php while ($info = $rowss->fetch(PDO::FETCH_ASSOC)) { ?>
       <div data-height="265" data-scrollable="" class="list-group">
          <div id="liao">
		  
		  <div class="list-group-item bb">
                        <div class="media-box">
                            <div class="pull-left">
                                <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $info['qid'];?>&amp;spec=100" alt="Image" class="media-box-object img-circle thumb35">
                            </div>
		  <div class="media-box-body clearfix">
		  <a href="?do=info&id=<?php echo $info['id']; ?>" class="label label-info pull-right" style="margin-top:8px;">删除</a>
		  <strong class="media-box-heading text-primary">
          <span class="circle circle-success circle-lg text-left"></span><?php echo $info['user'];?> 说：<?php echo $info['info'] ?> </strong>
          <p class="mb-sm">
          <small><i class="fa fa-clock-o"></i><?php echo $info['time'] ?></small>
          </p>
		  </div>
		  </div>
		  
          </div>
		  
       </div>
	    </div>
		<?php
           } 
		  ?>
	    <div class="panel-footer clearfix">
		<form action="?" method="post"> 
	   <input type="hidden" name="infos" value="ye">
                  <div class="input-group">
                     <input type="text" placeholder="广告\刷屏\封号处理" name="info" maxlength="24" class="form-control input-sm" required="">
                     <span class="input-group-btn">
                        <input type="submit" name="submit" value="发送" onClick="this.value='请稍后......'"  class="btn btn-default btn-sm">
                     </span>
                  </div>
               </div>
       
    </div>
</div>
</div>
<?php
include_once 'core.foot.php';
?>