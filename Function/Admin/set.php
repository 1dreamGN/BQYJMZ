<?php
require_once ('common.php');
if ($do = $_POST['do']) {
	foreach ($_POST as $k => $value) {
		if (safestr($k) == 'web_separate_gg' && $isdomain) {
			exit("<script language='javascript'>alert('保存失败！您不能修改分站公告');window.location.href='set.php';</script>");
		}
		$db->query("insert into {$prefix}webconfigs set vkey='" . safestr($k) . "',value='" . safestr($value) . "' on duplicate key update value='" . safestr($value) . "'");
	}
	if ($rows = $db->query('select * from ' . $prefix . 'webconfigs')) {
		while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			$webconfig[$row['vkey']] = $row['value'];
		}
		C($webconfig);
	}
	
	echo "<script language='javascript'>alert('保存成功！');window.location.href='set.php';</script>";
}
C('webtitle', '系统设置');
C('pageid', 'set');
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
<div class="row row-sm">
            <div class="col-sm-12">
                <div class="panel panel-default">
			<div class="panel-heading">
                    基本设置
			</div>
			<div class="panel-body">
							<form action="?xz=set" class="form-horizontal tasi-form" method="post">
								<input type="hidden" name="do" value="set">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">网站名称</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webname" value="<?=C('webname')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">网站介绍</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webkey" value="<?=C('webkey')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">网站域名</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webdomain" value="<?php
										if(!C('webdomain')){
										echo $_SERVER['HTTP_HOST'];
										}
										?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">站长QQ</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webqq" value="<?=C('webqq')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">自助分站开通金额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webmoney" value="<?=C('webmoney')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">注册赠送余额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="regrmb" value="<?=C('regrmb')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">用户交流群</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="webgroup" value="<?=C('webgroup')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">注册默认配额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="regpeie" value="<?=C('regpeie')?>">
									</div>
								</div>
																<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页网易云音乐设置</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="163_music" value="<?=C('163_music')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页图片外链地址1：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_pic_1" value="<?=C('index_pic_1')?>">
									</div>
								</div>
									<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页图片外链地址2：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_pic_2" value="<?=C('index_pic_2')?>">
									</div>
								</div>
									<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页图片外链地址3：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_pic_3" value="<?=C('index_pic_3')?>">
									</div>
								</div>
									<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页图片外链地址4：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_pic_4" value="<?=C('index_pic_4')?>">
									</div>
								</div>
									<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">用户中心图片地址：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_pic_yhzx" value="<?=C('index_pic_yhzx')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">首页LOGO图片</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="index_logo" value="<?=C('index_logo')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">监控识别码</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="cronrand" value="<?=C('cronrand')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">绚丽彩虹播放器XlchKey</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="XlchKey" value="<?=C('XlchKey')?>">
									</div>
								</div>
								<?php
								if(C("dgapi")==0){
								?>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">代挂api地址</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="dgzdy" value="<?=C('dgzdy')?>">
									</div>
								</div>
								<?php
								}
								?>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">商城发卡地址</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="kmurl" value="<?=C('kmurl')?>">
									</div>
								</div>
							<div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                    <button class="btn btn-white" type="submit">取消</button>
                                </div>
                            </div>
							</form>
						</div>
					</div>
			</div>
				<div class="col-lg-12">
                      <div class="panel panel-default">
			<div class="panel-heading">
                    公告发布编辑
			</div>
			<div class="panel-body">
							<form action="?xz=gg" class="form-horizontal tasi-form" method="post">
								<input type="hidden" name="do" value="gg">
								<?php if($isdomain){}else{?>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">分站用户中心公告</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="web_separate_gg" rows="5"><?=stripslashes(C('web_separate_gg'))?></textarea>
									</div>
								</div>
								<?php } ?>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">用户中心公告</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="web_control_gg" rows="5"><?=stripslashes(C('web_control_gg'))?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">购买页说明</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="web_shop_gg" rows="5"><?=stripslashes(C('web_shop_gg'))?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">充值页公告(用于展示购买卡密地址)</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="web_rmb_gg" rows="5"><?=stripslashes(C('web_rmb_gg'))?></textarea>
									</div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-10">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                </div>
								</div>
							</form>
						</div>
					</div></div>
					<div class="col-lg-12">
                      <div class="panel panel-default">
			<div class="panel-heading">
                    广告设定
			</div>
			<div class="panel-body">
							<form action="?xz=wb" class="form-horizontal tasi-form" method="post">
								<input type="hidden" name="do" value="wb">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">免费用户说说尾巴广告</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="shuogg" rows="5"><?=stripslashes(C('shuogg'))?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">每日签到广告内容</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="qdgg" rows="5"><?=stripslashes(C('qdgg'))?></textarea>
									</div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-10">
                                    <button class="btn btn-primary" type="submit">保存内容</button>
                                </div>
								</div>
							</form>
						</div>
					</div></div>
			<div class="col-lg-12">
                      <div class="panel panel-default">
			<div class="panel-heading">
                    用户购卡设定
			</div>
			<div class="panel-body">
							<form action="?xz=price" class="form-horizontal" method="post">
								<input type="hidden" name="do" value="pricet">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">1天VIP</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_1dvip" value="<?=C('price_1dvip')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">1月VIP</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_1vip" value="<?=C('price_1vip')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">3月VIP</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_3vip" value="<?=C('price_3vip')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">6月VIP</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_6vip" value="<?=C('price_6vip')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">12月VIP</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_12vip" value="<?=C('price_12vip')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">1个配额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_1peie" value="<?=C('price_1peie')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">3个配额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_3peie" value="<?=C('price_3peie')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">5个配额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_5peie" value="<?=C('price_5peie')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">10个配额</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="price_10peie" value="<?=C('price_10peie')?>">
									</div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-10">
                                    <button class="btn btn-primary" type="submit">保存设置</button>
                                </div>
								</div>
							</form>
						</div>
					</div></div>
					
				
				<div class="col-lg-12">
                      <div class="panel panel-default">
			<div class="panel-heading">
                    圈圈99+接口设置
			</div>
			<div class="panel-body">
							<form action="?xz=quanquan" class="form-horizontal" method="post">
								<input type="hidden" name="do" value="quanquan">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">圈圈接口：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="web_quanquanjk" value="<?=C('web_quanquanjk')?>">
									</div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-10">
                                    <button class="btn btn-primary" type="submit">保存设置</button>
                                </div>
								</div>
							</form>
						</div></div>
				</div>
				<div class="col-lg-12">
                      <div class="panel panel-default">
			<div class="panel-heading">
                    聊天室设置[Hot]
			</div>
			<div class="panel-body">
							<form action="?xz=chat" class="form-horizontal" method="post">
								<input type="hidden" name="do" value="chat">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">畅言APPID：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="changyan_appid" value="<?=C('changyan_appid')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">畅言CONF：</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="changyan_conf" value="<?=C('changyan_conf')?>">
									</div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-2">
                                    <p>APPID和CONF不设置则该功能不开启</p>
                                </div>
								</div>
								<div class="form-group">
								<div class="col-sm-12 col-sm-offset-10">
                                    <button class="btn btn-primary" type="submit">保存设置</button>
                                </div>
								</div>
							</form>
						</div></div>
				</div>
			  <div class="col-lg-12">
				  <div class="panel panel-default">
					  <div class="panel-heading">
						  自动更新失败发送邮件设置[Old]
					  </div>
					  <div class="panel-body">
						  <form action="?xz=email" class="form-horizontal" method="post">
							  <input type="hidden" name="do" value="email">
							  <div class="form-group">
								  <label class="col-lg-2 control-label" for="field-2">SMTP服务器：</label>
								  <div class="col-sm-9">
									  <input class="form-control" type="text" name="email_host" value="<?=C('email_host')?>">
								  </div>
							  </div>
							  <div class="form-group">
								  <label class="col-lg-2 control-label" for="field-2">发信端口：</label>
								  <div class="col-sm-9">
									  <input class="form-control" type="text" name="email_port" value="<?=C('email_port')?>">
								  </div>
							  </div>
							  <div class="form-group">
								  <label class="col-lg-2 control-label" for="field-2">邮箱账号：</label>
								  <div class="col-sm-9">
									  <input class="form-control" type="text" name="email_user" value="<?=C('email_user')?>">
								  </div>
							  </div>
							  <div class="form-group">
								  <label class="col-lg-2 control-label" for="field-2">邮箱密码：</label>
								  <div class="col-sm-9">
									  <input class="form-control" type="text" name="email_pwd" value="<?=C('email_pwd')?>">
								  </div>
							  </div>
							  <div class="form-group">
								  <div class="col-sm-12 col-sm-offset-2">
									  <p>全部为空则该功能不开启</p>
								  </div>
							  </div>
							  <div class="form-group">
								  <div class="col-sm-12 col-sm-offset-10">
									  <button class="btn btn-primary" type="submit">保存设置</button>
								  </div>
							  </div>
						  </form>
					  </div></div>
			  </div>
			  <div class="col-lg-12">
				  <div class="panel panel-default">
					  <div class="panel-heading">
						  功能服务器设置
					  </div>
					  <div class="panel-body">
						  <form action="?xz=net" class="form-horizontal" method="post">
							  <input type="hidden" name="do" value="net">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">每个服务器最多QQ数</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="netnum" value="<?=C('netnum')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">秒赞服务器数量</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="zannet" value="<?=C('zannet')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">说说服务器数量</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="shuonet" value="<?=C('shuonet')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">秒评服务器数量</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="replynet" value="<?=C('replynet')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">转发服务器数量</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="zfnet" value="<?=C('zfnet')?>">
									</div>
								</div>
							  <div class="form-group">
								  <div class="col-sm-12 col-sm-offset-10">
									  <button class="btn btn-primary" type="submit">保存设置</button>
								  </div>
							  </div>
						  </form>
					  </div></div>
			  </div>
			  <div class="col-lg-12">
				  <div class="panel panel-default">
					  <div class="panel-heading">
						  自动更新打码平台对接设置[New]
					  </div>
					  <div class="panel-body">
						  <form action="?xz=net" class="form-horizontal" method="post">
							  <input type="hidden" name="do" value="net">
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">超人打码账号</label>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="chaoren_user" value="<?=C('chaoren_user')?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label" for="field-2">超人打码密码</label>
									<div class="col-sm-9">
										<input class="form-control" type="password" name="chaoren_pwd" value="<?=C('chaoren_pwd')?>">
									</div>
								</div>
								<div class="form-group">
								  <div class="col-sm-12 col-sm-offset-2">
									  <p>全部为空则该功能不开启，超人打码官网 <a href="http://www.chaorendama.com/">http://www.chaorendama.com/</a></p>
								  </div>
							  </div>
							  <div class="form-group">
								  <div class="col-sm-12 col-sm-offset-10">
									  <button class="btn btn-primary" type="submit">保存设置</button>
								  </div>
							  </div>
						  </form>
					  </div></div>
			  </div>
</div>
	  <?php
include_once 'common.foot.php';
?>