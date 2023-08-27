<?php
require_once('common.php');
$qid = is_numeric($_GET['qid'])?$_GET['qid']:'0';
$now = date('Y-m-d-H:i:s');
if(!$qid){
    $rowss = $db -> query("select * from {$prefix}qqs where 1=1 order by qid desc limit 1");
    while($row = $rowss -> fetch(PDO :: FETCH_ASSOC)){
        $qid = $row['qid'];
    }
}
if(!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $userrow['uid']))){
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}
if($_GET['do'] == 'change'){
    if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend'])){
        echo "<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');</script>";
    }else{
        $the = $_GET['the'];
        $is = is_numeric($_GET['is'])?$_GET['is']:'0';
        $db -> query("update {$prefix}qqs set is{$the}='$is' where qid='$qid'");
        $db -> query("update {$prefix}qqs set next{$the}='$now' where qid='$qid'");
    }
}elseif($_GET['do'] == 'del'){
    $db -> query("delete from {$prefix}qqs where qid='$qid'");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='/Function/Index/';</script>");
}
if ($_GET['do'] == 'qqgame') {
    $uin = $_GET['uin'];
    $skey = $_GET['skey'];
    if ($uin && $skey) {
        $data = get_curl("http://qqfunc.api.odoto.cc/api/qqgame.php?uin={$uin}&skey={$skey}");
        $arr = json_decode($data, true);
        if ($arr['code'] == '0') {
            exit("<script language='javascript'>alert('{$arr['msg']}');window.location.href='/Function/Index/qqlist.php?qid={$_GET['qid']}';</script>");
        } else {
            exit("<script language='javascript'>alert('加速失败，请稍后再试！');window.location.href='/Function/Index/qqlist.php?qid={$_GET['qid']}';</script>");
        }
    }
}
if (!getzts($qqrow['iszan'])) {
}else{
$msg= 'swal({title:"温馨提示",text:"当前QQ的秒赞功能尚未开启，导致无法自动更新QQ状态码，是否开启？",type:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",confirmButtonText:"开启",cancelButtonText:"暂不",closeOnConfirm:false,closeOnCancel:true},function(isConfirm){if(isConfirm){window.location.href="/Function/Index/qqset.php?qid='.$qqrow['qid'].'&xz=zan"}else{return false;}});';
}

if ($qqrow['skeyzt']) $msg = 'swal({title:"温馨提示",text:"当前QQ的状态已经过期，导致无法继续使用功能，立即更新？",type:"warning",showCancelButton:true,confirmButtonColor:"#DD6B55",confirmButtonText:"更新",cancelButtonText:"暂不",closeOnConfirm:false,closeOnCancel:true},function(isConfirm){if(isConfirm){window.location.href="add.php?uin=' . $qqrow['qq'] . '&auto=1&type=add"}else{return false;}});';
C('webtitle', 'QQ' . $qqrow['qq']);
C('pageid', 'qid' . $qqrow['qid']);
C('pageids', 'qid');
include_once 'core.head.php';
?>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
    var xiha = {
        postData: function (url, parameter, callback, dataType, ajaxType) {
            if (!dataType) dataType = 'json';
            $.ajax({
                type: "POST",
                url: url,
                async: true,
                dataType: dataType,
                json: "callback",
                data: parameter,
                success: function (data) {
                    if (callback == null) {
                        return;
                    }
                    callback(data);
                },
                error: function (error) {
                    setTimeout(function () {
                    }, 1);
                    alert('获取失败！');
                }
            });
        }
    }
    $(document).ready(function () {
        $('#startcheck').click(function () {
            var getvcurl = "http://<?=$domain?>/QQTask/pclike.php?qid=<?=$qqrow['qid']?>&func=zan";
            $('#load').html("正在加载中....");
            xiha.postData(getvcurl, '', function (d) {
                setTimeout(function () {
                }, 1);
                $('#load').html(d.ret);
            });
            self.attr("data-lock", "false");
        });
        $('#startcheck1').click(function () {
            var getvcurl = "http://<?=$domain?>/QQTask/getnew.php?qid=<?=$qqrow['qid']?>";
            $('#loads').html("正在加载中....");
            xiha.postData(getvcurl, '', function (d) {
                setTimeout(function () {
                }, 1);
                $('#loads').html(d.ret);
            });
            self.attr("data-lock", "false");
        });
    });
