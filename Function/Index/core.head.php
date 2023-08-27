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
  <link rel="stylesheet" type="text/css" href="../../Template/admin/sweetalert.css">
  <script src="../../Template/admin/sweetalert.min.js"></script>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <?php require_once ('FM.php'); //载入播放器?>
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
          <img src="../../Template/static/img/logo.png" alt="." class="hide">
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
		  <a href="uindex.php?uid=<?=$userrow['uid']?>" class="btn no-shadow navbar-btn" ui-toggle="show" target="#aside-user">
            <i class="icon-user fa-fw"></i>
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
                          <a href="/Function/Deputy/kmlist.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>副站后台</a>
                        </li>
                        <li>
                          <a href="/Function/Index/index.php"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>用户中心</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 b-l b-light">
                  <div class="m-l-xs m-t-xs m-b-xs font-bold">我的QQ <span class="label label-sm bg-primary"><?=get_count('qqs',"uid=:uid",'qid',array(':uid'=>$userrow['uid']))?></span></div>
                  <div class="row">
                    <div class="col-xs-6">
                      <ul class="list-unstyled l-h-2x">
					  <?php  $qqs = $db -> query("select * from {$prefix}qqs where uid=" . $userrow['uid'] . " order by qid desc"); 
							while($qq = $qqs -> fetch(PDO :: FETCH_ASSOC)){
					  ?>
					  <li>
                          <a href="/Function/Index/qqlist.php?qid=<?=$qq['qid']?>"><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i><?=$qq['qq']?></a>
                        </li>
					  
					<?php }?>
					  </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <!-- / link and dropdown -->
