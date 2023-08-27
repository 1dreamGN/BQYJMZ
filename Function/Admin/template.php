<?php
require_once('common.php');
if ($_GET['template']) {
    $path = "Function/Template/index_" . $_GET['template'] . ".php";
    $db->query("insert into {$prefix}webconfigs set vkey='webindex',value='$path' on duplicate key update value='$path'");
    echo "<script language='javascript'>alert('模板更换成功！');window.location.href='template.php';</script>";
}
$template = require("../../Function/Template/config.php");
C('pageid', 'template');
C('webtitle', '模板管理');
include_once 'common.head.php';
$templates = require("../../Function/Template/readinfo.php");
?>

	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">界面设置</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
            <div class="col-sm-12">
                <div class="panel panel-default">
			<div class="panel-heading">
                    当前模板
			</div>
                <div class="panel-body" align="left">
                    <table cellspacing="20" cellpadding="0" width="80%" border="0">
                        <tr>
                            <td width="42%">
                                <img src="<?= $template['template_img'] ?>" width="240" height="180" border="1"/></td>
                            <td width="58%">
                                <?= ($template['template_name']) ?><br>
                                作者：<a
                                    href="<?= $template['template_url'] ?>"><?= ($template['template_author']) ?></a><br>
                                <?= ($template['template_readme']) ?>
                                <br>
                                <a href="?templates=tg&set=1">设置</a>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <hr>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center">模板库</h3>
                </div>
                <div class="panel-body" align="left">
                    <table cellspacing="0" cellpadding="0" width="99%" border="0" class="adm_tpl_list">
                        <tr>
                            <?php
                            foreach ($templatename as $key) {
                                echo '<td align="center">
	  <a href="?template=' . $key . '">
	  <img alt="点击使用该模板" src="' . $templatek[$key . '_template_img'] . '" width="180" height="150" border="0" />
	  </a><br />
      ' . ($templatek[$key . '_template_name']) . '      <span> | ' ?><?php if ($key == $template['alias']) { ?> 已设置 <?php } else { ?>
                                    点击图片使用模板</a><?php } ?></span>
                                </td>
                            <?php } ?>
                    </table>

                </div>
            </div>
        </div>

    </div>
<?php
include_once 'common.foot.php';
?>