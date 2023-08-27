<?php
session_start();
require_once('common.php');
if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend']))exit("<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
$qid = is_numeric($_GET['qid'])?$_GET['qid']:'0';
if(!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $userrow['uid']))){
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}
$qq = $qqrow['qq'];
$skey = $qqrow['skey'];
$p_skey = $qqrow['p_skey'];
$gtk = getGTK($qqrow['skey']);
$cookie = 'uin=o0' . $qq . '; skey=' . $skey . ';';
$url = 'http://m.qzone.com/friend/mfriend_list?g_tk=' . $gtk . '&res_uin=' . $qq . '&res_type=normal&format=json&count_per_page=10&page_index=0&page_type=0&mayknowuin=&qqmailstat=';
$json = get_curl($url, 0, 1, $cookie);
$json = mb_convert_encoding($json, 'UTF-8', 'UTF-8');
$arr = json_decode($json, true);
$friend = $arr['data']['list'];
$gpnames = $arr['data']['gpnames'];
foreach($gpnames as $gprow){
    $gpid = $gprow['gpid'];
    $gpname[$gpid] = $gprow['gpname'];
}
$json = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . "/Status/api/qqjc.php?qq={$qqrow[qq]}&p_skey={$qqrow['p_skey']}&skey={$qqrow[skey]}");
$arr = json_decode($json, true);
if($arr['code'] != 0){
    exit("<script language='javascript'>alert('" . $arr['msg'] . "');history.go(-1);</script>");
}
if(!@array_key_exists('code', $arr)){
    exit("<script language='javascript'>alert('获取秒赞好友失败，请稍候重试！');history.go(-1);</script>");
}elseif($arr['code'] != 0){
    exit("<script language='javascript'>alert('" . $arr['msg'] . "');history.go(-1);</script>");
}elseif($arr['code'] == -0x0bb8){
    $db -> query("update {$prefix}qqs set skeyzt='1',sidzt='1' WHERE qid='{$qid}'");
    exit("<script language='javascript'>alert('SID已过期');history.go(-1);</script>");
}elseif($arr['code'] == -6250){
    exit("<script language='javascript'>alert('腾讯服务器繁忙，请稍后再来尝试！');history.go(-1);</script>");
}
C('webtitle', 'QQ' . $qqrow['qq'] . '秒赞好友检测');
C('pageid', 'mzjc');
include_once 'core.head.php';
?>
<script src="http://libs.baidu.com/jquery/2.0.3/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$('#startcheck').click(function(){
		var self=$(this);
		if (self.attr("data-lock") === "true") return;
			else self.attr("data-lock", "true");
		self.html('移动中<img src="../../Template/user/images/load.gif" height=25>');
		var fenzu=$("#gpname").val();
		var num=0;
		$(".ismove").each(function(){
			var checkself=$(this),
				touin=checkself.attr('uin');
			var url="../../Status/api/fenzu.php";
			checkself.html("<img src='../../Template/user/images/load.gif' height=25>");
			xiha.postData(url,'uin=
<?php echo $qq?>&skey=<?php echo $skey?>&p_skey=<?php echo $p_skey?>&touin='+touin+'&gpid='+fenzu, function(d) {
				if(d.code==0){
					num++;
					checkself.html('<font color="green">成功</font>');
					checkself.removeClass('ismove');
					self.html('QQ：'+touin+'移动完成');
				}else if(d.code==-1){
					checkself.html('<font color="red">失败</font>');
					alert('SKEY已过期，请更新SKEY！');
					return false;
				}else{
					checkself.html('<font color="red">失败</font>');
				}
			});
		});
		if(num<1) self.html('没有待移动的QQ！');
		else self.html('移动成功！');
		self.attr("data-lock", "false");
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
			error: function(error) {
				alert('创建连接失败');
			}
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
<h1 class="m-n font-thin h3"><?=$qqrow['qq']?>秒赞检测</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
<div class="wrapper-md control">
<div class="row row-sm">
      <div class="col-md-8">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title" align="center">提示</h3>
          </div>
          <div class="panel-body" align="left">
            <p>1、本功能数据仅作参考，不代表和实际数据完全一致</p>
            <p>2、建议使用本功能前先发布几条说说，等待一段时间后再来检测可增加准确率</p>
            <p>3、该功能需要大量运算,手机使用会卡顿,可使用电脑进行检测</p>
          </div>
        </div>
      </div>

    <div class="col-md-8">
      <div class="panel panel-primary checkbtn">
	<div class="panel-heading w h">
		<h3 class="panel-title" align="center">秒赞好友列表</h3>
	</div>
</div>
<div class="panel panel-primary">
	<table class="table table-bordered box">
						 <thead>
				<tr>
					<tr>
					<th align="center">QQ</th>
					<th align="center">昵称</th>
					<th align="center">几率</th>
				</tr>
				</thead>
				<tbody id="content">
                <tr><td colspan="2" align="center"><button class="btn btn-success btn-block" id="startcheck">所有好友[<?php echo count($friend)?>] 秒赞[<?php echo $arr['mzcount']?>] 不秒赞
			  <?php
 echo count($arr['friend']) - $arr['mzcount'];
?> 移动所有秒赞好友到</button></td><td align="center"><select id="gpname">

<?php
 foreach($gpnames as $row){
    echo '<option value="' . $row['gpid'] . '">' . $row['gpname'] . '</option>';
}
?>
			</select></td></tr>
				<?php
 foreach($arr['friend'] as $row){
    echo '<tr><td>' . $row['uin'] . '</td><td>' . $row['remark'] . '</td><td ' . (($row['mz'] != 0)?'class="ismove" ':null) . 'uin="' . $row['uin'] . '" align="center" style="background: rgba(205, 133, 0, ' . ($row['mz'] / 0x05) . ');">' . round(($row['mz'] / 0x000004) * 0x064) . '%</td></tr>';
}
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