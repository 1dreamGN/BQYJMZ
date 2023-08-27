<?php
require_once('common.php');
$qid = is_numeric($_GET['qid'])?$_GET['qid']:'0';
if(!$qid || !$qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':qid' => $qid, ':uid' => $userrow['uid']))){
    exit("<script language='javascript'>alert('QQ不存在！');window.location.href='/Function/Index/';</script>");
}elseif($_POST['do'] == 'zan'){
    $is = is_numeric($_POST['is'])?$_POST['is']:'0';
    $net = is_numeric($_POST['net'])?$_POST['net']:'0';
    $rate = $_POST['rate']?$_POST['rate']:'60';
    if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend']))exit("<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
    if($is && !$net){
        echo "<script language='javascript'>alert('请选择个合适的服务器');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($net && $qqrow['zannet'] != $net && get_count('qqs', 'zannet=:net', 'qid', array(':net' => $net)) >= C('netnum')){
        echo "<script language='javascript'>alert('{$net}号服务器已满，请换一个服务器！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }else{
        $db -> query("update {$prefix}qqs set iszan='$is',zannet='$net',zanrate='$rate' where qid='$qid'");
        echo "<script language='javascript'>alert('说说秒赞修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }
}elseif($_POST['do'] == 'shuo'){
    $is = is_numeric($_POST['is'])?$_POST['is']:'0';
    $net = is_numeric($_POST['net'])?$_POST['net']:'0';
    $rate = is_numeric($_POST['rate'])?$_POST['rate']:'0';
    $con = safestr($_POST['content']);
    $url = safestr($_POST['shuopic']);
    $gg = safestr($_POST['shuogg']);
    if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend']))exit("<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
    if($net && $qqrow['shuonet'] != $net && get_count('qqs', 'shuonet=:net', 'qid', array(':net' => $net)) >= C('netnum'))exit("<script language='javascript'>alert('{$net}号服务器已满，请换一个服务器！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
    $db -> query("update {$prefix}qqs set isshuo='$is',shuoshuo='$con',shuonet='$net',shuopic='$url',shuorate='$rate',shuogg='$gg' where qid='$qid'");
    echo "<script language='javascript'>alert('自动说说修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
}
if($do = $_POST['do']){
    if(!C('webfree') && !get_isvip($userrow['vip'], $userrow['vipend']))exit("<script language='javascript'>alert('对不起，你不是VIP,无法开启功能！');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>");
    $is = is_numeric($_POST['is'])?$_POST['is']:'0';
    $net = is_numeric($_POST['net'])?$_POST['net']:'0';
    $rate = $_POST['rate'];
    if($do == 'reply'){
        $con = safestr($_POST['content']);
        $db -> query("update {$prefix}qqs set isreply='$is',replycon='$con',replynet='$net',replyrate='$rate' where qid='$qid'");
        echo "<script language='javascript'>alert('说说秒评修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'qqd'){
        $qunnum = safestr($_POST['qunnum']);
        $db -> query("update {$prefix}qqs set isqqd='$is',qunnum='$qunnum' where qid='$qid'");
        echo "<script language='javascript'>alert('群签到修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'qwqd'){
        $qwqdnum = safestr($_POST['qwqdnum']);
        $db -> query("update {$prefix}qqs set isqwqd='$is',qwqdnum='$qwqdnum' where qid='$qid'");
        echo "<script language='javascript'>alert('群问签到修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'zf'){
        $con = safestr($_POST['content']);
        $zfok = safestr($_POST['zfok']);
        $db -> query("update {$prefix}qqs set iszf='$is',zfcon='$con',zfok='$zfok',replynet='$net',replyrate='$rate' where qid='$qid'");
        echo "<script language='javascript'>alert('转发说说修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'qt'){
        $db -> query("update {$prefix}qqs set isqt='$is' where qid='$qid'");
        echo "<script language='javascript'>alert('说说圈图成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'del'){
        $db -> query("update {$prefix}qqs set isdel='$is' where qid='$qid'");
        echo "<script language='javascript'>alert('删除说说修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'dell'){
        $db -> query("update {$prefix}qqs set isdell='$is' where qid='$qid'");
        echo "<script language='javascript'>alert('删除留言修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'qd'){
        $con = safestr($_POST['content']);
        $db -> query("update {$prefix}qqs set isqd='$is',qdcon='$con' where qid='$qid'");
        echo "<script language='javascript'>alert('空间签到修改成功');window.location.href='/Function/Index/qqlist.php?qid=$qid';</script>";
    }elseif($do == 'upload'){
        if(($_FILES['file']['type'] == 'image/gif') || ($_FILES['file']['type'] == 'image/jpeg') || ($_FILES['file']['type'] == 'image/pjpeg') || ($_FILES['file']['type'] == 'image/png')){
            if($_FILES['file']['error'] > 0){
                echo "<script language='javascript'>alert('图片上传失败。" . $_FILES['file']['error'] . "');</script>";
            }else{
                $image = file_get_contents($_FILES['file']['tmp_name']);
                $upload = uploadimg($qqrow['qq'], $qqrow['sid'], $image);
                if(!stripos('z' . $upload, '图片')){
                    $uploadimg = $upload;
                    echo "<script language='javascript'>alert('图片上传成功，请点击保存！');</script>";
                }else{
                    exit("<script language='javascript'>alert('上传QQ空间失败！" . $upload . "');</script>");
                }
            }
        }else{
            exit("<script language='javascript'>alert('图片格式不正确！');history.go(-1);</script>");
        }
    }
    $qqrow = get_results("select * from {$prefix}qqs where qid=:qid and uid=:uid limit 1", array(':uid' => $qid, ':uid' => $userrow['uid']));
    if($uploadimg)$qqrow['shuopic'] = $uploadimg;
}
C('webtitle', 'QQ' . $qqrow['qq']);
C('pageid', 'qqset');
include_once 'core.head.php';
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">功能设置</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
				<div class="col-lg-6
<?php if($_GET['xz'] != 'zan'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">说说秒赞设置<span class="right">【<?php echo getzt($qqrow['iszan'])?>】</span></div>
                     <div class="panel-body">
							<form action="?qid=<?php echo $qid?>&xz=zan#zan" role="form" class="form-horizontal" method="post">
								<input type="hidden" name="do" value="zan">
								<div class="list-group-item red">
                                <p><font color="red">若出现重复赞或不能赞,请及时更换协议</font></p>
                                <p>服务器速度越快漏赞越少,速度慢的在你好友越多时漏赞也越多。</p>
                            </div>


							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">秒赞协议</div>
                                    <select name="is" class="form-control">
										<option value="0" selected="">关闭</option>
										<option value="1"
<?php if($qqrow['iszan'] == 1)echo 'selected=""';
?>>触屏版</option>
										<option value="2"
<?php if($qqrow['iszan'] == 2)echo 'selected=""';
?>>电脑版(推荐)</option>
                                    </select>
                                </div>
                            </div>


								<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">服务器</div>
                                    <select name="net" class="form-control">


<?php $str = '';
for($i = 1;$i <= C('zannet');$i++){
    $str .= "<option value ='{$i}' ";
    if($qqrow['zannet'] == $i){
        $str .= "selected='selected'";
    }
    $str .= ">{$i}号云端服务器(";
    $num = get_count('qqs', "zannet='$i'", 'qid');
    if($num >= C('netnum')){
        $str .= '共' . $num . '个人 已满';
    }else{
        $sy = (C('netnum') - $num);
        $str .= "已有{$num}人 还可加入" . $sy . '个';
    }
    $str .= ')</option>';
}
echo $str;
?>
					</select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">频率</div>
                                    <select class="form-control" name="rate">
										<option value ="60"
<?php if($qqrow['zanrate'] == 60)echo "selected='selected'";
?>>1分钟</option><option value ="120"
<?php if($qqrow['zanrate'] == 120)echo "selected='selected'";
?>>2分钟</option><option value ="180"
<?php if($qqrow['zanrate'] == 180)echo "selected='selected'";
?>>3分钟</option><option value ="240"
<?php if($qqrow['zanrate'] == 150)echo "selected='selected'";
?>>4分钟</option><option value ="300"
<?php if($qqrow['zanrate'] == 300)echo "selected='selected'";
?>>5分钟</option><option value ="360"
<?php if($qqrow['zanrate'] == 360)echo "selected='selected'";
?>>6分钟</option><option value ="420"
<?php if($qqrow['zanrate'] == 420)echo "selected='selected'";
?>>7分钟</option><option value ="480"
<?php if($qqrow['zanrate'] == 300)echo "selected='selected'";
?>>8分钟</option><option value ="540"
<?php if($qqrow['zanrate'] == 540)echo "selected='selected'";
?>>9分钟</option><option value ="600"
<?php if($qqrow['zanrate'] == 600)echo "selected='selected'";
?>>10分钟</option><option value ="660"
<?php if($qqrow['zanrate'] == 660)echo "selected='selected'";
?>>11分钟</option><option value ="720"
<?php if($qqrow['zanrate'] == 450)echo "selected='selected'";
?>>12分钟</option><option value ="780"
<?php if($qqrow['zanrate'] == 780)echo "selected='selected'";
?>>13分钟</option><option value ="840"
<?php if($qqrow['zanrate'] == 840)echo "selected='selected'";
?>>14分钟</option><option value ="900"
<?php if($qqrow['zanrate'] == 900)echo "selected='selected'";
?>>15分钟</option>									</select>
                                </div>
                            </div>
								<div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
							</form>
						</div>
						</div>
				</div>
				<div class="col-lg-6
<?php if($_GET['xz'] != 'qt'){
    echo'hide';
}
?>">
				<div class="panel panel-default">
                     <div class="panel-heading">说说圈图设置<span class="right">【<?php echo getzt($qqrow['isqt'])?>】</span></div>
                     <div class="panel-body">
                        <form action="?qid=<?php echo $qid?>&xz=qt#qt" role="form" class="form-horizontal" method="post">
                            <input type="hidden" name="do" value="qt">
                            <div class="list-group-item red"><span>说说圈图功能目前尚不稳定，容易出频繁！建议频率不要太快！</span>
                            </div>
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">圈图开关</div>
                                    <select name="is" class="form-control">
										<option value="0" selected="">关闭</option>
                                        <option value="1"
<?php if($qqrow['isqt'] == 2)echo 'selected=""';
?>>开启</option>
                                    </select>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
			</div>
			<div class="col-lg-6
<?php if($_GET['xz'] != 'reply'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">说说秒评设置<span class="right">【<?php echo getzt($qqrow['isreply'])?>】</span></div>
                     <div class="panel-body">
                        <form action="?qid=<?php echo $qid?>&xz=reply#reply" role="form" class="form-horizontal" method="post">
                            <input type="hidden" name="do" value="reply">
                            <div class="list-group-item red"><span>1、秒评会导致空间被禁言，有几率会被封空间，不建议开启！</span>
                            </div>
                            <div class="list-group-item red"><span>2、<a target="_blank" href="http://kf.qq.com/qzone/remove_qzone.html">点击查询是否被禁言</a></span>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">说说秒评</div>
                                    <select name="is" class="form-control">
                                        <option value="0" selected="">关闭</option>
                                        <option value="1"
<?php if($qqrow['isreply'] == 1)echo 'selected=""';
?>>触屏版(推荐)</option>
                                        <option value="2"
<?php if($qqrow['isreply'] == 2)echo 'selected=""';
?>>PC版</option>
                                    </select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">服务器</div>
                                    <select class="form-control" name="net">


<?php $str = '';
for($i = 1;$i <= C('replynet');$i++){
    $str .= "<option value ='{$i}' ";
    if($qqrow['replynet'] == $i){
        $str .= "selected='selected'";
    }
    $str .= ">{$i}号云端服务器(";
    $num = get_count('qqs', "replynet='$i'", 'qid');
    if($num >= C('netnum')){
        $str .= '共' . $num . '个人 已满';
    }else{
        $sy = (C('netnum') - $num);
        $str .= "已有{$num}人 还可加入" . $sy . '个';
    }
    $str .= ')</option>';
}
echo $str;
?>

					</select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">频率</div>
                                    <select class="form-control" name="rate">
										<option value ="60"
<?php if($qqrow['replyrate'] == 60)echo "selected='selected'";
?>>1分钟</option><option value ="120"
<?php if($qqrow['replyrate'] == 120)echo "selected='selected'";
?>>2分钟</option><option value ="180"
<?php if($qqrow['replyrate'] == 180)echo "selected='selected'";
?>>3分钟</option><option value ="240"
<?php if($qqrow['replyrate'] == 150)echo "selected='selected'";
?>>4分钟</option><option value ="300"
<?php if($qqrow['replyrate'] == 300)echo "selected='selected'";
?>>5分钟</option><option value ="360"
<?php if($qqrow['replyrate'] == 360)echo "selected='selected'";
?>>6分钟</option><option value ="420"
<?php if($qqrow['replyrate'] == 420)echo "selected='selected'";
?>>7分钟</option><option value ="480"
<?php if($qqrow['replyrate'] == 300)echo "selected='selected'";
?>>8分钟</option><option value ="540"
<?php if($qqrow['replyrate'] == 540)echo "selected='selected'";
?>>9分钟</option><option value ="600"
<?php if($qqrow['replyrate'] == 600)echo "selected='selected'";
?>>10分钟</option><option value ="660"
<?php if($qqrow['replyrate'] == 660)echo "selected='selected'";
?>>11分钟</option><option value ="720"
<?php if($qqrow['replyrate'] == 450)echo "selected='selected'";
?>>12分钟</option><option value ="780"
<?php if($qqrow['replyrate'] == 780)echo "selected='selected'";
?>>13分钟</option><option value ="840"
<?php if($qqrow['replyrate'] == 840)echo "selected='selected'";
?>>14分钟</option><option value ="900"
<?php if($qqrow['replyrate'] == 900)echo "selected='selected'";
?>>15分钟</option>									</select>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">自定义内容</div>
                                    <input type="text" class="form-control" name="content" placeholder="输入你要评论的内容，留空系统随机内容" value="<?php echo $qqrow['replycon']?>">
                                </div>
                            </div>
                            <div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
				<div class="col-lg-6
<?php if($_GET['xz'] != 'qwqd'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">群问问设置<span class="right">【<?php echo getzt($qqrow['isqwqd'])?>】</span></div>
                     <div class="panel-body">
                        <form action="?qid=<?php echo $qid?>&xz=qwqd#qwqd" role="form" class="form-horizontal" method="post">
                            <input type="hidden" name="do" value="qwqd">
                            <div class="list-group-item red"><span>有时候有的号只能获取部分QQ号 若未群问签到 请看准时间是否可以签到！</span>
                            </div>
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">签到开关</div>
                                    <select name="is" class="form-control">
										<option value="0" selected="">关闭</option>
                                        <option value="1"
<?php if($qqrow['isqwqd'] == 1)echo 'selected=""';
?>>自定义群问签到</option>
										<option value="2"
<?php if($qqrow['isqwqd'] == 2)echo 'selected=""';
?>>全部群问问签到</option>
                                    </select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">自定义群</div>
                                    <input type="text" class="form-control" name="qwqdnum" placeholder="输入你要签到的群" value="<?php echo $qqrow['qwqdnum']?>">
                                </div>
                            </div>
                            <div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
                </div>
				<div class="col-lg-6
<?php if($_GET['xz'] != 'qqd'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">群签到设置<span class="right">【<?php echo getzt($qqrow['isqqd'])?>】</span></div>
                     <div class="panel-body">
                        <form action="?qid=<?php echo $qid?>&xz=qqd#qqd" role="form" class="form-horizontal" method="post">
                            <input type="hidden" name="do" value="qqd">
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">签到开关</div>
                                    <select name="is" class="form-control">
										<option value="0" selected="">关闭</option>
                                        <option value="1"
<?php if($qqrow['isqqd'] == 1)echo 'selected=""';
?>>自定义群签到</option>
										<option value="2"
<?php if($qqrow['isqqd'] == 2)echo 'selected=""';
?>>全部群签到</option>
                                    </select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">自定义群</div>
                                    <input type="text" class="form-control" name="qunnum" placeholder="输入你要签到的群" value="<?php echo $qqrow['qunnum']?>">
                                </div>
                            </div>
                            <div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
                </div>
	<div class="col-lg-6
<?php if($_GET['xz'] != 'zf'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">说说转发设置<span class="right">【<?php echo getzt($qqrow['iszf'])?>】</span></div>
                     <div class="panel-body">
                        <form action="?qid=<?php echo $qid?>&xz=zf#zf" role="form" class="form-horizontal" method="post">

                            <input type="hidden" name="do" value="zf">
                            <div class="list-group-item red"><span>建议使用触屏版，选择触屏版若长时间无法使用可尝试切换到PC版。</span>
                            </div>
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">转发说说</div>
                                    <select name="is" class="form-control">
                                        <option value="0"
<?php if($qqrow['iszf'] == 0)echo 'selected=""';
?>>关闭</option>
                                        <option value="1"
<?php if($qqrow['iszf'] == 1)echo 'selected=""';
?>>触屏版</option>
                                        <option value="2"
<?php if($qqrow['iszf'] == 2)echo 'selected=""';
?>>电脑版(推荐)</option>
                                    </select>
                                </div>
                            </div>
							<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">服务器</div>
                                    <select class="form-control" name="net">

<?php $str = '';
for($i = 1;$i <= C('zfnet');$i++){
    $str .= "<option value ='{$i}' ";
    if($qqrow['zfnet'] == $i){
        $str .= "selected='selected'";
    }
    $str .= ">{$i}号云端服务器(";
    $num = get_count('qqs', "zfnet='$i'", 'qid');
    if($num >= C('netnum')){
        $str .= '共' . $num . '个人 已满';
    }else{
        $sy = (C('netnum') - $num);
        $str .= "已有{$num}人 还可加入" . $sy . '个';
    }
    $str .= ')</option>';
}
echo $str;
?>
 									</select>
                                </div>
                            </div>

                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">转发QQ</div>
                                    <input type="text" class="form-control" name="zfok" placeholder="输入你要转发的QQ" value="<?php echo $qqrow['zfok']?>">
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">转发内容</div>
                                    <input type="text" class="form-control" name="content" placeholder="输入转发说说时的内容" value="<?php echo $qqrow['zfcon']?>">
                                </div>
                            </div>
                            <div class="list-group-item">
                                <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
                </div>



<div class="col-lg-6
<?php if($_GET['xz'] != 'shuo'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">自动说说设置<span class="right">【<?php echo getzt($qqrow['isshuo'])?>】</span></div>
                     <div class="panel-body">
                            <form action="?qid=<?php echo $qid?>&xz=shuo#shuo" role="form" class="form-horizontal" method="post">
                                <input type="hidden" name="do" value="shuo">
                                <div class="list-group-item red">
                                <span>建议选择触屏版，PC版发说说会由于空间被禁言而发送失败！</span>
                                <br/>
                                <span>建议频率至少120分钟，越快越容易导致空间被禁赞！</span>
                                <br/>
                                <span>自定义说说后缀留空则没有后缀（仅VIP用户可以修改）。</span>
                            </div>

                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">自动发说说</div>
                                        <select name="is" class="form-control">
                                      <option value="0"
<?php if($qqrow['isshuo'] == 0)echo 'selected=""';
?>>关闭</option>
                                        <option value="1"
<?php if($qqrow['isshuo'] == 1)echo 'selected=""';
?>>触屏版(推荐)</option>
                                        <option value="2"
<?php if($qqrow['isshuo'] == 2)echo 'selected=""';
?>>电脑版</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">发说说频率</div>
                                        <select name="rate" class="form-control">

<?php $str = '';
for($i = 5;$i <= 60;$i = $i + 0x05){
    $str .= "<option value ='{$i}' ";
    if($qqrow['shuorate'] == $i){
        $str .= "selected='selected'";
    }
    $str .= ">{$i}分钟</option>";
}
echo $str;
?>
                                        </select>
                                    </div>
                                </div>
								<div class="list-group-item">
                                <div class="input-group">
                                    <div class="input-group-addon">服务器</div>
                                    <select class="form-control" name="net">

<?php $str = '';
for($i = 1;$i <= C('shuonet');$i++){
    $str .= "<option value ='{$i}' ";
    if($qqrow['shuonet'] == $i){
        $str .= "selected='selected'";
    }
    $str .= ">{$i}号云端服务器(";
    $num = get_count('qqs', "shuonet='$i'", 'qid');
    if($num >= C('netnum')){
        $str .= '共' . $num . '个人 已满';
    }else{
        $sy = (C('netnum') - $num);
        $str .= "已有{$num}人 还可加入" . $sy . '个';
    }
    $str .= ')</option>';
}
echo $str;
?>
										</select>
                                </div>
                            </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">说说内容</div>
                                        <input type="text" class="form-control" name="content" placeholder="空为默认随机语录" value="<?php echo $qqrow['shuoshuo']?>">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">说说图片</div>
                                        <input type="text" class="form-control" name="shuopic" placeholder="[图片]为随机图片" value="<?php echo $qqrow['shuopic']?>">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">自定义说说后缀</div>
                                        <input type="text" class="form-control" name="shuogg" placeholder="输入自定义说说后缀，留空则没有后缀" value="<?php echo $qqrow['shuogg']?>">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
				<div class="col-lg-6
<?php if($_GET['xz'] != 'qd'){
    echo'hide';
}
?>">
					<div class="panel panel-default">
                     <div class="panel-heading">空间签到设置<span class="right">【<?php echo getzt($qqrow['isqd'])?>】</span></div>
                     <div class="panel-body">
                            <form action="?qid=<?php echo $qid?>&xz=qd#qd" role="form" class="form-horizontal" method="post">
                                <input type="hidden" name="do" value="qd">
                                <div class="list-group-item red"><span>系统默认为天气签到，获取2黄豆。<a href="http://rc.qzone.qq.com/pointmall" target="_blank">去兑换</a></span>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">空间签到</div>
                                        <select name="is" class="form-control">
                                            <option value="0" selected="">关闭</option>
                                        <option value="1"
<?php if($qqrow['isqd'] == 1)echo 'selected=""';
?>>触屏版</option>
                                        <option value="2"
<?php if($qqrow['isqd'] == 2)echo 'selected=""';
?>>电脑版(推荐)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <div class="input-group-addon">签到内容</div>
                                        <input type="text" class="form-control" name="content" placeholder="输入你签到的内容" value="<?php echo $qqrow['qdcon']?>">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <input type="submit" name="submit" value="保存配置" class="btn btn-primary btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

				<!--结束-->
			<div class="col-lg-6 ">
                <div class="panel panel-default">
                     <div class="panel-heading">文本提示</div>
                     <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="list-group-item red"><span>所有功能的内容部分可以使用以下标签</span>
                            </div>
                            <div class="list-group-item red"><span><code>[表情]</code>使用随机表情<br><code>[语录]</code>使用随机语录<br><code>[时间]</code>发布时的系统时间</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
</div>
</div>
<?php
include_once 'core.foot.php';
?>