<!-- search form -->
        <form class="navbar-form navbar-form-sm navbar-left shift" action="mzrz.php" role="search">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="qq" class="form-control input-sm bg-light no-border rounded padder" placeholder="搜索秒赞认证...">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-sm bg-light rounded">Submit</button>
              </span>
            </div>
          </div>
        </form>
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
                <a href="/Function/Index/uset.php">
                  <span class="badge bg-danger pull-right">30%</span>
                  <span>账户设置</span>
                </a>
              </li>
              <li>
                <a href="/Function/Index/help.php">
                  <span class="label bg-info pull-right">new</span>
                  帮助中心
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
                  <span class="text-muted text-xs block"><?php if(get_isvip($userrow['vip'],$userrow['vipend'])){ echo "包月VIP";}else{echo"免费用户";}?> </span>
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
                <a href="/Function/Index/uset.php">
                  <span class="badge bg-danger pull-right">30%</span>
                  <span>账户设置</span>
                </a>
              </li>
              <li>
                <a href="/Function/Index/help.php">
                  <span class="label bg-info pull-right">new</span>
                  帮助中心
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
              <li <?php if(C('pageid')=='user'){ echo'class="active"';}?>>    
				  <a href="/Function/Index/index.php">
                  <i class="glyphicon glyphicon-home icon text-primary-dker"></i>
				  <b class="label bg-info pull-right">N</b>
                  <span class="font-bold">用户中心</span>
                </a>
              </li>
			  <li <?php if(C('pageid')=='link'){ echo'class="active"';}?>>    
				  <a href="/Function/Index/link.php">
                  <i class="glyphicon glyphicon-link icon text-primary-dker"></i>
                  <span class="font-bold">友情链接</span>
                </a>
              </li>
			  <li <?php if(C('pageid')=='shop' or C('pageid')=='rmb'){ echo'class="active"';}?>>
                <a class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-credit-card icon text-info-lter"></i>
                  <span class="font-bold">自助商城</span>
                </a>
                <ul class="nav nav-sub dk">
                <li <?php if(C('pageid')=='shop'){ echo'class="active"';}?>><a href="/Function/Index/shop.php">自助开通</a></li>
				<li <?php if(C('pageid')=='rmb'){ echo'class="active"';}?>><a href="/Function/Index/rmb.php">余额充值</a></li>
                </ul>
              </li>
              <li <?php if(C('pageid')=='uset' or C('pageid')=='uindex'){ echo'class="active"';}?>>
                <a class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="icon-user-follow"></i>
                  <span class="font-bold">用户资料</span>
                </a>
                <ul class="nav nav-sub dk">
                <li <?php if(C('pageid')=='uset'){ echo'class="active"';}?>><a href="/Function/Index/uset.php">资料修改</a></li>
				<li <?php if(C('pageid')=='uindex'){ echo'class="active"';}?>><a href="/Function/Index/uindex.php?uid=<?=$userrow['uid']?>">我的主页</a></li>
                </ul>
              </li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>服务</span>
              </li>
              <li <?php if(C('pageid')=='qq' or C('pageid')=='add' or C('pageids')=='qid' or C('pageid')=='qqset'){ echo'class="active"';}?>>
			  <a class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
				  <div class="pull-right label label-success"><?=get_count('qqs',"uid=:uid",'qid',array(':uid'=>$userrow['uid']))?></div>
                  <i class="fa fa-qq" aria-hidden="true"></i>
                  <span>挂机管理</span>
                </a>
                <ul class="nav nav-sub dk">
                      
					<li>
                    <a href="/Function/Index/add.php">
                      <span>添加挂机</span>
                    </a>
                  </li>
				  <li>
                    <a href="/Function/Index/qq.php">
                      <span>挂机管理</span>
                    </a>
                  </li>
                </ul>
              </li>

			  <li <?php if(C('pageid')=='chat'){ echo'class="active"';}?>>
                <a class="auto" href="/Function/Index/chat.php">      
                  <i class="icon-bubbles"></i>
                  <span>聊天交流</span>
                </a>
              </li>
			
              <li <?php if(C('pageid')=='daigua'){ echo'class="active"';}?>>
			  <a class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="icon-rocket"></i>
                  <span>代挂系统</span>
                </a>
                <ul class="nav nav-sub dk">
				<?php if(C("dgapi")==1){?>
                  <li>
                    <a href="/Function/Index/daigua.php?se=add">
                      <span>添加代挂</span>
					  
                    </a>
                  </li>
                  <li>
                    <a href="/Function/Index/daigua.php">
                      <span>代挂列表</span>
					  
                    </a>
                  </li>
				<?php }else{
					$rowss1 = $db->query("select * from {$prefix}qqs where uid=".$userrow['uid']." order by qid desc");
					while($row = $rowss1->fetch(PDO::FETCH_ASSOC)){?>
					<li <?php if(C('pageids')=='dgqid'.$row['qid']){ echo'class="active"';}?>>
                    <a href="/Function/Index/qqdg.php?qid=<?=$row['qid']?>" title="QQ<?=$row[qq]?>">
                      <span># <?=$row[qq]?> 设置/添加</span>
					  
                    </a>
                  </li>
					
				<?php }}?>
                </ul>
              </li>
			  <?php if($userrow['fuzhan']){?> 
			  <li <?php if(C('pageid')=='fzkmlist' or C('pageid')=='/Function/Deputy/qq' or C('pageid')=='/Function/Deputy/user' or C('pageid')=='/Function/Deputy/userset'){ echo'class="active"';}?>>
			  <a class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="icon-social-dropbox"></i>
                  <span>副站后台</span>
                </a>
                <ul class="nav nav-sub dk">

							<li <?php if(C('pageid')=='fzkmlist'){ echo'class="active"';}?>><a  href="/Function/Deputy/kmlist.php"><span>卡密生成</span></a>
                            </li>
                            <li <?php if(C('pageid')=='/Function/Deputy/user'){ echo'class="active"';}?>><a href="/Function/Deputy/ulist.php"><span>用户管理</span></a>
                            </li>
                            <li <?php if(C('pageid')=='/Function/Deputy/qq'){ echo'class="active"';}?>><a  href="/Function/Deputy/qlist.php"><span>挂机列表</span></a>
                            </li>
                </ul>
              </li>
				<?php }?>
              <li <?php if(C('pageid')=='qd' or C('pageid')=='reginfo' or C('pageid')=='mzlist' or C('pageid')=='auth' or C('pageid')=='qiuqiu'){ echo'class="active"';}?>>
                <a class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
				  <b class="badge bg-danger pull-right">New</b>
				  
                  <i class="icon-game-controller"></i>
                  <span translate="aside.nav.components.ui_kits.UI_KITS">更多工具</span>
                </a>
                <ul class="nav nav-sub dk">
				  <li <?php if(C('pageid')=='qd'){ echo'class="active"';}?>>
                    <a href="/Function/Index/qd.php">
                      <span>每日签到</span>
					  
                    </a>
                  </li>
				  <?php if(C("freevip")){ ?>
				  <li <?php if(C('pageid')=='freevip'){ echo'class="active"';}?>>
                    <a href="/Function/Index/freevip.php">
                      <span>免费会员</span>
					  
                    </a>
                  </li>
				  <?php }?>
				  <li <?php if(C('pageid')=='reginfo'){ echo'class="active"';}?>>
                    <a href="/Function/Index/reginfo.php">
                      <span>邀请好友</span>
					  
                    </a>
                  </li>
				  <li <?php if(C('pageid')=='mzlist'){ echo'class="active"';}?>>
                    <a href="/Function/Index/mzlist.php">
                      <span>QQ秒赞墙</span>
					  
                    </a>
                  </li>
				  <?php if($isdomain){}else{?>
				  <li <?php if(C('pageid')=='web'){ echo'class="active"';}?>>
                    <a href="/Function/Index/web.php">
                      <span>搭建分站</span>
					  
                    </a>
                  </li>
				  <?php }?>
				  <li <?php if(C('pageid')=='qiuqiu'){ echo'class="active"';}?>>
                    <a href="/Function/Index/qiuqiu.php">
                      <span>球球代点</span>
					  
                    </a>
                  </li>
				  <li <?php if(C('pageid')=='pysms'){ echo'class="active"';}?>>
                    <a href="/Function/Index/qqmusic.php">
                      <span>音乐加速</span>
					  
                    </a>
                  </li>
				   <li <?php if(C('pageid')=='pysms'){ echo'class="active"';}?>>
                    <a href="/Function/Index/pysms.php">
                      <span>短信轰炸</span>
					  
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
                  <i class="icon-earphones-alt"></i>
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
