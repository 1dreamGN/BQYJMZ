<?php
session_start();
require_once('common.php');
if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend']))exit("<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
$qid = is_numeric($_GET['qid'])?$_GET['qid']:'0';
if(!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $userrow['uid']))){
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}
$GTK = getGTK($qqrow['skey']);
$url = 'http://mobile.qzone.qq.com/friend/mfriend_list?g_tk=' . $GTK . '&res_uin=' . $qqrow['qq'] . '&res_type=normal&format=json&count_per_page=10&page_index=0&page_type=0&mayknowuin=&qqmailstat=';
$json = get_curl($url, 0, 1, 'pt2gguin=o0' . $qqrow['qq'] . '; uin=o0' . $qqrow['qq'] . '; skey=' . $qqrow['skey'] . ';');
$arr = json_decode($json, true);
if($arr['code'] == -0x0bb8){
    $db -> query("update {$prefix}qqs set skeyzt='1',sidzt='1' WHERE qid='{$qid}'");
    exit("<script language='javascript'>alert('SID已过期');history.go(-1);</script>");
}
$dxrow = $_SESSION['bqyj_dxrow']["$qqrow[qq]"];
$arr = $arr['data']['list'];
if($_GET['do'] == 'clear'){
    session_unset();
    exit("<script language='javascript'>alert('数据已清除');history.go(-1);</script>");
}
C('webtitle', 'QQ' . $qqrow['qq'] . '单项好友检测');
C('pageid', 'dxjc');
include_once 'core.head.php';
?>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
function SelectAll(chkAll) {
	var items = $('.uins');
	for (i = 0; i < items.length; i++) {
		if (items[i].id.indexOf("uins") != -1) {
			if (items[i].type == "checkbox") {
				items[i].checked = chkAll.checked;
			}
		}
	}
}
$(document).ready(function() {
	$('#startcheck').click(function(){
		self=$(this);
		if (self.attr("data-lock") === "true") return;
			else self.attr("data-lock", "true");
		$('#load').html('检测中<img src="../../Template/user/images/load.gif" height=25>');
		var url="../../Status/api/dx.php";
		xiha.postData(url,'uin=<?php echo $qqrow['qq']?>&skey=<?php echo $qqrow['skey']?>&p_skey=<?php echo $qqrow['p_skey']?>', function(d) {
			if(d.code ==0){
				$('#load').html('这一组检测完成，3秒后进行下一组，请稍等！');
				$('#hydx').html(d.dxcount);
				$('#hydel').html(d.count);
				if(d.dxrow){
					$var1each(d.dxrow, function(i, item){
						$("#content").append('<tr><td><input name="uins" type="checkbox" class="uins" id="uins" value="'+item.uin+'">'+item.uin+'</td><td>'+item.nick+'</td><td>'+item.remark+'</td><td align="center"><button class="btn btn-large btn-block qqdel del'+item.uin+'" uin="'+item.uin+'">删除</button></td></tr>');
					});
				}
				if(d.finish==1){
					$('#load').html('好友全部检测完毕！');
				}else{
					 setTimeout(function () {
						$('#startcheck').click()
					 }, 3000);
					//$('#startcheck').click();
				}
			}else{
				alert(d.msg);
			}
				});
		self.attr("data-lock", "false");
	});
	$(document).on("click",".qqdel",function(){
		var checkself=$(this),
			touin=checkself.attr('uin');
		checkself.html('<Iframe src="../../Status/api/qqdel.php?uin=<?php echo $qqrow['qq']?>&skey=<?php echo $qqrow['skey']?>&p_skey=<?php echo $qqrow['p_skey']?>&touin='+touin+'" width="50px" height="30px" scrolling="no" frameborder="0"></iframe>');
	});
	$('.alldel').click(function(){
		var uin;
		$("input[name=uins]").each(function(){
			if($(this)[0].checked){
				uin=$(this).val();
				$('.del'+uin).html('<Iframe src="../../Status/api/qqdel.php?uin=<?php echo $qqrow['qq']?>&skey=<?php echo $qqrow['skey']?>&p_skey=<?php echo $qqrow['p_skey']?>&touin='+uin+'" width="50px" height="30px" scrolling="no" frameborder="0"></iframe>');
			}
		});
	});
});
var xiha={
	postData: function(url, parameter, callback, dataType, ajaxType) {
		if(!dataType) dataType='json';
		$var1ajax({
			type: "POST",
			url: url,
			async: true,
			dataType: dataType,
			json: "callback",
			data: parameter,
			success: function(data) {
				if (callback == null) {
					return;
				}
				callback(data);
			},
		});
	}
}
</script>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3"><?=$qqrow['qq']?>单项检测</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="wrapper-md control">
<div class="row row-sm">
<div class="col-sm-8">
        <div class="row">
