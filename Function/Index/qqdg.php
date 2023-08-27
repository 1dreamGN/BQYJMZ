<?php
require_once 'common.php';
if (C("dgapi") == "1") exit("<script language='javascript'>alert('请从菜单找到QQ等级加速中打开');history.go(-1);</script>");
if (C("dgapi") == "2") {
	$dgapi = "http://api.qzu123.cn/";
} elseif (C("dgapi") == "3") {
	$dgapi = "http://www.aff58.com/";
} elseif (!C("dgzdy") && C("dgapi") == "0") {
	exit("<script language='javascript'>alert('站长没有填写代挂接口');history.go(-1);</script>");
} else {
	$dgapi = C("dgzdy");
}
C('pageid', 'daigua');
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : '0';
if (!$qid) {
	$rowss = $db->query("select * from {$prefix}qqs where 1=1 order by qid desc limit 1");
	while($row = $rowss->fetch(PDO::FETCH_ASSOC)){
	$qid = $row['qid'];
	}
}
$blackarr = array('稳定代挂中', '<font color=red>密码错误</font>', '<font color=red>ＱＱ冻结</font>', '<font color=red>请关闭设备锁</font>');
if (!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1",array(":qid"=>$qid,":uid"=>$userrow['uid']))) {
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}
$qq = $qqrow['qq'];
C('webtitle', 'QQ代挂');
C('pageids', 'dgqid' . $qqrow['qid']);
$act = isset($_GET['act']) ? $_GET['act'] : null;
include_once 'core.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">QQ代挂</h1>
</div>
<div class="col-md-8">
<?php
if ($act == 'add') {
	$func = $_POST['func_0'] . ',' . $_POST['func_1'] . ',' . $_POST['func_2'] . ',' . $_POST['func_3'] . ',' . $_POST['func_4'] . ',' . $_POST['func_5'];
	$pwd = authcode($_POST['pwd'], 'ENCODE', 'CLOUDKEY');
	$data = get_curl($dgapi . 'Status/api/submit.php?act=add&uin=' . $qq . '&pwd=' . urlencode($pwd) . '&km=' . $_POST['km'] . '&id=' . $_GET['id'] . '&func=' . $func . '&url=' . $_SERVER['HTTP_HOST']);
	$arr = json_decode($data, true);
	if ($arr['code'] == 1) {
		$set = "qqlevel='" . $arr['id'] . "'";
		$db->query("update {$prefix}qqs set {$set} where qq='$qq'");
		echo '<div class="alert alert-success"><small>' . $arr['msg'] . '</small></div>';
	} elseif (array_key_exists('msg', $arr)) {
		echo '<div class="alert alert-info"><small>' . $arr['msg'] . '</small></div>';
	} else {
		echo '<div class="alert alert-info"><small>' . $data . '</small></div>';
	}
} elseif ($act == 'fill_do') {
	$func = implode(',', $_POST['bgid']);
	$data = get_curl($dgapi . 'Status/api/submit.php?act=fill&id=' . $_GET['id'] . '&uin=' . $qq . '&func=' . urlencode($func) . '&url=' . $_SERVER['HTTP_HOST']);
	$arr = json_decode($data, true);
	if ($arr['code'] == 1) {
		echo '<div class="alert alert-info"><small>' . $arr['msg'] . '</small></div>';
	} elseif (array_key_exists('msg', $arr)) {
		echo '<div class="alert alert-info"><small>' . $arr['msg'] . '</small></div>';
	} else {
		echo '<div class="alert alert-info"><small>' . $data . '</small></div>';
	}
}
if ($qqrow['qqlevel']) {
	$data = get_curl($dgapi . 'Status/api/submit.php?act=query&id=' . $qqrow['qqlevel'] . '&url=' . $_SERVER['HTTP_HOST']);
	$arr = json_decode($data, true);
	if ($arr['code'] == 1) {
		$func = explode(',', $arr['data']);
		if ($arr['enddate'] >= date("Y-m-d")) {
			$kminput = '<div class="form-group">
<label>QQ代挂配额激活码(可空):</label><br>
<input type="text" class="form-control" name="km" value="" placeholder="输入激活码以续期">
</div>';
			$msg = '<div class="alert alert-success">QQ:' . $qq . ' 已开通等级代挂功能，到期日期：<font color=red>' . $arr['enddate'] . '</font><br/>
			QQ等级代挂功能改为配额模式，再次输入激活码可以为您的QQ续期。';
		} else {
			$kminput = '<div class="form-group">
<label>*QQ代挂配额激活码:</label><br>
<input type="text" class="form-control" name="km" value="" placeholder="输入激活码以续期">
</div>';
			$msg = '<div class="alert alert-warning">QQ:' . $qq . ' 的等级代挂功能已过期（到期日期：<font color=red>' . $arr['enddate'] . '</font>），如需继续使用请及时续费！输入激活码可以为您的QQ续期。';
		}
	} elseif ($arr['code'] == - 1) {
		$kminput = '<div class="form-group">
<label>*QQ代挂配额激活码:</label><br>
<input type="text" class="form-control" name="km" value="" placeholder="输入激活码">
</div>';
		$msg = '<div class="alert alert-info">QQ等级代挂功能改为配额模式，首次开通请输入激活码，激活码将和你的QQ绑定。';
	} else {
		exit("<script language='javascript'>alert('" . $data . "');history.go(-1);</script>");
	}
} else {
	$kminput = '<div class="form-group">
<label>*QQ代挂配额激活码:</label><br>
<input type="text" class="form-control" name="km" value="" placeholder="输入激活码">
</div>';
	$msg = '<div class="alert alert-info">QQ等级代挂功能改为配额模式，首次开通请输入激活码，激活码将和你的QQ绑定。';
}
?>

