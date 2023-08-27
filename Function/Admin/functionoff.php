<?php
require_once('common.php');
if ($do = $_POST['do']) {
    foreach ($_POST as $k => $value) {
        if (safestr($k) == 'web_separate_gg' && $isdomain) {
            exit("<script language='javascript'>alert('保存失败！您不能修改分站公告');window.location.href='functionoff.php';</script>");
        }
        $db->query("insert into {$prefix}webconfigs set vkey='" . safestr($k) . "',value='" . safestr($value) . "' on duplicate key update value='" . safestr($value) . "'");
    }
    if ($rows = $db->query('select * from ' . $prefix . 'webconfigs')) {
        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $webconfig[$row['vkey']] = $row['value'];
        }
        C($webconfig);
    }
    echo "<script language='javascript'>alert('保存成功！');window.location.href='functionoff.php';</script>";
}
C('webtitle', '功能开关');
C('pageid', 'off');
include_once 'common.head.php';
?>
	<div id="content" class="app-content" role="main">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">网站设置</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    功能off
                </div>
                <div class="panel-body">
                    <form action="?" class="form-horizontal ng-pristine ng-valid" method="post">
                        <input type="hidden" name="do" value="off">
							<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">腾讯反检测系统</label>
									<div class="col-sm-9 checkbox i-checks">
										<p>
											<label class="i-checks">
												<input type="radio" name="txprotect" value="0" checked=""><i></i> 关闭 
											</label>
											<label class="i-checks">
												<input type="radio" name="txprotect" value="1" <?php if(C('txprotect')==1) echo 'checked=""';?>><i></i>
												<font color="green"> 开启 </font>
											</label>
										</p>
									</div>
								</div>
									<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">免费VIP会员</label>
									<div class="col-sm-9 checkbox i-checks">
										<p>
											<label class="i-checks">
												<input type="radio" name="freevip" value="0" checked=""><i></i> 关闭 
											</label>
											<label class="i-checks">
												<input type="radio" name="freevip" value="1" <?php if(C('freevip')==1) echo 'checked=""';?>><i></i>
												<font color="green"> 开启 </font>
											</label>
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">PJAX+音乐播放器</label>
									<div class="col-sm-9 checkbox i-checks">
										<p>
											<label class="i-checks">
												<input type="radio" name="music" value="0" checked=""><i></i> 关闭前台PJAX+音乐播放器【全部用户】 
											</label>
											<label class="i-checks">
												<input type="radio" name="music" value="1" <?php if(C('music')==1) echo 'checked=""';?>><i></i>
												<font color="green"> 开启前台PJAX+音乐播放器【全部用户】 </font>
											</label>
										</p>
									</div>
								</div>
					   	<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">使用所有功能</label>
									<div class="col-sm-9 checkbox i-checks">
										<p>
											<label class="i-checks">
												<input type="radio" name="webfree" value="0" checked=""><i></i> 是VIP才可以使用所有功能
											</label>
											<label class="i-checks">
												<input type="radio" name="webfree" value="1" <?php if(C('webfree')==1) echo 'checked=""';?>><i></i>
												<font color="green"> 不是VIP也可以使用所有功能 </font>
											</label>
										</p>
									</div>
								</div>
                        <div class="list-group-item">
                            <button class="btn btn-primary btn-block" type="submit" name="submit" value="1">保存设置</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
include_once 'common.foot.php';
?>