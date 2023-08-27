<?php
require_once 'common.php';
C('pageid', 'web');
C('webtitle', '自助分站');
include_once 'core.head.php';
if($isdomain)exit("<script language='javascript'>alert('无法使用');window.location.href='/Function/Index/';</script>");
if(!C('webmoney'))exit("<script language='javascript'>alert('站长未设置分站开通金额');window.location.href='/Function/Index/';</script>");
if($_POST['is'] == 'ok'){
    if(!$_POST['weburl'] || !$_POST['webname'] || !$_POST['webqq'])exit("<script language='javascript'>alert('任何一项不能为空');window.location.href='web.php';</script>");
    $d_name = $_POST['webname'];
    $d_url = $_POST['weburl'];
    $d_qq = $_POST['webqq'];
    if($userrow['rmb'] < C('webmoney'))exit("<script language='javascript'>alert('账户余额不足');window.location.href='web.php';</script>");
    if($d_url == $_SERVER['HTTP_HOST'])exit("<script language='javascript'>alert('分站域名不能与主站相同');window.location.href='web.php';</script>");
    $endtime = date('Y-m-d', strtotime('+1 month'));
    $prefixs = get_sz(3);
    if(get_results('select * from bqyj_separate where urls=:url limit 1', array(':url' => $d_url)))exit("<script language='javascript'>alert('该站已存在');window.location.href='web.php';</script>");
    if($db -> query("update bqyj_users set rmb='" . ($userrow['rmb'] - C('webmoney')) . "' where uid='" . $userrow['uid'] . "'")){
        $sqls = file_get_contents('../../Install/separate.sql');
        $sqls = str_replace('bqyj_', $prefixs . '_', $sqls);
        $sqls = str_replace('冰清玉洁', $d_name, $sqls);
        $sqls = str_replace('2302701417', $d_qq, $sqls);
        $sqls = str_replace('', $d_url, $sqls);
        $explode = explode(';', $sqls);
        $num = count($explode);
        foreach($explode as $sql){
            if($sql = trim($sql)){
                $db -> query($sql);
            }
        }
        $now = date('Y-m-d');
        if($db -> query("insert into bqyj_separate (name,urls,adminname,adminpwd,kfqq,zt,prefix,addtime,endtime) values('$d_name','$d_url','HT-admin','HT-admin','$d_qq',1,'$prefixs','$now','$endtime')")){
            exit("<script language='javascript'>alert('添加分站[$d_name]成功，点击确定进行跳转');window.location.href='http://" . $d_url . "/';</script>");
        }else{
            exit("<script language='javascript'>alert('添加分站失败');window.location.href='web.php';</script>");
        }
    }else{
        exit("<script language='javascript'>alert('扣取用户余额失败');window.location.href='web.php';</script>");
    }
}
?>
	<div id="content" class="app-content" role="includes">
	<div id="Loading" style="display:none">
		<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
	</div>
<div class="app-content-body">	<section id="container">
<div class="bg-light lter b-b wrapper-md hidden-print">
<h1 class="m-n font-thin h3">自助开通分站</h1>
</div><div class="wrapper-md ng-scope">    <div class="wrapper-md control">
<div class="row row-sm">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-info text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">分站是什么？有什么用处？</h3>
                    <small>分站是一个独立的站点，有整个网站的控制权利，打造属于自己的秒赞网 站长可管理自己的用户。</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-primary text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">搭建分站需要什么条件？</h3>
                    <small>秒赞的分站系统和服务器均由我们来提供，包域名与空间，无需任何条件，即可一键配置，即买即用。</small>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-danger text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">分站搭建好后做些什么？</h3>
                    <small>你只需要发展你的用户，专心卖和做好售后服务就可以了，其它事情无需操心。</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-success text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">分站和主站有什么区别？</h3>
                    <small>分站和主站的各个功能都是一样的，除了可以后台管理进行更新外，还有无限搭建分站的功能外，没有区别。</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-green text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">主站升级分站会跟着升级吗</h3>
                    <small>会的，主站升级后，分站是会自动升级的，所以分站站长无需再升级，升级系统一键完成，无需站长的操心</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel widget">
                <div class="panel-body bg-purple text-center">
                    <h3 class="font-bold no-margins" style=" padding-bottom:12px;">我们的分站有哪些优势？</h3>
                    <small>分站拥有全网络独家的搭建下级分站功能，而且可以无限生成卡密，网站的收入完全100%到您的账户，主站不收任何提成。</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center">同意条款</h3>
                </div>
                <div class="panel-body" align="left">
                    <p>1、首次搭建分站，分站管理员账号和管理员密码默认为admin、admin</p>
                    <p>2、我的账户余额为：<?php echo $userrow['rmb']?>元 开通一个分站需要<?php echo C('webmoney')?>元</p>
                    <p>3、搭建分站后不能以任何条件理由退款</p>
                    <p>4、有任何异议请联系主站站长QQ，分站搭建后不能再搭建分站</p>
                    <p>5、绑定域名，在添加绑定之前请先解析域名：CNAME记录到<?php echo $_SERVER['HTTP_HOST']?></p>
                    <strong>搭建分站即代表同意本站协议并自愿使用，不同意以上内容请关闭本网站。</strong>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="left">自助开通分站</h3>
                </div>
                <div class="panel-body" align="left">
                    <form action="?type=add" role="form" class="form-horizontal" method="post">
                        <input type="hidden" name="is" value="ok">
                        <div class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-addon">绑定域名</div>
                                <input type="text" class="form-control" name="weburl">
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-addon">网站名称</div>
                                <input type="text" class="form-control" name="webname">
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-addon">站长QQ</div>
                                <input type="text" class="form-control" name="webqq">
                            </div>
                        </div>
                        <div class="list-group-item">
                            <input type="submit" name="submit" value="开通分站" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include_once 'core.foot.php';
?>