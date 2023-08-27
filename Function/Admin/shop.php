<?php
exit("<script language='javascript'>alert('暂未开放');window.location.href='index.php';</script>");
require_once('common.php');
C('webtitle','模板商城');
include_once 'common.head.php';
?>
<iframe src="http://www.shop.com/" id="includes" name="includes" width="100%" height="910" frameborder="0" scrolling="yes" style="overflow: visible;display:"></iframe>
	  <?php
include_once 'common.foot.php';
?>