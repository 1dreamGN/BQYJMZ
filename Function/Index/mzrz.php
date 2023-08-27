<?php
require_once('common.php');
C('webtitle', '秒赞认证');
C('pageid', 'mzrz');
if (empty($_GET["uin"])) {
	$qq = $_GET["qq"];
} else {
	$qq = $_GET["uin"];
}
if($_GET['do'] == 'search'){
    if(!$_POST['qq'] || !$qqrows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(':qq' => $_POST['qq']))){
        $dofor = 1;
    }
}else{
    if(!$qq || !$qqrows = get_results("select * from {$prefix}qqs where qq=:qq limit 1", array(':qq' => $qq))){
        $dofor = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>QQ<?php echo $qqrows['qq']?>在<?php echo C('webname');?>的个人专属秒赞认证页面</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-app-capable" content="yes">
    <meta name="apple-mobile-app-status-bar-style" content="black">
   
    <meta name="description" content="冰清玉洁秒赞">
    <meta name="keywords" content="顾念QQ2302701417">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="cononico">
    <meta name="application-name" content="Cononico" >

    <link rel="stylesheet" type="text/css" href="../../Template/other/css/main.css">
    <link rel="stylesheet" type="text/css" href="../../Template/other/css/process.css">
    <link rel="shortcut icon"  type="image/x-icon" href="favicon.ico" />
    
    <script type="text/javascript">
        //设定rem值
        document.getElementsByTagName("html")[0].style.fontSize = document.documentElement.clientWidth/20 + 'px';
    </script>
<!--[if lt IE 8]>
 <h5 class="text-center">你的浏览器弱渣了，为了更好的浏览体验，赶快<a href="http://browsehappy.com/" style="color:#53bafb">升级浏览器</a>吧！！</h5><![endif]-->
</head>
<body>
    <div class="wrapBox" id="wrapBox">
        <div class="box">
            <img class="box_bg" src="http://h2302701417.kuaiyunds.com/h2302701417/c0.jpg">
            <div class="box01_content">
                <div class="head_div">
                    <div class="cycle_item">
                        <a href="#" class="github_a" id="github_a" target="_blank">
                            <span class="github_icon"></span>
                            <span class="github_text"><p class="item_name">Mz认证</p></span>
                        </a>
                        <a href="http://user.qzone.qq.com/<?php echo $qqrows['qq']?>/" class="weibo_a" id="weibo_a" target="_blank">
                            <span class="weibo_icon"></span>
                            <span class="weibo_text"><p class="item_name">QQ空间</p> </span>
                        </a>
                        <a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=<?php echo $qqrows['qq']?>" class="blog_a" id="blog_a" target="_blank">
                            <span class="blog_icon"></span>
                            <span class="blog_text"><p class="item_name"> 加好友</p></span>
                        </a>

                        <div class="green_cycle">
                            <img class="green_cycle_img" src="../../Template/other/images/icon/green_cycle.svg">
                            <div class="yellow_cycle">
                                <img class="yellow_cycle_img" src="../../Template/other/images/icon/yellow_cycle.svg">
                                <div class="blue_cycle">
                                    <img class="blue_cycle_img" src="../../Template/other/images/icon/blue_cycle.svg">
                                    <div class="head_img_div">
                                        <img class="head_img" src="http://q1.qlogo.cn/g?b=qq&nk=<?php echo $qq ?>&s=240">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="title"><?php echo get_qqnick($qqrows['qq'])?></h1>
                <h2 class="title_h2">千里之行，始于点赞</h2>
                <div id="box01_text">
                <p class="box01_p">已通过<?php echo C('webname');?>的权威秒赞认证.</p>
				<p class="box01_p">为点赞添加一点新的色彩.</p>
				<p class="box01_p">弹指间 心无间</p>
                </div>
				
            </div>

        
            <div class="foot_power">
                <h3>©2016 Pwoerd 
                    <a href="#" title="ZBSEC" target="_blank"> <?php echo C('webname')?></a>
                </h3>
            </div>
        </foot>
    </div>
    <script type="text/javascript" src="../../Template/other/js/main.js"></script>
	<audio autoplay="autoplay">
<source src="http://music.163.com/#/song?id=26085473" type="audio/mpeg" />
</audio>
</body>
<audio autoplay="autoplay"><source src="http://cos.zb-sec.com/bgm/Taylor Swift/Taylor Swift - Clean.mp3
" type="audio/mpeg" /></audio></script>
</html>
<?php if($dofor == 1){
}else{
    ?>
	
<?php }?>