</script>

	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
      <div class="app-content-body fade-in-up">
        <!-- COPY the content from "tpl/" -->
          <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
              <div style="background:url(http://h2302701417.kuaiyunds.com/h2302701417/c0.jpg) center center; background-size:cover">
      <div class="wrapper-lg bg-white-opacity">
        <div class="row m-t">
          <div class="col-sm-7">
            <a href="" class="thumb-lg pull-left m-r">
              <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $qqrow['qq']?>&spec=100" class="img-circle">
            </a>
            <div class="clear m-b">
              <div class="m-b m-t-sm">
                <span class="h3 text-black"><?=get_qqnick($qqrow[qq])?></span>
              </div>
              <p class="m-b">
                <a href="" class="btn btn-sm btn-bg btn-rounded btn-default btn-icon"><i class="fa fa-twitter"></i></a>
                <a href="" class="btn btn-sm btn-bg btn-rounded btn-default btn-icon"><i class="fa fa-facebook"></i></a>
                <a href="" class="btn btn-sm btn-bg btn-rounded btn-default btn-icon"><i class="fa fa-google-plus"></i></a>
              </p>
              <a href="add.php?uin=<?php echo $qqrow['qq']?>&auto=1&type=add" class="btn btn-sm btn-success btn-rounded">更新</a>
			  <a href="/Function/Index/mzrz.php?uin=<?php echo $qqrow['qq']?>" target="_blank" class="btn btn-sm btn-info btn-rounded">秒赞认证</a>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="pull-right pull-none-xs text-center">
              <a href="" class="m-b-md inline m">			  
                   <div class="media-box-heading text- m0"><small>       
                            <p>SK码：<?php if($qqrow[skeyzt]){echo'<span class="red" aria-hidden="true">&nbsp;[过期请<a href="add.php?uin='.$qqorw[qq].'">更新</a>]</span>';}else{echo'<span class="green" aria-hidden="true">&nbsp;[正常]</span>';}?>
                             —— SD码：<?php if($qqrow[sidzt]){echo'<span class="red" aria-hidden="true">&nbsp;[过期请<a href="add.php?uin='.$qqorw[qq].'">更新</a>]</span>';}else{echo'<span class="green" aria-hidden="true">&nbsp;[正常]</span>';}?>                            </p>
							<p>以上状态码若有非正常的请及时更新防止功能失效！</p></small>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="panel panel-default">
        <div class="panel-body">
		<a target="_blank" href="http://kf.qq.com/touch/qzone/qzone_status.html" class="btn m-b-xs btn-sm btn-success btn-addon"><i class="fa fa-circle"></i>空间状态检测</a>
		<a target="_blank" href="?do=qqgame&uin=<?= $qqrow['qq'] ?>&amp;skey=<?= $qqrow['skey'] ?>&qid=<?= $qqrow['qid'] ?>" class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-circle"></i>一键加速手Q</a>
		<a href="dxjc.php?qid=<?php echo $qqrow['qid']?>" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-circle"></i>单项好友检测</a>
		<a href="mzjc.php?qid=<?php echo $qqrow['qid']?>" class="btn m-b-xs btn-sm btn-default btn-addon"><i class="fa fa-circle"></i>秒赞好友检测</a>
		<a a class="btn m-b-xs btn-sm btn-danger btn-addon"data-toggle="modal" id="startcheck" data-target="#myModa3"><i class="fa fa-circle"></i>秒赞手动执行</a>
		</div>
      </div>
