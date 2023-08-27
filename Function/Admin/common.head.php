<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?=C('webtitle')?> | <?=C('webname')?></title>
  <meta name="description" content="QZONE助手,QQ空间红人必备神奇,QQ空间点赞插件,QQ助手,微商必备工具" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="../../Template/admin/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="../../Template/admin/animate.css" type="text/css" />
  <link rel="stylesheet" href="../../Template/admin/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="../../Template/admin/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="../../Template/admin/font.css" type="text/css" />
  <!--<link rel="stylesheet" href="/src/css/app.css" type="text/css" />-->
  <link rel="stylesheet" href="../../Template/admin/app.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?= $admin_api ?>/Template/admin/sweetalert.css">
  <script src="<?= $admin_api ?>/Template/admin/sweetalert.min.js"></script>
 <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="app app-header-fixed" id="app">
    <!-- navbar -->
    <div class="app-header navbar">
      <!-- navbar header -->
      <div class="navbar-header bg-dark">
        <button class="pull-right visible-xs dk" data-toggle="class:show" data-target=".navbar-collapse">
          <i class="glyphicon glyphicon-cog"></i>
        </button>
        <button class="pull-right visible-xs" data-toggle="class:off-screen" data-target=".app-aside" ui-scroll="app">
          <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <!-- brand -->
        <a href="#/" class="navbar-brand text-lt">
          <i class="fa fa-btc"></i>
          <img src="<?= $admin_api ?>/Template/static/img/logo.png" alt="." class="hide">
          <span class="hidden-folded m-l-xs"><?=C('webname')?></span>
        </a>
        <!-- / brand -->
      </div>
      <!-- / navbar header -->

      <!-- navbar collapse -->
      <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
          <a class="btn no-shadow navbar-btn" data-toggle="class:app-aside-folded" data-target=".app">
            <i class="fa fa-dedent fa-fw text"></i>
            <i class="fa fa-indent fa-fw text-active"></i>
          </a>
        </div>
        <!-- / buttons -->

        <!-- link and dropdown -->
        <ul class="nav navbar-nav hidden-sm">
          <li class="dropdown pos-stc">
            <a data-toggle="dropdown" class="dropdown-toggle">
              <span>快捷操作</span> 
              <span class="caret"></span>
            </a>
            <div class="dropdown-menu wrapper w-full bg-white">
              <div class="row">
                <div class="col-sm-4">
                  <div class="m-l-xs m-t-xs m-b-xs font-bold">快速跳转</div>
                  <div class="row">
                    <div class="col-xs-6">
                      <ul class="list-unstyled l-h-2x">
                        <li>
                          <a href="/"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>网站首页</a>
                        </li>
                        <li>
                          <a href="/login.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>用户登录</a>
                        </li>
                        <li>
                          <a href="/login.php?do=reg"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>用户注册</a>
                        </li>
                        <li>
                          <a href="/find.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>密码找回</a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-xs-6">
                      <ul class="list-unstyled l-h-2x">
					  <?php if($userrow['active']==9){?>
                        <li>
                          <a href="/Function/Admin/index.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>站长后台</a>
                        </li>
					  <?php }?>
					  <?php if($userrow['daili']){?>
                        <li <?php if(C('pageid')=='daili'){ echo'class="active"';}?>>
                           <a href="/Function/Index/daili.php" title="代理后台">
                             <i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>代理后台
                           </a>
                        </li>
						<?php } ?>
                        <li>
                          <a href="/Function/Index/index.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>用户中心</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <!-- / link and dropdown -->

        <!-- nabar right -->
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="//q4.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['qq']?>&spec=100" alt="...">
                <i class="on md b-white bottom"></i>
              </span>
              <span class="hidden-sm hidden-md"><?=$userrow['user']?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
              <li>
                <a href="/Function/Index/index.php">
                  <span class="badge bg-danger pull-right">30%</span>
                  <span>用户中心</span>
                </a>
              </li>
              <li>
                <a href="/Function/Index/uset.php">
                  <span class="label bg-info pull-right">new</span>
                  修改密码
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="/Function/Index/logout.php">退出登录</a>
              </li>
            </ul>
            <!-- / dropdown -->
          </li>
        </ul>
        <!-- / navbar right -->

      </div>
      <!-- / navbar collapse -->
    </div>
    <!-- / navbar -->

    <!-- menu -->
    <div class="app-aside hidden-xs bg-dark">
      <div class="aside-wrap">
        <div class="navi-wrap">
          <!-- user -->
          <div class="clearfix hidden-xs text-center" id="aside-user">
            <div class="dropdown wrapper">
              <a ui-sref="app.page.profile">
                <span class="thumb-lg w-auto-folded avatar m-t-sm">
                  <img src="https://q1.qlogo.cn/g?b=qq&nk=<?=$userrow['qq']?>&s=100&t=1420118110" class="img-full" alt="...">
                </span>
              </a>
              <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                <span class="clear">
                  <span class="block m-t-sm">
                    <strong class="font-bold text-lt"><?=$userrow['user']?></strong> 
                    <b class="caret"></b>
                  </span>
                  <span class="text-muted text-xs block">管理员 </span>
                </span>
              </a>
              <!-- dropdown -->
              <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                <li class="wrapper b-b m-b-sm bg-info m-t-n-xs">
                  <span class="arrow top hidden-folded arrow-info"></span>
                  <div class="text-center">
                    <span><?=$userrow['user']?></span>
                  </div>
                </li>
                <li>
                <a href="/Function/Index/index.php">
                  <span class="badge bg-danger pull-right">30%</span>
                  <span>用户中心</span>
                </a>
              </li>
              <li>
                <a href="/Function/Index/uset.php">
                  <span class="label bg-info pull-right">new</span>
                  修改密码
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="/Function/Index/logout.php">退出登录</a>
              </li>
              </ul>
              <!-- / dropdown -->
            </div>
          </div>
          <!-- / user -->

          <!-- nav -->
          <nav ui-nav class="navi">
            <ul class="nav">
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span translate="aside.nav.HEADER">导航</span>
              </li>
              <li <?php if(C('pageid')=='index'){ echo'class="active"';}?>>    
				  <a href="/Function/Admin/index.php">
                  <i class="glyphicon glyphicon-home icon text-primary-dker"></i>
				  <b class="label bg-info pull-right">N</b>
                  <span class="font-bold">后台首页</span>
                </a>
              </li>
			  <li <?php if(C('pageid')=='km'){ echo'class="active"';}?>>
                <a class="auto" href="/Function/Admin/km.php">
                  <i class="glyphicon glyphicon-credit-card icon text-info-lter"></i>
                  <span class="font-bold">卡密管理</span>
                </a>
              </li>
              <li <?php if(C('pageid')=='adminset' or C('pageid')=='Template'){ echo'class="active"';}?>>
                <a class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-th-large icon text-success"></i>
                  <span class="font-bold">系统管理</span>
                </a>
                <ul class="nav nav-sub dk">
                <li><a href="/Function/Admin/set.php">网站设置</a></li>
				<li><a href="/Function/Admin/functionoff.php">功能开关</a></li>
				<li><a href="/Function/Admin/template.php">界面管理</a></li>
				<li><a href="/Function/Admin/ggset.php">公告管理</a></li>
				<li><a href="/Function/Admin/weblink.php">友情链接</a></li>
				<?php if(C('dgapi')==1){?>
				<li><a href="/Function/Admin/dgset.php">代挂设置</a></li>
				<?php }?>
                </ul>
              </li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>功能</span>
              </li>
			  <?php if($isdomain){}else{?>
              <li  <?php if(C('pageid')=='adminfz'){ echo'class="active"';}?>>
			  <a class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="fa fa-navicon icon"></i>
                  <span>分站管理</span>
                </a>
                <ul class="nav nav-sub dk">
                      
					<li>
                    <a href="/Function/Admin/fzlist.php">
                      <span>分站列表</span>
                    </a>
                  </li>
				  <li>
                    <a href="/Function/Admin/addfz.php">
                      <span>添加分站</span>
                    </a>
                  </li>
                </ul>
              </li>
			  <?php } ?>
			  <li <?php if(C('pageid')=='adminuser' or C('pageid')=='adminqq'){ echo'class="active"';}?>>
                <a class="auto" > 
				<span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="fa fa-user"></i>
                  <span>用户管理</span>
                </a>
				<ul class="nav nav-sub dk">
                      
					<li>
                    <a href="/Function/Admin/ulist.php">
                      <span>用户列表</span>
                    </a>
                  </li>
				  <li>
                    <a href="/Function/Admin/qlist.php">
                      <span>QQ列表</span>
                    </a>
                  </li>
                </ul>
              </li>
				  
              <li <?php if(C('pageid')=='daigua'){ echo'class="active"';}?>>
			  <a class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="icon-note"></i>
                  <span>模板中心</span>
                </a>
                <ul class="nav nav-sub dk">
				<?php if($isdomain){}else{?>
                        <li>
                           <a href="/Function/Admin/shop.php" title="模板商城">
                              模板商城
                           </a>
                        </li>
						<?php } ?>
                </ul>
              </li>
              <li <?php if(C('pageid')=='qd' or C('pageid')=='reginfo' or C('pageid')=='mzlist' or C('pageid')=='auth' or C('pageid')=='qiuqiu'){ echo'class="active"';}?>>
                <a class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
				  <b class="badge bg-danger pull-right">New</b>
				  
                  <i class="glyphicon glyphicon-briefcase icon"></i>
                  <span translate="aside.nav.components.ui_kits.UI_KITS">更多工具</span>
                </a>
                <ul class="nav nav-sub dk">
				<li>
                    <a href="/Function/Admin/update.php">
                      <span>检测更新</span>
                    </a>
                  </li>
                </ul>
              </li>
             
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">          
                <span translate="aside.nav.your_stuff.YOUR_STUFF">帮助</span>
              </li>
<li>
<a href="#" target="blank">
<i class="icon-envelope-letter" aria-hidden="true"></i>
<span>建议反馈</span>
</a>
</li>			  
              <li>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?= C('webqq') ?>&site=qq&menu=yes">
                  <i class="icon-user icon text-success-lter"></i>
                  <span>在线咨询</span>
                </a>
              </li>
			  <li>
<a href="/Function/Index/help.php">
<i class="glyphicon glyphicon-file icon"></i>
<span>帮助中心</span>
</a>
</li>

            </ul>
          </nav>
          <!-- nav -->

          <!-- aside footer -->
          <div class="wrapper m-t">
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded"><?php echo get_count('users', '1=:1', 'uid', array(':1' => '1'))?></span>
              <span class="hidden-folded" translate="aside.MILESTONE">平台用户</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-info" style="width: 60%;">
              </div>
            </div>
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded"><?php echo get_count('qqs', '1=:1', 'uid', array(':1' => '1'))?></span>
              <span class="hidden-folded" translate="aside.RELEASE">QQ数量</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-primary" style="width: 35%;">
              </div>
            </div>
          </div>
          <!-- / aside footer -->
        </div>
      </div>
    </div>
    <!-- / menu -->
