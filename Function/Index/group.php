<?php
require_once('common.php');
$qid = is_numeric($_GET['qid'])?$_GET['qid']:'0';
$now = date('Y-m-d-H:i:s');
if(!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $userrow['uid']))){
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}
C('webtitle', '群成员提取');
include_once 'core.head.php';
$qq = $qqrow['qq'];
$skey = $qqrow['skey'];
$gtk = getGTK($skey);
$cookie = 'uin=o0' . $qq . '; skey=' . $skey . ';';
$ua = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
$url = 'http://qun.qzone.qq.com/cgi-bin/get_group_list?callbackFun=_GetGroupPortal&uin=' . $qq . '&ua=Mozilla%2F5.0%20(Windows%20NT%206.3%3B%20WOW64%3B%20rv%3A25.0)%20Gecko%2F20100101%20Firefox%2F25.0&random=0.946546206453239&g_tk=' . $gtk;
$data = get_curl($url, 0, 'http://qun.qzone.qq.com/group', $cookie, 0, $ua);
preg_match('/_GetGroupPortal_Callback\((.*?)\)\;/is', $data, $json);
$arr = json_decode($json[1], true);
if(!$arr){
    exit("<script language='javascript'>alert('QQ群列表获取失败！');history.go(-1);</script>");
    exit();
}elseif($arr['code'] == -0x0bb8){
    $db -> query("update {$prefix}qqs set skeyzt='1',sidzt='1' WHERE qid='{$qid}'");
    exit("<script language='javascript'>alert('SID已过期');history.go(-1);</script>");
    exit();
}
if(isset($_POST['groupid'])){
    $groupid = $_POST['groupid'];
    $gtk = getGTK($skey);
    $cookie = 'uin=o0' . $qq . '; skey=' . $skey . ';';
    $ua = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
    $url = 'http://qun.qzone.qq.com/cgi-bin/get_group_member?callbackFun=_GroupMember&uin=' . $qq . '&groupid=' . $groupid . '&neednum=1&r=0.973228807809788&g_tk=' . $gtk . '&ua=Mozilla%2F5.0%20(Windows%20NT%206.3%3B%20WOW64%3B%20rv%3A25.0)%20Gecko%2F20100101%20Firefox%2F25.0&ptlang=2052';
    $data = get_curl($url, 0, 'http://qun.qzone.qq.com/group', $cookie, 0, $ua);
    preg_match('/_GroupMember_Callback\((.*?)\)\;/is', $data, $json);
    $arrs = json_decode($json[1], true);
    if(!$arrs){
        exit("<script language='javascript'>alert('QQ群成员获取失败！');history.go(-1);</script>");
        exit();
    }elseif($arrs['code'] == -0x0bb8){
        exit("<script language='javascript'>alert('SKEY已过期！');history.go(-1);</script>");
        exit();
    }
}
?>
    <div class="col-md-12">

							<div class="panel panel-primary">
	<div class="panel-heading w h">
		<h3 class="panel-title" align="center">提取群成员</h3>
	</div>
	<div class="panel-body box" align="left">
		<form action="?qid=<?php echo $qqrow['qid']?>" method="POST">
		<div class="form-group">
		<div class="input-group"><div class="input-group-addon">QQ群列表</div>
		<input type="hidden" name="do" value="group">
		<input type="hidden" name="qq" value="
<?php echo $qq?>">
		<select name="groupid" class="form-control">

<?php
 foreach($arr['data']['group'] as $row){
    echo '<option value="' . $row['groupid'] . '" ' . ($groupid == $row['groupid']?'selected="selected"':NULL) . '>' . $row['groupid'] . '_' . $row['groupname'] . '</option>';
}
?>
			</select>
		</div></div>
		<div class="form-group">
		<input type="submit" class="btn btn-primary btn-block" value="提取群成员">
		</div>
		</form>
	</div>
</div>

<?php if($arrs){
    if($_POST['do'] == 'group'){
        $datas = '';
        ?>
<div class="panel panel-success">
	<div class="panel-heading w h">
		<h3 class="panel-title" align="center">群成员列表</h3>
	</div>
	<table class="table table-bordered box">
		<tbody>
			<tr>
			<td><span style="color:silver;"><b>ＱＱ</b></span></td>
			<td><span style="color:silver;"><b>昵称</b></span></td>
			</tr>

<?php
         foreach($arrs['data']['item'] as $row){
            $datas .= $row['nick'] . '----' . $row['uin'] . '
';
            echo '<tr><td uin="' . $row['uin'] . '"><a href="tencent://message/?uin=' . $row['uin'] . '&amp;Site=&amp;Menu=yes" target="_blank">' . $row['uin'] . '</a></td><td>' . $row['nick'] . '</td></tr>';
        }
    }
}
?>
		</tbody>
	</table>
	<form action="../../Status/api/download.php?download&group=<?php echo $groupid?>" method="POST">
		<div class="panel-heading w h">
		<input type="hidden" name="data" value="<?php echo $datas?>">
		<input type="submit" class="btn btn-primary btn-block" value="导出群成员">
		</div>
		</form>
</div>
</div>

<?php
include_once 'core.foot.php';
?>