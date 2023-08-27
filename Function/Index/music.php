<?php
require_once('common.php');
C('webtitle','音乐查询');
include_once 'core.head.php';
$qq=$_POST['qq'];
?>
    <div class="col-md-12">
      <div class="panel panel-primary">
          <div class="panel-heading w h">
              <h3 class="panel-title" align="center">QQ空间背景音乐查询</h3>
          </div>
          <div class="panel-body" align="left">
        <form action="?" class="form-horizontal" method="post">
			<input type="hidden" name="do" value="1">
			<div class="list-group-item">
            <div class="input-group">
              <div class="input-group-addon">Q Q</div>
              <input type="text" class="form-control" name="qq" value="<?php echo $qq;?>" required autofocus>
            </div>
          </div>
		  <div class="list-group-item">
            <input type="submit" name="submit" value="立即查询" class="btn btn-primary btn-block">
          </div>
								<div class="form-group">
									<?php
									
									if($_POST['do']=='1'){
	 $qqurl='http://qzone-music.qq.com/fcg-bin/cgi_playlist_xml.fcg?json=1&uin='.$qq.'&g_tk=5381';
	 $url = get_curl($qqurl);
 $url = mb_convert_encoding($url, "UTF-8", "GB2312");
							  preg_match_all('@xsong_name\:\"(.*)\"@Ui',$url,$arr);
							  preg_match_all('@xqusic_id:(.*),xctype:(.*),xexpire_time@Ui',$url,$xqusic);
							  preg_match_all('@xsong_url\:\'(.*)\'@Ui',$url,$arrurl);
							  preg_match_all('@xsinger_name\:\"(.*)\"@Ui',$url,$singger);
							  $n = count($arr[1]);?>
							  <br><div class="panel-body" align="center">
  <div class="panel-collapse collapse in">
    <div class="panel-body">
      <section id="dropdowns">
                <table class="table">
          <thead>
            <tr>
              <td class="mzwidthtd" align="center">歌曲名字</td>
              <td class="mzwidthtd" align="center">下载链接</td>
              
            </tr>
          </thead>
<?php
for($i=0;$i<$n;$i++){
echo '<thead>
            <tr>
              <td align="center" valign="middle">'.$arr[1][$i] .'-'. $singger[1][$i].'</td>'.'<td align="center" valign="middle"><a href="http://ws.stream.qqmusic.qq.com/'.$xqusic[1][$i].'.m4a?fromtag=6">下载</a></td>
			</tr>
			</thead>';
}
?>
</table>
		</div>
	</div>
	</div>
<?php
}
?>
	</div>
								</div>
							</form>
      </div></div>

<?php
include_once 'core.foot.php';
?>