<div class="panel panel-info">
<div class="panel-body box">
<?php echo $msg;?></div>
<p>温馨提示：代挂功能将会在晚上0点整系统自动进行代挂,请根据自身情况配合使用,比如：经常用手机的就无需开启手机QQ在线代挂功能。<br/>[ <a href="http://id.qq.com/level2/index.html" target="_blank">点此查询我的加速</a> ]</p>
<form action="?act=add&qq=<?php echo $qqrow['qq']?>&id=<?=$qqrow['qqlevel']?>&qid=<?=$qid?>" method="POST" role="form">
<?php echo $kminput?>
<div class="form-group">
<label>QQ密码:</label><br>
<input type="text" name="pwd" class="form-control" placeholder="QQ密码">
</div>
<div class="form-group">
<label>管家代挂:</label><br>
<select class="form-control" name="func_0">
<option value="1" <?php echo $func[0]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[0]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<div class="form-group">
<label>电脑QQ在线[会顶掉电脑QQ]:</label><br>
<select class="form-control" name="func_1">
<option value="1" <?php echo $func[1]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[1]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<div class="form-group">
<label>手机QQ在线[会顶掉手机QQ]:</label><br>
<select class="form-control" name="func_2">
<option value="1" <?php echo $func[2]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[2]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<div class="form-group">
<label>QQ勋章墙[会顶掉电脑QQ]:</label><br>
<select class="form-control" name="func_3">
<option value="1" <?php echo $func[3]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[3]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<div class="form-group">
<label>QQ音乐[全套加速]:</label><br>
<select class="form-control" name="func_4">
<option value="1" <?php echo $func[4]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[4]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<div class="form-group">
<label>QQ手机游戏升级加速:</label><br>
<select class="form-control" name="func_5">
<option value="1" <?php echo $func[5]==1?'selected="selected"':NULL?>>开启</option>
<option value="0" <?php echo $func[5]==0?'selected="selected"':NULL?>>关闭</option>
</select>
</div>
<input type="submit" class="btn btn-primary btn-block" value="确认"></form></div>


  

  
  
<?php
include_once 'core.foot.php';
?>
