<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=C('webname')?>-<?=C('webkey')?></title>
<script>
document.addEventListener('visibilitychange',function(){
if(document.visibilityState=='hidden') {
normal_title=document.title;
document.title='墨衫孤城，感谢曾经';
}
else
document.title=normal_title;
});
</script>

	<!-- css样式调用 -->
    <link rel="stylesheet" href="Template/index/reset.css">
    <link rel="stylesheet" href="Template/index/bootstrap.min.css">
    <link rel="stylesheet" href="Template/index/animate.css">
    <link rel="stylesheet" href="Template/index/swiper.css">
    <link rel="stylesheet" href="Template/index/flexslider.css">
	<!-- 字体文件调用 -->
    <link rel="stylesheet" href="https://fonts.cdn.1sll.cc/style/index/css/font-awesome.min.css">
    <link rel="stylesheet" href="Template/index/app.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<!-- Loading -->
<div id="loading" class="loading-layer">
<div class="adjust-block">
	<div class="load ">
		<span class="sharingan"></span>
		<span class="sharingan"></span>
		<span class="sharingan"></span>
	</div>
</div>
</div>
<!-- Site Header -->
<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-sm-2">

				</a>
				<span class="mobile-menu-icon visible-xs">
					<a id="btn-nav" href="#">
						<span></span>
						<span></span>
						<span></span>
					</a>
				</span> 
			</div>
			<div class="col-sm-10">
				<nav id="site-nav" class="nav-toggle">
					<ul class="menu">
						<li><a href="/index.php" >首页</a></li>
						<li><a href="/login.php" >立即登陆</a></li>
						<li><a href="/login.php?do=reg" >立即注册</a></li>
						<li><a href="/find.php" >找回密码</a></li>

							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div> 
	</div>
</header>
 <!-- Function/Index/ slider --> 
<div id="full-slider" class="flexslider section-slider">
	<ul class="slides">
		<li>
			<img src="<?=C('index_pic_1')?>" alt/>
			<div class="adjust-block">
				<h2 class="slide-title">
		        		<?=C('webname')?>
	        	</h2>
	        	<p class="slide-description">
	        		致力于帮助更多的用户提供稳定高效的秒赞服务
	        	</p>
	        	<div class="btns-row">
				<?php if(C('loginuid')){?>
				<a href="/Function/Index/" class="btn btn-tran">用户中心</a>
				<?php }else{?>
	        		<a href="/login.php" class="btn btn-tran">登陆</a>
	        		<a href="/login.php?do=reg" class="btn btn-tran">注册</a>
					<?php }?>
	        	</div>
			</div>
		</li>
		<li>
			<img src="<?=C('index_pic_2')?>" alt/>
			<div class="adjust-block">
				<h2 class="slide-title">
		        		<?=C('webname')?>
	        	</h2>
	        	<p class="slide-description">
	        		致力于帮助更多的用户提供稳定高效的秒赞服务
	        	</p>
	        	<div class="btns-row">
				<?php if(C('loginuid')){?>
				<a href="/Function/Index/" class="btn btn-tran">用户中心</a>
				<?php }else{?>
	        		<a href="/login.php" class="btn btn-tran">登陆</a>
	        		<a href="/login.php?do=reg" class="btn btn-tran">注册</a>
					<?php }?>
	        	</div>
			</div>
		</li>
		<li>
			<img src="<?=C('index_pic_3')?>" alt/>
			<div class="adjust-block">
				<h2 class="slide-title">
		        		<?=C('webname')?>
	        	</h2>
	        	<p class="slide-description">
	        		致力于帮助更多的用户提供稳定高效的秒赞服务
	        	</p>
	        	<div class="btns-row">
				<?php if(C('loginuid')){?>
				<a href="/Function/Index/" class="btn btn-tran">用户中心</a>
				<?php }else{?>
	        		<a href="/login.php" class="btn btn-tran">登陆</a>
	        		<a href="/login.php?do=reg" class="btn btn-tran">注册</a>
					<?php }?>
	        	</div>
			</div>
		</li>
		<li>
			<img src="<?=C('index_pic_4')?>" alt/>
			<div class="adjust-block">
				<h2 class="slide-title">
		        		<?=C('webname')?>
	        	</h2>
	        	<p class="slide-description">
	        		致力于帮助更多的用户提供稳定高效的秒赞服务
	        	</p>
	        	<div class="btns-row">
				<?php if(C('loginuid')){?>
				<a href="/Function/Index/" class="btn btn-tran">用户中心</a>
				<?php }else{?>
	        		<a href="/login.php" class="btn btn-tran">登陆</a>
	        		<a href="/login.php?do=reg" class="btn btn-tran">注册</a>
					<?php }?>
	        	</div>
			</div>
		</li>
	</ul>
