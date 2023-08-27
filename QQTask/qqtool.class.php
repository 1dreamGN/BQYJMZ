<?php
/* Author：消失的彩虹海 & 快乐是福 & 云上的影子 && 顾念 */
class qzone {
    public $msg;
	public $error;
	public $delend;
	private $qzonetoken = null;
    public function __construct($uin, $sid = null, $skey = null, $p_skey = null, $pookie = null) {
        $this->uin = $uin;
        $this->sid = $sid;
        $this->skey = $skey;
        $this->p_skey = $p_skey;
        $this->pookie_new = $pookie;
        $this->gtk = $this->getGTK($skey);
        $this->gtk1 = $this->getGTK($p_skey);
        $this->gtk2 = $this->getGTK2($skey);
        $this->cookie = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . '; p_skey=' . $p_skey . ';';
        $this->cookie1 = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . ';';
    }
    public function tx() {
        $url = 'http://face.qq.com/client/webface.php';
        $id = rand(6319, 16097);
        $post = 'item_id=' . $id . '&size=1&cmd=set_static_face&g_tk=' . $this->gtk2 . '&callback=callback';
        $data = $this->get_curl($url, $post, $url, $this->cookie);
        preg_match('/callback\((.*?)\);/is', $data, $json);
        $arr = json_decode($json[1], true);
        if (@array_key_exists('result', $arr) && $arr['result'] == 0) {
            $this->msg[] = '更换头像成功！';
        } elseif ($arr['result'] == 1001) {
            $this->skeyzt = 1;
            $this->msg[] = '更换头像失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '更换头像失败！' . $data;
        }
    }
    public function pf() {
        $url = 'http://redirect.zb.qq.com/cgi-bin/setdec.fcg?g_tk=' . $this->gtk2;
        $dec0 = rand(688, 25000);
        $post = 'dec0=' . $dec0 . '&dec1=0&dec2=0&count=3&cmd=1&from=vip.gongneng.subsite.zhuangban.guide_setup_log&callback=callback';
        $data = $this->get_curl($url, $post, $url, $this->cookie);
        preg_match('/callback\((.*?)\);/is', $data, $json);
        $arr = json_decode($json[1], true);
        if (@array_key_exists('rc', $arr) && $arr['rc'] == 'setsucc') {
            $this->msg[] = '更换皮肤成功！' . $dec0;
        } elseif ($arr['rc'] == "try_login") {
            $this->skeyzt = 1;
            $this->msg[] = '更换头像失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '更换头像失败！' . $data;
        }
    }
    public function qipao() {
        $str = '87&96&107&110&114&16&21&28&36&40&42&45&47&49&56&72&81&82&85&180&201&209&16&21&28&36&40&42&45&47&49&56&72&81&82&85&180&201&209&0&1&2&3&4&5&6&7&8&9&11&12&14&16&19&21&24&25&26&28&29&35&36&38&39&40&42&43&44&45&48&49&52&55&56&58&59&61&63&67&68&69&71&72&73&74&75&76&78&80&81&82&83&85&86&87&89&90&91&92&94&95&96&98&101&105&106&107&109&110&111&112&113&114&117&118&120&122&124&125&126&127&128&129&132&133&138&142&146&150&151&152&155&159&168&169&178';
        $id = array_rand(explode('&', $str) , 1);
        $url = "http://logic.content.qq.com/bubble/setup?callback=&uin=" . $this->uin . "&id=" . $id . "&version=4.6.0.0&platformId=1&g_tk=" . $this->gtk . "&_=" . time() . "989";
        $get = $this->get_curl($url, 0, 0, $this->cookie);
        preg_match('/\((.*?)\)\;/is', $get, $json);
        if ($json = $json[1]) {
            $arr = json_decode($json, true);
            if (array_key_exists('ret', $arr) && $arr['ret'] == 0) {
                if ($arr['data']['ret'] == 0 && $arr['data']['msg'] == "ok") {
                    $this->msg[] = "气泡更换成功";
                } elseif ($arr['data']['ret'] == 5002) {
                    $this->msg[] = "需参与活动";
                } elseif ($arr['data']['ret'] == 2002) {
                    $this->msg[] = "非会员";
                }
            } elseif ($arr['ret'] == - 100001) {
                $this->skeyzt = 1;
                $this->msg[] = "SKEY过期";
            } else {
                $this->msg[] = "气泡更换失败！" . $arr['msg'];
            }
        }
    }
		public function cpshuo($content,$richval='',$sname='',$lon='',$lat=''){
		$url='http://mobile.qzone.qq.com/mood/publish_mood?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$post='opr_type=publish_shuoshuo&res_uin='.$this->uin.'&content='.urlencode($content).'&richval='.$richval.'&lat='.$lat.'&lon='.$lon.'&lbsid=&issyncweibo=0&is_winphone=2&format=json&source_name='.$sname;
		$result=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($result,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 发布说说成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:SID已失效，请更新SID';
		}elseif(@array_key_exists('code',$json)){
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:'.$result;
		}
	}
	public function pcshuo($content,$richval=0){
		$url='http://taotao.qq.com/cgi-bin/emotion_cgi_publish_v6?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
		$post='syn_tweet_verson=1&paramstr=1&pic_template=';
		if($richval){
			$post.="&richtype=1&richval=".$this->uin.",{$richval}&special_url=&subrichtype=1&pic_bo=uAE6AQAAAAABAKU!%09uAE6AQAAAAABAKU!";
		}else{
			$post.="&richtype=&richval=&special_url=";
		}
		$post.="&subrichtype=&con=".urlencode($content)."&feedversion=1&ver=1&ugc_right=1&to_tweet=0&to_sign=0&hostuin=".$this->uin."&code_version=1&format=json&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F".$this->uin."%2F311";
		$ua = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";
		$json=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			$arr['feedinfo']='';
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]=$this->uin.' 发布说说成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:SID已失效，请更新SID';
			}elseif($arr['code']==-10045){
				$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:'.$arr['message'];
			}elseif(@array_key_exists('code',$arr)){
				$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]=$this->uin.' 发布说说失败[PC]！原因'.$json;
			}
		}else{
			$this->msg[]=$this->uin.' 获取发布说说结果失败[PC]';
		}
	}
	public function shuo($do=0,$content,$image=null,$sname='',$delete=false){
		if($delete){
			$url='http://sh.taotao.qq.com/cgi-bin/emotion_cgi_feedlist_v6?hostUin='.$this->uin.'&ftype=0&sort=0&pos=0&num=1&replynum=0&code_version=1&format=json&need_private_comment=1&g_tk='.$this->gtk;
			$json=$this->get_curl($url,0,0,$this->cookie);
			$arr=json_decode($json,true);
			//Print_r($arr);exit;
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$cellid=$arr['msglist'][0]['tid'];
				$this->pcdel($cellid);
			}else{
				$this->msg[]='删除上一条说说失败！原因:'.$arr['message'];
			}
		}
		if(!empty($image)){
			if($pic=$this->openu($image)){
				$image_size=getimagesize($image);
				$richval=$this->uploadimg($pic,$image_size);
			}
		}else{
			$richval=null;
		}
		if($do){
			$this->pcshuo($content,$richval);
		}else{
			$this->cpshuo($content,$richval,$sname);
		}
	}
		public function cpqd($content='签到',$sealid='50457'){
		$url='http://h5.qzone.qq.com/webapp/json/publishDiyMood/publishmood?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('http://h5s.qzone.qq.com/checkin/index');
		$post='seal_id='.$sealid.'&frames=10&uin='.$this->uin.'&content='.urlencode($content).'&isWinPhone=2&lock_days=1&richval=&richtype=0&issynctoweibo=0&extend_info.activity_report=%23signin%23'.$sealid.'&source.subtype=33&format=json';
		$json=$this->get_curl($url,$post,0,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('ret',$arr) && $arr['ret']==0){
			$this->msg[]=$this->uin.' 签到成功[CP]';
		}elseif($arr['ret']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 签到失败[CP]！原因:SID已失效，请更新SID';
		}elseif(@array_key_exists('ret',$arr)){
			$this->msg[]=$this->uin.' 签到失败[CP]！原因:'.$arr['msg'];
		}else{
			$this->msg[]=$this->uin.' 签到失败[CP]！原因:'.$json;
		}
	}
	public function pcqd($content='',$sealid='50001'){
		$url='http://snsapp.qzone.qq.com/cgi-bin/signin/checkin_cgi_publish?g_tk='.$this->gtk2;
		$post='qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fapp%2Fcheckin_v4%2Fhtml%2Fcheckin.html&plattype=1&hostuin='.$this->uin.'&seal_proxy=&ttype=1&termtype=1&content='.urlencode($content).'&seal_id='.$sealid.'&uin='.$this->uin.'&time_for_qq_tips='.time().'&paramstr=1';
		$get=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		preg_match('/callback\((.*?)\)\; <\/script>/is',$get,$json);
		if($json=$json[1]){
			$arr=json_decode($json,true);
			$arr['feedinfo']='';
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]=$this->uin.' 签到成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:SID已失效，请更新SID';
			}elseif(@array_key_exists('code',$arr)){
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:'.$json;
			}
		}else{
			$this->msg[]=$this->uin.' 获取签到结果失败[PC]';
		}
		
	}
	public function qiandao($do=0,$content='签到',$sealid=50001){
		if($do){
			$this->pcqd($content,$sealid);
		}else{
			$this->cpqd($content,$sealid);
		}
	}
	public function pcdel($cellid){
		$url='http://taotao.qq.com/cgi-bin/emotion_cgi_delete_v6?g_tk='.$this->gtk2;
		$post='hostuin='.$this->uin.'&tid='.$cellid.'&t1_source=1&code_version=1&format=json&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F'.$this->uin.'%2F311';
		$json=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]='删除说说'.$cellid.'成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:SKEY已失效';
			}elseif(@array_key_exists('code',$json)){
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:'.$json;
			}
		}else{
			$this->msg[]=$this->uin.'获取删除结果失败[PC]';
		}
	}
	public function cpdel($cellid,$appid){
		$url='http://mobile.qzone.qq.com/operation/operation_add?g_tk='.$this->gtk2;
		$post='opr_type=delugc&res_type='.$appid.'&res_id='.$cellid.'&real_del=0&res_uin='.$this->uin.'&format=json';
		$json=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='删除说说'.$cellid.'成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:SID已失效，请更新SID';
		}elseif(@array_key_exists('code',$json)){
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:'.$arr['message'];
		}else{
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:'.$json;
		}
	}
	public function shuodel($do=0){
		if($shuos=$this->getmynew()){
			//print_r($shuos);exit;
			$i=0;
			foreach($shuos as $shuo){
				$cellid=$shuo['tid'];
				$this->pcdel($cellid);
				if($this->skeyzt) break;
				++$i;if($i>=10)break;
			}
		}
	}
    public function flower() {
        $url = 'http://flower.qzone.qq.com/fcg-bin/cgi_plant?g_tk=' . $this->gtk;
        $post = 'fl=1&fupdate=1&act=rain&uin=' . $this->uin . '&newflower=1&outCharset=utf%2D8&g%5Ftk=' . $this->gtk . '&format=json';
        $json = $this->get_curl($url, $post, $url, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '浇水成功！';
        } elseif ($arr['code'] == - 6002) {
            $this->msg[] = '今天浇过水啦！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '浇水失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '浇水失败！' . $arr['message'];
        }
        $post = 'fl=1&fupdate=1&act=love&uin=' . $this->uin . '&newflower=1&outCharset=utf%2D8&g%5Ftk=' . $this->gtk . '&format=json';
        $json = $this->get_curl($url, $post, $url, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '修剪成功！';
        } elseif ($arr['code'] == - 6002) {
            $this->msg[] = '今天修剪过啦！';
        } elseif ($arr['code'] == - 6007) {
            $this->msg[] = '您的爱心值今天已达到上限！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '修剪失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '修剪失败！' . $arr['message'];
        }
        $post = 'fl=1&fupdate=1&act=sun&uin=' . $this->uin . '&newflower=1&outCharset=utf%2D8&g%5Ftk=' . $this->gtk . '&format=json';
        $json = $this->get_curl($url, $post, $url, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '光照成功！';
        } elseif ($arr['code'] == - 6002) {
            $this->msg[] = '今天日照过啦！';
        } elseif ($arr['code'] == - 6007) {
            $this->msg[] = '您的阳光值今天已达到上限！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '光照失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '光照失败！' . $arr['message'];
        }
        $post = 'fl=1&fupdate=1&act=nutri&uin=' . $this->uin . '&newflower=1&outCharset=utf%2D8&g%5Ftk=' . $this->gtk . '&format=json';
        $json = $this->get_curl($url, $post, $url, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '施肥成功！';
        } elseif ($arr['code'] == - 6005) {
            $this->msg[] = '暂不能施肥！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '施肥失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '施肥失败！' . $arr['message'];
        }
        $url = 'http://flower.qzone.qq.com/cgi-bin/cgi_pickup_oldfruit?g_tk=' . $this->gtk;
        $post = 'mode=1&g%5Ftk=' . $this->gtk . '&outCharset=utf%2D8&fupdate=1&format=json';
        $json = $this->get_curl($url, $post, $url, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '兑换神奇肥料成功！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '兑换神奇肥料失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '兑换神奇肥料失败！' . $arr['message'];
        }
        $url = 'http://flower.qzone.qq.com/cgi-bin/fg_get_giftpkg?g_tk=' . $this->gtk;
        $post = 'outCharset=utf-8&format=json';
        $json = $this->get_curl($url, $post, 'http://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf', $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            if ($arr['data']['vDailyGiftpkg'][0]['caption']) {
                $this->msg[] = $arr['data']['vDailyGiftpkg'][0]['caption'] . ':' . $arr['data']['vDailyGiftpkg'][0]['content'];
                $giftpkgid = $arr['data']['vDailyGiftpkg'][0]['id'];
                $granttime = $arr['data']['vDailyGiftpkg'][0]['granttime'];
                $url = 'http://flower.qzone.qq.com/cgi-bin/fg_use_giftpkg?g_tk=' . $this->gtk;
                $post = 'giftpkgid=' . $giftpkgid . '&outCharset=utf%2D8&granttime=' . $granttime . '&format=json';
                $this->get_curl($url, $post, 'http://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf', $this->cookie);
            } else $this->msg[] = '领取每日登录礼包成功！';
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '领取每日登录礼包失败！原因:SKEY已过期！';
        } else {
            $this->msg[] = '领取每日登录礼包失败！' . $arr['message'];
        }
    }
    public function get_curl($url, $post = 0, $referer = 1, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept:application/json";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
    private function getGTK($skey) {
        $len = strlen($skey);
        $hash = 5381;
        for ($i = 0; $i < $len; $i++) {
            $hash+= (($hash << 5) & 0xffffffff) + ord($skey[$i]);
        }
        return $hash & 0x7fffffff;
    }
    private function getGTK2($skey) {
        $salt = 5381;
        $md5key = 'tencentQQVIP123443safde&!%^%1282';
        $hash = array();
        $hash[] = ($salt << 5);
        $len = strlen($skey);
        for ($i = 0; $i < $len; $i++) {
            $ASCIICode = mb_convert_encoding($skey[$i], 'UTF-32BE', 'UTF-8');
            $ASCIICode = hexdec(bin2hex($ASCIICode));
            $hash[] = (($salt << 5) + $ASCIICode);
            $salt = $ASCIICode;
        }
        $md5str = md5(implode($hash) . $md5key);
        return $md5str;
    }
    public function dldqd() {
        $url = 'http://fight.pet.qq.com/cgi-bin/petpk?cmd=award&op=1&type=0';
        $data = $this->get_curl($url, 0, $url, $this->cookie);
        $data = mb_convert_encoding($data, "UTF-8", "GB2312");
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) {
            $this->msg[] = $arr['ContinueLogin'] . ' + ' . $arr['DailyAward'];
        } elseif ($arr['ret'] == - 1) {
            $this->msg[] = $arr['ContinueLogin'];
            $this->msg[] = $arr['DailyAward'];
        } elseif ($arr['result'] == - 5) {
            $this->skeyzt = 1;
            $this->msg[] = '大乐斗领礼包失败！SKEY已失效';
        } else {
            $this->msg[] = '大乐斗领礼包失败！' . $arr['msg'];
        }
    }

    public function pcblqd()
    {
        $url = "http://buluo.qq.com/cgi-bin/bar/card/bar_list_by_page?uin=" . $this->uin . "&neednum=30&startnum=0&r=0.98389" . time();
        $json = $this->get_curl($url, 0, 'http://buluo.qq.com/mobile/personal.html', $this->cookie);
        if ($json == '{"retcode":0,"result":{"followbarnum":0,"followbars":[],"isend":0}}') {
            $this->msg[] = $this->uin . '部落签到完成!，用户没有关注过部落';
        } else {
            $arr = json_decode($json, true);
            if ($arr['retcode'] == 100000) {
                $this->skeyzt = 1;
                $this->msg[] = '部落签到失败！SKEY已失效。';
            } else {
                $arr = $arr['result'];
                foreach ($arr['followbars'] as $followbars) {
                    $this->blqd($followbars['bid']);
                }
            }
        }
    }

    public function blqd($buluo)
    {
        $url = "http://buluo.qq.com/cgi-bin/bar/user/sign";
        $ua = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36';
        $rf = "http://buluo.qq.com/p/barindex.html?bid=" . $buluo;
        $post = "&bid=" . $buluo . "&r=" . time() . "&bkn=" . $this->gtk;
        $json = $this->get_curl($url, $post, $rf, $this->cookie1, 0, $ua);
        $arr = json_decode($json, true);
        if (array_key_exists('retcode', $arr) && $arr['retcode'] == 0) {
            if ($arr['result']['sign'] == 1)
                $this->msg[] = $this->uin . ' 部落已签到！';
            else
                $this->msg[] = $this->uin . ' 部落签到成功！';
        } elseif ($arr['retcode'] == 100000) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 部落签到失败！SKEY已失效。';
        } else {
            $this->msg[] = $this->uin . ' 部落签到失败！' . $json;
        }
    }

    public function pcqunqd($qun) {
        $url = "http://qiandao.qun.qq.com/cgi-bin/sign";
        $ua = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36 SE 2.X MetaSr 1.0';
        $rf = "http://qiandao.qun.qq.com/cgi-bin/sign";
        $post = "&gc=" . $qun . "&is_sign=0&from=1&bkn=" . $this->gtk . "";
        $json = $this->get_curl($url, $post, $rf, $this->cookie, 0, $ua);
        $arr = json_decode($json, true);
        if ($arr[ec] == 0) $this->msg[] = $this->uin . '在群号为' . $qun . '签到成功!您已累计签到' . $arr[conti_count] . '天,签到排名为' . $arr[rank] . '名,今天已有' . $arr[today_count] . '人签到!' . '<BR>';
        else $this->msg[] = $this->uin . '在群号为' . $qun . '签到失败，原因：' . $arr[em] . '<BR>';
    }
    public function qunqd() {
        $url = 'http://qun.qzone.qq.com/cgi-bin/get_group_list?groupcount=4&count=4&format=json&callbackFun=_GetGroupPortal&uin=' . $this->uin . '&g_tk=' . $this->gtk . '&ua=Mozilla%2F5.0%20(Windows%20NT%206.1%3B%20WOW64)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F31.0.1650.63%20Safari%2F537.36';
        $url2 = 'http://qiandao.qun.qq.com/cgi-bin/sign';
        $data = $this->get_curl($url, 0, 'http://qun.qzone.qq.com/group', $this->cookie);
        preg_match('/_GetGroupPortal_Callback\((.*?)\)\;/is', $data, $json);
        $arr = json_decode($json[1], true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            foreach ($arr['data']['group'] as $row) {
                $post = 'gc=' . $row['groupid'] . '&is_sign=0&from=1&bkn=' . $this->gtk;
                $data = $this->get_curl($url2, $post, 'http://qiandao.qun.qq.com/index.html?groupUin=' . $row['groupid'] . '&appID=100729587', $this->cookie);
                $arr = json_decode($data, true);
                if (array_key_exists('ec', $arr) && $arr['ec'] == 0) {
                    if (array_key_exists('name_list', $arr)) $this->msg[] = '群：' . $row['groupid'] . ' 签到成功！累计签到' . $arr['conti_count'] . '天,签到排名为' . $arr['rank'] . '名.';
                    elseif (array_key_exists('conti_count', $arr)) $this->msg[] = '群：' . $row['groupid'] . ' 今天已签到！累计签到' . $arr['conti_count'] . '天,签到排名为' . $arr['rank'] . '名.';
                    else $this->msg[] = '群：' . $row['groupid'] . '签到失败！原因：' . $data;
                } elseif ($arr['ec'] == 1) {
                    $this->skeyzt = 1;
                    $this->msg[] = '群：' . $row['groupid'] . '签到失败！原因：SKEY失效！';
                } else {
                    $this->msg[] = '群：' . $row['groupid'] . '签到失败！原因：' . $data;
                }
            }
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = '群签到失败！原因：SKEY已失效。';
        } else {
            $this->msg[] = '群签到失败！原因：' . $arr['message'];
        }
    }
    public function wyqd() {
        $data = $this->get_curl('http://web2.cgi.weiyun.com/weiyun_activity.fcg?cmd%20=17004&g_tk=' . $this->gtk . '&data=%7B%22req_header%22%3A%7B%22cmd%22%3A17004%2C%22appid%22%3A30013%2C%22version%22%3A2%2C%22major_version%22%3A2%7D%2C%22req_body%22%3A%7B%22ReqMsg_body%22%3A%7B%22weiyun.WeiyunDailySignInMsgReq_body%22%3A%7B%7D%7D%7D%7D&format=json', 0, 'http://www.weiyun.com/', $this->cookie);
        $json = json_decode($data, true);
        $arr = $json['rsp_header'];
        if (array_key_exists('retcode', $arr) && $arr['retcode'] == 0) {
            $this->msg[] = '微云签到成功！空间增加 ' . $json['rsp_body']['RspMsg_body']['weiyun.WeiyunDailySignInMsgRsp_body']['add_point'] . 'MB';
        } elseif ($arr['retcode'] == 190051) {
            $this->skeyzt = 1;
            $this->msg[] = '微云签到失败！SKEY已失效';
        } elseif (array_key_exists('retcode', $arr)) {
            $this->msg[] = '微云签到失败！' . $arr['retmsg'];
        } else {
            $this->msg[] = '微云签到失败！' . $data;
        }
    }
    public function vipqd() {
        $url = 'http://vipfunc.qq.com/act/client_oz.php?action=client&g_tk=' . $this->gtk2;
        $data = $this->get_curl($url, 0, $url, $this->cookie);
        if ($data == '{ret:0}') $this->msg[] = $this->uin . ' 会员面板签到成功！';
        else $this->msg[] = $this->uin . ' 会员面板签到失败！' . $json;
        $data = $this->get_curl("http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=23314&format=json&g_tk=" . $this->gtk2 . "&cachetime=" . time() , 0, 'http://vip.qq.com/', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) $this->msg[] = $this->uin . ' 会员网页版签到成功！';
        elseif ($arr['ret'] == 10601) $this->msg[] = $this->uin . ' 会员网页版今天已经签到！';
        elseif ($arr['ret'] == 10002) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 会员网页版签到失败！SKEY过期';
        } elseif ($arr['ret'] == 20101) $this->msg[] = $this->uin . ' 会员网页版签到失败！不是QQ会员！';
        else $this->msg[] = $this->uin . ' 会员网页版签到失败！' . $arr['msg'];
        $data = $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?actid=52002&rand=0.27489888' . time() . '&g_tk=' . $this->gtk2 . '&format=json', 0, 'http://vip.qq.com/', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) $this->msg[] = $this->uin . ' 会员手机端签到成功！';
        elseif ($arr['ret'] == 10601) $this->msg[] = $this->uin . ' 会员手机端今天已经签到！';
        elseif ($arr['ret'] == 10002) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 会员手机端签到失败！SKEY过期';
        } else $this->msg[] = $this->uin . ' 会员手机端签到失败！' . $arr['msg'];
        $data = $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=56247&g_tk=' . $this->gtk2 . '&pvsrc=&fotmat=json&cache=0', 0, 'http://vip.qq.com/', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) $this->msg[] = $this->uin . ' 三国之刃会员每周签到礼包领取成功！';
        elseif ($arr['ret'] == 10601) $this->msg[] = $this->uin . ' 三国之刃会员每周签到礼包已领取！';
        elseif ($arr['ret'] == 40039) $this->msg[] = $this->uin . ' 三国之刃会员每周签到礼包 不符合领取条件';
        elseif ($arr['ret'] == 10002) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 三国之刃会员每周签到礼包领取失败！SKEY过期';
        } else $this->msg[] = $this->uin . ' 三国之刃会员每周签到礼包领取失败！' . $arr['msg'];
        $data = $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=54963&isLoadUserInfo=1&format=json&g_tk=' . $this->gtk2, 0, 'http://vip.qq.com/', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) $this->msg[] = $this->uin . ' 会员积分签到成功！';
        elseif ($arr['ret'] == 10601) $this->msg[] = $this->uin . ' 会员积分今天已经签到！';
        elseif ($arr['ret'] == 10002) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 会员积分签到失败！SKEY过期';
        } else $this->msg[] = $this->uin . ' 会员积分签到失败！' . $arr['msg'];
        $data = $this->get_curl('http://iyouxi.vip.qq.com/ams2.02.php?actid=23074&g_tk_type=1sid=&rand=0.8656469448520889&format=json&g_tk=' . $this->gtk2, 0, 'http://vip.qq.com/', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) $this->msg[] = $this->uin . ' 会员积分2签到成功！';
        elseif ($arr['ret'] == 10601) $this->msg[] = $this->uin . ' 会员积分2今天已经签到！';
        elseif ($arr['ret'] == 10002) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 会员积分2签到失败！SKEY过期';
        } else $this->msg[] = $this->uin . ' 会员积分2签到失败！' . $arr['msg'];
        $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=27754&g_tk=' . $this->gtk2 . '&pvsrc=undefined&ozid=509656&vipid=MA20131223091753081&format=json&_=' . time() , 0, 'http://vip.qq.com/', $this->cookie);
        $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?_c=page&actid=27755&g_tk=' . $this->gtk2 . '&pvsrc=undefined&ozid=509656&vipid=MA20131223091753081&format=json&_=' . time() , 0, 'http://vip.qq.com/', $this->cookie);
        $this->get_curl('http://iyouxi.vip.qq.com/ams3.0.php?g_tk=' . $this->gtk2 . '&actid=22249&_c=page&format=json&_=' . time() , 0, 'http://vip.qq.com/', $this->cookie);
        $this->get_curl("http://iyouxi.vip.qq.com/jsonp.php?_c=page&actid=5474&isLoadUserInfo=1&format=json&g_tk=" . $this->gtk2 . "&_=" . time() , 0, 0, $this->cookie);
    }
    public function lzqd() {
        $url = 'http://share.music.qq.com/fcgi-bin/dmrp_activity/fcg_feedback_send_lottery.fcg?activeid=110&rnd=' . time() . '157&g_tk=' . $this->gtk . '&uin=' . $this->uin . '&hostUin=0&format=json&inCharset=UTF-8&outCharset=UTF-8&notice=0&platform=activity&needNewCode=1';
        $data = $this->get_curl($url, 0, 'http://y.qq.com/vip/fuliwo/index.html', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('code', $arr) && $arr['code'] == 0) {
            if ($arr['data']['alreadysend'] == 1) $this->msg[] = '您今天已经签到过了！';
            else $this->msg[] = '绿钻签到成功！';
        } elseif ($arr['code'] == - 200017) {
            $this->msg[] = '你不是绿钻无法签到！';
        } else {
            $this->msg[] = '绿钻签到失败！';
        }
        $url = 'http://share.music.qq.com/fcgi-bin/dmrp_activity/fcg_dmrp_draw_lottery.fcg?activeid=159&rnd=' . time() . '482&g_tk=' . $this->gtk . '&uin=' . $this->uin . '&hostUin=0&format=json&inCharset=UTF-8&outCharset=UTF-8&notice=0&platform=activity&needNewCode=1';
        $data = $this->get_curl($url, 0, 'http://y.qq.com/vip/fuliwo/index.html', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '绿钻抽奖成功！';
        } elseif ($arr['code'] == 200008) {
            $this->msg[] = '您没有抽奖机会！';
        } else {
            $this->msg[] = '绿钻抽奖失败！';
        }
    }
    public function pqd() {
        $url = "http://iyouxi.vip.qq.com/ams3.0.php?g_tk=" . $this->gtk2 . "&pvsrc=102&ozid=511022&vipid=&actid=32961&format=json" . time() . "8777&cache=3654";
        $data = $this->get_curl($url, 0, 'http://youxi.vip.qq.com/m/wallet/activeday/index.html?_wv=3&pvsrc=102', $this->cookie);
        $arr = json_decode($data, true);
        if (array_key_exists('ret', $arr) && $arr['ret'] == 0) {
            $this->msg[] = '钱包签到成功！';
        } elseif ($arr['ret'] == 37206) {
            $this->msg[] = '钱包签到失败！你没有绑定银行卡';
        } elseif ($arr['ret'] == 10601) {
            $this->msg[] = '你今天已钱包签到！';
        } else {
            $this->msg[] = '钱包签到失败！' . $arr['msg'];
        }
    }
    public function getSubstr($str, $leftStr, $rightStr) {
        $left = strpos($str, $leftStr);
        $right = strpos($str, $rightStr, $left);
        if ($left < 0 or $right < $left) return '';
        return substr($str, $left + strlen($leftStr) , $right - $left - strlen($leftStr));
    }
}
?>