<div class="col-lg-6">
<div class="panel panel-default">
    <div class="panel-heading">
      已开启
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>项目</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>自动更新状态</td>
            <td><span class="label bg-primary"><?php echo '[正在运行'.$qqrow['nextauto']."] ".get_gxzt($qqrow['gxmsg'])?></span> </td>
            <td>
              <i class="icon-lock"></i> 已锁定
            </td>
          </tr>
		  <?php if(getzts($qqrow['iszan'])){
			}else{
			?>
		 <tr>
            <td>说说自动点赞</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastzan'])?></span>
			</td>
            <td>
              <a href="qqset.php?qid=<?php echo $qid?>&xz=zan#zan" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>			  
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqipao'])){
			}else{
			?>
		 <tr>
            <td>百变七彩气泡</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqipao'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=qipao&is=<?php if($qqrow['isqipao']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
		<?php if(getzts($qqrow['ispf'])){
			}else{
			?>
		 <tr>
            <td>百变随机皮肤</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastpf'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=pf&is=<?php if($qqrow['ispf']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
		  
		
		<?php if(getzts($qqrow['istx'])){
			}else{
			?>
		 <tr>
            <td>百变随机头像</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lasttx'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=tx&is=<?php if($qqrow['istx']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>	
			<?php if(getzts($qqrow['is3gqq'])){
			}else{
			?>
		 <tr>
            <td>3GQQ在线挂机</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['last3gqq'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=3gqq&is=<?php if($qqrow['is3gqq']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isreply'])){
			}else{
			?>
		 <tr>
            <td>说说自动评论</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastreply'])?></span> </td>
            <td>
              <a href="qqset.php?qid=<?php echo $qid?>&xz=reply#reply" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['iszf'])){
			}else{
			?>
		 <tr>
            <td>说说自动转发</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastzf'])?></span> </td>
            <td>
              <a href="qqset.php?qid=<?php echo $qid?>&xz=zf#zf" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqt'])){
			}else{
			?>
		 <tr>
            <td>说说在线圈图</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqt'])?></span> </td>
            <td>
              <a href="qqset.php?qid=<?php echo $qid?>&xz=qt#qt" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isshuo'])){
			}else{
			?>
		 <tr>
            <td>说说发表说说</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastshuo'])?></span> </td>
            <td>
              <a href="qqset.php?qid=<?php echo $qid?>&xz=shuo#shuo" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isdel'])){
			}else{
			?>
		 <tr>
            <td>自动删除说说</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastdel'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=del&is=<?php if($qqrow['isdel']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isdell'])){
			}else{
			?>
		 <tr>
            <td>自动删除留言</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastdell'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=dell&is=<?php if($qqrow['isdell']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isht'])){
			}else{
			?>
		 <tr>
            <td>花藤每日浇花</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastht'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=ht&is=<?php if($qqrow['isht']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isvipqd'])){
			}else{
			?>
		 <tr>
            <td>QQ会员自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastvipqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=vipqd&is=<?php if($qqrow['isvipqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqb'])){
			}else{
			?>
		 <tr>
            <td>QQ钱包自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqb'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=isqb&is=<?php if($qqrow['isqb']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqd'])){
			}else{
			?>
		 <tr>
            <td>QQ空间每日签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=isqd&is=<?php if($qqrow['isqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isdldqd'])){
			}else{
			?>
		 <tr>
            <td>QQ大乐斗签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastdldqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=dldqd&is=<?php if($qqrow['isdldqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['iswyqd'])){
			}else{
			?>
		 <tr>
            <td>微云自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastwyqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=wyqd&is=<?php if($qqrow['iswyqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isblqd'])){
			}else{
			?>
		 <tr>
            <td>QQ部落自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastblqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=blqd&is=<?php if($qqrow['isblqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqqd'])){
			}else{
			?>
		 <tr>
            <td>QQ群每日自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=qqd&is=<?php if($qqrow['isqqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
		  <?php }?>
			<?php if(getzts($qqrow['isqzoneqd'])){
			}else{
			?>
		 <tr>
            <td>QQ黄钻每日自动签到</td>
            <td><span class="label bg-primary"><?=zhtime($qqrow['lastqzoneqd'])?></span> </td>
            <td>
              <a href="?qid=<?php echo $qid?>&do=change&the=qzoneqd&is=<?php if($qqrow['isqzoneqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-close"></i>关闭</a>
            </td>
          </tr>
			<?php }?>
		</tbody>
      </table>
    </div>
  </div>
  </div>
      <div class="col-md-6">
        <div id="panelDemo14" class="panel panel-default">
            <div role="tabpanel">
                <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="active"><a href=".kj" aria-controls="home" role="tab" data-toggle="tab">常规功能</a></li>
					<li role="presentation"><a href=".gn" aria-controls="profile" role="tab" data-toggle="tab">签到功能</a>
                    <li role="presentation"><a href=".jl" aria-controls="profile" role="tab" data-toggle="tab">点赞记录</a>
                    </li>
                </ul>
                <div class="tab-content">
				 <div role="tabpanel" class="tab-pane kj active">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>项目</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
		<?php if(getzts($qqrow['iszan'])){
    ?>
				  <tr>
            <td>说说自动点赞</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="qqset.php?qid=<?php echo $qid?>&xz=zan#zan" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="icon-compass"></i>设置</a>
            </td>
          </tr>
		<?php }?>
		  <?php if(getzts($qqrow['istx'])){
    ?>
						<tr>
            <td>百变随机头像</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=tx&is=<?php if($qqrow['istx']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
		  <?php }?>
		  <?php if(getzts($qqrow['isqipao'])){
    ?>
						<tr>
            <td>百变七彩气泡</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=qipao&is=<?php if($qqrow['isqipao']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
        </tr>
		  <?php }?>
		<?php if(getzts($qqrow['ispf'])){
    ?>
		<tr>
            <td>百变随机皮肤</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=pf&is=<?php if($qqrow['ispf']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
        </tr>
		<?php }?>
		<?php if(getzts($qqrow['is3gqq'])){
    ?>
		<tr>
            <td>3GQQ在线挂机</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=3gqq&is=<?php if($qqrow['is3gqq']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
        </tr>		
		<?php }?>
		<?php if(getzts($qqrow['isreply'])){
    ?>
		<tr>
            <td>说说自动评论</td>

            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="qqset.php?qid=<?php echo $qid?>&xz=reply#reply" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="icon-compass"></i>设置</a>
            </td>
        </tr>
		<?php }?>
				<?php if(getzts($qqrow['iszf'])){
    ?>																	<tr>
            <td>说说自动转发</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="qqset.php?qid=<?php echo $qid?>&xz=zf#zf" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="icon-compass"></i>设置</a>
            </td>
          </tr>
				<?php }?>
				<?php if(getzts($qqrow['isqt'])){
    ?>
				<tr>
            <td>说说在线圈图</td>

            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="qqset.php?qid=<?php echo $qid?>&xz=qt#qt" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="icon-compass"></i>设置</a>
            </td>
          </tr>
				<?php }?>	
			<?php if(getzts($qqrow['isshuo'])){
    ?>
				<tr>
            <td>说说发表说说</td>

            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="qqset.php?qid=<?php echo $qid?>&xz=shuo#shuo" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="icon-compass"></i>设置</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isdell'])){
    ?>																		<tr>
            <td>自动删除留言</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=dell&is=<?php if($qqrow['isdell']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isdel'])){
    ?>
			<tr>
            <td>自动删除说说</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=del&is=<?php if($qqrow['isdel']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isht'])){
    ?>
			<tr>
            <td>花藤每日浇花</td>
  
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=ht&is=<?php if($qqrow['isht']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>			       
		</tbody>
      </table>
    </div>
	<div role="tabpanel" class="tab-pane gn">
	  <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>项目</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
			<?php if(getzts($qqrow['isvipqd'])){
    ?>											
														<tr>
            <td>QQ会员签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=vipqd&is=<?php if($qqrow['isvipqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>
			<?php if(getzts($qqrow['isqb'])){
    ?>
																					<tr>
            <td>QQ钱包签到</td>

            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=qb&is=<?php if($qqrow['isqb']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>
				<?php if(getzts($qqrow['isqd'])){
    ?>																	<tr>
            <td>QQ空间签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=qd&is=<?php if($qqrow['isqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
				<?php }?>
			<?php if(getzts($qqrow['isdldqd'])){
    ?>																		<tr>
            <td>QQ大乐斗签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=dldqd&is=<?php if($qqrow['isdldqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>	
			<?php if(getzts($qqrow['iswyqd'])){
    ?>
			<tr>
            <td>QQ微云签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=wyqd&is=<?php if($qqrow['iswyqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
			<?php }?>																	<tr>

									<?php if(getzts($qqrow['isblqd'])){
    ?>																<tr>
            <td>QQ部落签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=blqd&is=<?php if($qqrow['blqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
									<?php }?>
					<?php if(getzts($qqrow['isqqd'])){
    ?>				
																					<tr>
            <td>QQ群签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=qqd&is=<?php if($qqrow['isqqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>
		  	<?php }?>
					<?php if(getzts($qqrow['isqzoneqd'])){
    ?>				
																					<tr>
            <td>QQ黄钻签到</td>
            <td><span class="label bg-info">未运行</span></td>
            <td>
			  <a href="?qid=<?php echo $qid?>&do=change&the=qzoneqd&is=<?php if($qqrow['isqzoneqd']){
        echo 0;
    }else{
        echo 0x0002;
    }
    ?>" class="btn m-b-xs btn-sm btn-danger btn-addon"><i class="fa fa-circle"></i>开启</a>
            </td>
          </tr>

			<?php }?>			       
		</tbody>
      </table>
    </div>
<div role="tabpanel" class="tab-pane jl">
 <table class="table table-striped b-t b-light">
                        <a id="startcheck1" class="zan btn btn-square btn-primary btn-block">查看谁赞了我</a>
                        <div id="loads"></table>
    
  </div>
  </div>
   </div>
    </div>
	 </div>
	  
<?php
include_once 'core.foot.php';
?>
        <div class="modal inmodal fade" id="myModa3" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated flipInY">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                        <h4 class="modal-title">
                            手动执行
                        </h4>
                    </div>
                    <div class="modal-body" id="load"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>