</div>
<!-- Services -->
<CENTER><div class="section section-services">
	<div class="title-block title-sub">
		<h3 class="title-big">
			我们的功能
		</h3>
		<p class="sub-title">

		</p>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-code"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		节省流量
					 	</h3>
					 	<p class="serv-desc">
无需下载任何软件 / 无需挂机 电脑、手机、平板都可使用 / 免除流量
					 	</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-star-o"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		分布式执行
					 	</h3>
					 	<p class="serv-desc">
分布式监控系统/24小时不间断，服务器秒级切换/完美放手托管. 
					 	</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-lightbulb-o"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		离线托管
					 	</h3>
					 	<p class="serv-desc">
不管你在上班、上学、外出游玩，你是学生/老师/孕妇/工人、无需挂机/轻松离线云端点赞.
					 	</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-comment-o"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		失效提醒
					 	</h3>
					 	<p class="serv-desc">
QQ状态码过期提醒/服务开通，1秒响应/实时反馈/稳定高效 失效邮件提醒 高效快速.
					 	</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-bell-o"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		云端数据
					 	</h3>
					 	<p class="serv-desc">
QQ列表可查看您QQ目前的运行状况，云端大数据查看，详细清晰 操作简易，傻瓜式.
					 	</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="service-block service-left">
					<div class="circle-icon feature-icon">
						<i class="fa fa-film"></i>
					</div>
					<div class="serv-info">
							
					 	<h3 class="serv-title">
					 		专业分析
					 	</h3>
					 	<p class="serv-desc">
HTK系统拥有最清晰、尖锐的计算模式，QQ的一举一动都能记录到本地 安全智能.
					 	</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div></center>
<!-- Fun Info -->
<div class="section section-funinfo">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<div class="count-block">
					<div class="count-icon animate pulse">
						<i class="fa fa-laptop"></i>
					</div>
					<div class="count-amount animate zoomIn" data-to="<?=get_count('separate', '1=:1', 'fid', array(":1" => "1"))?>" data-refresh-interval="10"><?=get_count('separate', '1=:1', 'fid', array(":1" => "1"))?></div>
					<div class="count-name">
						旗下分站
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="count-block">
					<div class="count-icon animate pulse">
						<i class="fa fa-flag-o"></i>
					</div>
					<div class="count-amount animate zoomIn" data-to="<?php echo get_count('users', '1=:1', 'uid', array(':1' => '1'))?>" data-refresh-interval="10"><?php echo get_count('users', '1=:1', 'uid', array(':1' => '1'))?></div>
					<div class="count-name">
						系统用户
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="count-block">
					<div class="count-icon animate pulse">
						<i class="fa fa-heart-o"></i>
					</div>
					<div class="count-amount animate zoomIn" data-to="<?php echo get_count('qqs', '1=:1', 'uid', array(':1' => '1'))?>" data-refresh-interval="10"><?php echo get_count('qqs', '1=:1', 'uid', array(':1' => '1'))?></div>
					<div class="count-name">
						QQ数量
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="count-block">
					<div class="count-icon animate pulse">
						<i class="fa fa-code"></i>
					</div>
					<div class="count-amount animate zoomIn" data-to="<?php echo get_count('qqs', 'iszan=:2 or iszan=:1', 'qid', array(':1' => '1', ':2' => '2'))?>" data-refresh-interval="10"><?php echo get_count('qqs', 'iszan=:2 or iszan=:1', 'qid', array(':1' => '1', ':2' => '2'))?></div>
					<div class="count-name">
						正在秒赞
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 <!-- VIP价格表 -->

