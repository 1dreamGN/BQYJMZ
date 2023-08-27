<?php
require_once('common.php');
$mzversion = "1.3.8";
$cloudversion = file_get_contents("http://bqyj.qq-bq.cn/update/CloudUpdate.php"); //最新版本API
$updatemsg = get_curl("http://bqyj.qq-bq.cn/update/UpdateMsg.php"); //更新日志API
$download = file_get_contents("http://bqyj.qq-bq.cn/update/Download.php"); //下载地址API
$sddownload = $download; //下载地址API
$gonggao = get_curl("http://bqyj.qq-bq.cn/update/GongGao.php"); //程序公告API
if($isdomain)exit("<script language='javascript'>alert('您没有总站权限');window.location.href='/admin';</script>");
if($_POST['type'] == 'update'){
    if($_POST['submit'] == '返回首页')header('Location:../../Install/update.php');
    $RemoteFile = $download;
    $ZipFile = 'UPDATE.zip';
	copy($RemoteFile, $ZipFile) || showmsg("无法下载更新包文件{$download}", false, '', true);
    if(zipExtract($ZipFile, $_SERVER['DOCUMENT_ROOT'])){
		$upcode = 0;
        unlink($ZipFile);
        echo "<script language='javascript'>alert('升级完成');window.location.href='../../Install/update.php';</script>";
    }else{
        echo "<script language='javascript'>alert('无法解压文件');window.location.href='../index.php';</script>";
		$upcode = 0;
        if(file_exists($ZipFile))unlink($ZipFile);
    }
}
function zipExtract ($src, $dest){
	$zip = new ZipArchive();
	if ($zip->open($src)===true){
		$zip->extractTo($dest);
		$zip->close();
		return true;
	}
	return false;
}
C('webtitle', '网站升级');
include_once 'common.head.php';
?>
                    	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">网站升级</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><center>检测更新</center></h5>
            </div>
            <div class="panel-body">	
<?php
if ($cloudversion>$mzversion){
echo '<center><h4><p><font color="red">发现新版本</font></p><p><font color="green">最新版本为：V'.$cloudversion.'</font></p></h4></center>';
}else {
echo '<center><h4><p><font color="green">您使用的已是最新版本！</font></p><p>当前版本：V'.$mzversion.' (Build '.VERSION.')</p></h4></center>';
}
?>
</div>
</div>
</div>
<?php
if ($cloudversion>$mzversion){
echo '<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h5><center>日志详情</center></h5>
</div>
<div class="panel-body">
<form action="?" class="form-horizontal" method="post">
<input type="hidden" value="update" name="type" >
<P><center>'.$updatemsg.'</center></P>
<div class="list-group-item">
<div class="form-group text-right"><button class="btn btn-primary btn-block" type="submit" name="submit">点击升级</button></div>
</form>
</div>
</div>
</div>
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h5><center>更新须知</center></h5>
</div>
<div class="panel-body">
<h4>
<p><center>如果无法正常更新，可以进行手动下载更新。</center></p>
<p><center>更新包下载地址：<a href='.$sddownload.'> '.$sddownload.' </a></center></p>
</h4>
</div>
</div>
</div>';
}
?>
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h5><center>程序公告</center></h5>
</div>
<div class="panel-body">
<h4>
<P><center><?php echo $gonggao; ?></center></P>
</h4>
</div>
</div>
</div>

<?php
include_once 'common.foot.php';
?>