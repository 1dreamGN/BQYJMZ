<?php
error_reporting(0);
	@header('Content-Type: text/html; charset=UTF-8');
	if(file_exists('install.lock')){
		exit('<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>已经安装提示信息</title>
        <style type="text/css">
html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
      <h3>已经安装提示信息</h3>
	  <center><h5>已经安装完成！如需重新安装，请删除install目录下的install.lock!</h5></center>
	  <center><h5>Powered by 冰清玉洁 &copy; 2015-2017 All rights reserved.</h5></center>
    </body>
    </html>');
	}
	$step=is_numeric($_GET['step'])?$_GET['step']:'1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>程序安装 - 冰清玉洁</title>

    <!-- Bootstrap core CSS -->
    <link href="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/css/style.css" rel="stylesheet">
    <link href="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/css/style-responsive.css" rel="stylesheet" />
	<body class="error-body no-top lazy" style="background: url(http://h2302701417.kuaiyunds.com/h2302701417/hero-bg.jpg);background-size: cover;"> 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-body">
<div class="container">
<?php if($step=='1'){?>
<form action="?step=2" class="form-sign" method="post">
<div class="form-signin">
<h2 class="form-signin-heading">installer</h2>
<div class="login-wrap">
		<p>冰清玉洁程序说明</p>
<p>欢迎使用冰清玉洁秒赞程序</p>
<p>本源码基于顾念开发的冰清玉洁V1.63进行开发</p>
<br/>
		<p>作者</p>
		<p>顾念 QQ2302701417</p>
		<br/>
<p>本源码承诺 安全 免费 无后门 无授权</p>
		<button class="btn btn-primary btn-block" type="submit">开始安装</button>
</div>
</div>
</form>
<?php }elseif($step=='2'){?>
<div class="form-signin">
<h2 class="form-signin-heading">installer</h2>
<div class="login-wrap">
		<form action="?step=3" class="form-sign" method="post">
		<label for="name">数据库地址:</label>
		<input type="text" class="form-control" name="DB_HOST" value="localhost">
		<label for="name">数据库端口:</label>
		<input type="text" class="form-control" name="DB_PORT" value="3306">
		<label for="name">数据库库名:</label>
		<input type="text" class="form-control" name="DB_NAME" placeholder="输入数据库库名">
		<label for="name">数据库用户名:</label>
		<input type="text" class="form-control" name="DB_USER" placeholder="输入数据库用户名">
		<label for="name">数据库密码:</label>
		<input type="password" class="form-control" name="DB_PWD" placeholder="输入数据库密码">
		<br><input type="submit" class="btn btn-primary btn-block" name="submit" value="确认，下一步">
		</form>
</div>
<?php }elseif($step=='3'){
	if($_POST['submit']){
		if(!$_POST['DB_HOST'] || !$_POST['DB_PORT'] || !$_POST['DB_NAME'] || !$_POST['DB_USER'] || !$_POST['DB_PWD']){
			echo'<script language=\'javascript\'>alert(\'所有项都不能为空\');history.go(-1);</script>';
		}else{
			if(!$con=mysql_connect($_POST['DB_HOST'].':'.$_POST['DB_PORT'],$_POST['DB_USER'],$_POST['DB_PWD'])){
				echo'<script language=\'javascript\'>alert("连接数据库失败，'.mysql_error().'");history.go(-1);</script>';
			}elseif(!mysql_select_db($_POST['DB_NAME'],$con)){
				echo'<script language=\'javascript\'>alert("选择的数据库不存在，'.mysql_error().'");history.go(-1);</script>';
			}else{
				mysql_query("set names utf8",$con);
				$data="<?php
return array(
	'DB_HOST'               =>  '{$_POST['DB_HOST']}',
    'DB_NAME'               =>  '{$_POST['DB_NAME']}',
    'DB_USER'               =>  '{$_POST['DB_USER']}',
    'DB_PWD'                =>  '{$_POST['DB_PWD']}',
    'DB_PORT'               =>  '{$_POST['DB_PORT']}',
    'DB_PREFIX'             =>  'bqyj_',
);";
				if(file_put_contents('../Core/database.php',$data)){
					$sqls=file_get_contents("install.sql");
					$explode = explode(";",$sqls);
					$num = count($explode);
					foreach($explode as $sql){
						if($sql=trim($sql)){
							mysql_query($sql);
						}
					}
					if(mysql_error()){
						echo'<script language=\'javascript\'>alert("导入数据表时错误，'.mysql_error().'");history.go(-1);</script>';
					}else{
						@file_put_contents('install.lock','');
				?>
<div class="form-signin">
<h2 class="form-signin-heading">installer</h2>
<div class="login-wrap">
		<p>网站安装成功</p>
		<p>共导入<?php echo $num;?>条数据</p>
		<p>1、管理员账号admin，密码admin，请尽快修改密码。</p>
		<p><a href="/index.php" class="btn btn-primary btn-block">网站首页</a></p>
</div>
</div>
				<?php
					}
				}else{
					echo'<script language=\'javascript\'>alert("保存数据库配置文件失败，请检查网站是否有写入权限！");history.go(-1);</script>';
				}
			}
		}
	}
}elseif($step=='4'){


?>


<?php }?>
</div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/js/jquery.js"></script>
    <script src="http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/install/js/bootstrap.min.js"></script>


  </body>
</html>