<div class="section section-pricing">
    <div class="title-block">
        <div class="title-big">
            VIP价格表
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="pricing-tab">
                    <div class="package-title">试用VIP</div>
                    <div class="package-price">
                        <span>￥1</span>/RMB
                    </div>
                    <ul class="package-advantage">
                        <li>享受一天试用VIP</li>
                        <li>可使用所有VIP的功能</li>
                        <li>享用VIP极速服务器</li>
                        <li>频率最低1分钟</li>
                    </ul>
                    <div class="buy-package">
                        <a class="btn btn-gra" href="Function/Index/shop.php">立即购买</a></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pricing-tab active">
                    <div class="package-title">一个月VIP会员</div>
                    <div class="package-price">
                        <span>￥3</span>/RMB
                    </div>
                    <ul class="package-advantage">
                        <li>享受一天试用VIP</li>
                        <li>可使用所有VIP的功能</li>
                        <li>享用VIP极速服务器</li>
                        <li>频率最低1分钟</li>
                    </ul>
                    <div class="buy-package">
                        <a class="btn btn-gra" href="Function/Index/shop.php">立即购买</a></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pricing-tab">
                    <div class="package-title">一个QQ配额</div>
                    <div class="package-price">
                        <span>￥2</span>/RMB
                    </div>
                    <ul class="package-advantage">
                        <li>享受一天试用VIP</li>
                        <li>可使用所有VIP的功能</li>
                        <li>享用VIP极速服务器</li>
                        <li>频率最低1分钟</li>
                    </ul>
                    <div class="buy-package">
                        <a class="btn btn-gra" href="Function/Index/shop.php">立即购买</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Let's work -->
<div class="section-offer">
 	<div class="container ">
 		<div class="row">
 			<div class="col-md-12">
 				<h3>Ta们正在使用<?=C('webname')?></h3>
				<?php
				$rowss = $db->query("select * from {$prefix}qqs where iszan='1' or iszan='2' order by qid desc limit 20");
				while ($row = $rowss->fetch(PDO::FETCH_ASSOC)) {
				?>
 				<div class="col-sm-2 col-xs-4 scrollpoint sp-effect1">
                    <div class="media">
                        <a class="pull-lefts" title="QQ：<?=$row['qq']?> 添加时间：<?=$row['addtime']?>"><img class="media-object img-circle" src="//q1.qlogo.cn/g?b=qq&nk=<?=$row['qq']?>&s=100" alt="<?=C("webname")?>"></a>
                    </div>
                </div>
				<?php } ?>
 			</div>
 


        </div>
    </div>
</div>



	<div class="section footer-top">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="fo-title">
						关于我们
					</div>
					<p class="fo-text">
远哥秒赞网 - 专业开发团队 融合最新的QQ空间协议接口 无缝兼容各类平台设备 基于restful标准化开发.
					</p>
					<div class="mem-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-google"></i></a>
						<a href="#"><i class="fa fa-instagram"></i></a>
					</div>
				</div>
				<div class="col-md-2">
					<div class="fo-title">
						服务
					</div>
					<div class="fo-nav">
						<a href="#">秒赞认证</a>
						<a href="#">用户中心</a>
						<a href="#">代理后台</a>
						<a href="#">空间异常查询</a>
					</div>
				</div>
				<div class="col-md-3">
					<div class="fo-title">
						服务
					</div>
					<div class="fo-nav">
						<a href="#">自助商城 - 购买Vip、配额</a>
						<a href="#">QQ添加 - 添加一个新的QQ</a>
						<a href="#">球球代点 - 球球大作战秒刷棒棒糖</a>
						<a href="#">CQY交友墙 - 添加QQ秒赞好友</a>
					</div>					
				</div>
				<div class="col-md-3">
					<div class="fo-title">
						MUSIC
					</div>
<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=86 src="<?=C('163_music')?>"></iframe>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer-bottom">
		<p class="copyright">
			&copy; 2017 ❤ 远哥秒赞网|墨衫孤城|<?=C('webname')?>
		</p>
	</footer>	
<script src="Template/index/jquery.js"></script>
<script src="Template/index/image-loaded.js"></script>
<script src="Template/index/wow.js"></script>
<script src="Template/index/swiper.jquery.min.js"></script>
<script src="Template/index/isotope.pkgd.min.js"></script>
<script src="Template/index/jquery.countto.js"></script>
<script src="Template/index/jquery.flexslider.js"></script>
<script src="Template/index/app.js"></script>

</body>
</html>