<li class="list-group-item bg-primary" draggable="true" style="display: block;">
      <span class="pull-right">
        <a href=""><i class="fa fa-pencil fa-fw m-r-xs"></i></a>
        <a href=""><i class="fa fa-plus fa-fw m-r-xs"></i></a>
        <a href=""><i class="fa fa-times fa-fw"></i></a>                  
      </span>
      <span class="pull-left"><i class="fa fa-sort text-muted fa m-r-sm"></i> </span>
      <div class="clear">
1、本功能展示的结果仅作参考，具体以实际数据为准<br><br>
2、新添加的QQ好友可能会被误判为单向好友<br><br>
3、该功能需要大量运算,手机使用会卡顿,可使用电脑进行检测<br>
      </div>
    </li>
	<li class="list-group-item bg-success" draggable="true" style="display: block;">
     <span class="pull-right">
        <a href=""><i class="fa fa-pencil fa-fw m-r-xs"></i></a>
        <a href=""><i class="fa fa-plus fa-fw m-r-xs"></i></a>
        <a href=""><i class="fa fa-times fa-fw"></i></a>                  
      </span>
      <span class="pull-left"><i class="fa fa-sort text-muted fa m-r-sm"></i> </span>
      <div class="clear">
        <span id="load" class="biank tanchu">待检测...</span><span class="ng-binding ng-scope">总共<span id="hyall"><?php echo count($arr)?></span>个好友，已检测<span id="hydel"><?php echo count($_SESSION['o' . $qqrow[qq]])?>个.</span></span>
      </div>
    </li>
<div class="panel panel-default">
        <div class="panel-heading">
          <span class="label bg-danger pull-right m-t-xs">单项<span id="hydx"><?php echo count($dxrow)?></span>个</span>
          QQ单项好友检测
        </div>
        <table class="table table-striped m-b-none">
          <thead>
            <tr><td align="center"><label><input type="checkbox" onclick="SelectAll(this)" />全选</label> 账号</td>  </td><td class="mzwidthtd" align="center">昵称</td><td class="mzwidthtd" align="center">备注</td><td align="center">删除</td></tr>
          </thead>
          <tbody id="contents">
		  <?php
 if($dxrow){
    foreach($dxrow as $k => $row){
        if(stripos($json, 'uin":' . $row['uin'])){
            echo"<tr><td><label><input name='uins' type='checkbox' class='uins' id='uins' value='{$row[uin]}'> {$row[uin]}</label></td><td class='mztd'>{$row[nick]}</td><td class='mztd'>{$row[remark]}</td><td align='center'><button class='btn btn-large btn-block qqdel del{$row[uin]}' uin='{$row[uin]}'>删除</button></td></tr>";
        }else{
            unset($_SESSION['bqyj_dxrow']["$qqrow[qq]"][$k]);
        }
    }
}
?>
	
							</tbody>
        </table>
      </div>
		<div class="panel panel-info">
			<div class="panel-title">
				<div class="panel-title">
					<div class="input-group">
					<div class="input-group-addon" id="startcheck">开始检测</div>
					<div class="input-group-addon"><a href="?do=clear&qid=<?php echo $qqrow['qid']?>">清除数据</a></div>
						<div class="input-group-addon btn alldel">删除选中的好友</div>

					</div>
				</div>
			</div>
		</div>
</div></div>
</div></div>











<?php
include_once 'core.foot.php';
?>