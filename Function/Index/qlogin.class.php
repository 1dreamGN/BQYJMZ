<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://zan.ww78.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: 快乐是福 <815856515@qq.com> && 顾念
// +----------------------------------------------------------------------
// | QQ: 2302701417
// +----------------------------------------------------------------------
// | 如需修改和引用，请保留此头部信息！

class Qqlogin {
	public $json;
	public function __construct($uin, $pwd, $code = 0, $cap_cd=0, $sig = 0, $sess = 0) {
        $this->uin = $uin;
        $this->pwd = $pwd;
        $this->code = $code;
        $this->sig = $cap_cd;
		$this->sess = $sess;
        if ($code) {
            $this->dovc($sig);
        } else {
            $this->checkvc();
        }
	}
	public function login(){
		if(strpos('s'.$this->code,'!')){
			$v1=0;
		}else{
			$v1=1;
		}
		$p=$this->getp();
		$url='http://ptlogin2.qq.com/login?verifycode='.strtoupper($this->code).'&u='.$this->uin.'&p='.$p.'&pt_randsalt=2&ptlang=2052&low_login_enable=0&u1=http%3A%2F%2Fh5.qzone.qq.com%2Fmqzone%2Findex%3Fg_f%3D&from_ui=1&fp=loginerroralert&device=2&aid=549000912&daid=5&pt_ttype=1&pt_3rd_aid=0&ptredirect=1&h=1&g=1&pt_uistyle=9&regmaster=&pt_vcode_v1='.$v1.'&pt_verifysession_v1='.$this->sig.'&';
		$ret = $this->get_curl($url,0,0,0,1);
		if(preg_match("/ptuiCB\('(.*?)'\);/", $ret, $arr)){
			$r=explode("','",str_replace("', '","','",$arr[1]));
			if($r[0]==0){
				if(strpos($r[2],'mibao_vry')){
					$this->json='{"code":-3,"msg":"请先到QQ安全中心关闭网页登录保护！"}';
					return false;
				}
				preg_match('/skey=@(.{9});/',$ret,$skey);
				preg_match('/ptsig=(.{44})/',$r[2],$ptsig);
				$data=$this->get_curl($r[2],0,0,0,1);
				if($data) {
					preg_match("/p_skey=(.*?);/", $data, $matchs);
					$p_skey = $matchs[1];
					$pookie='';
					preg_match_all('/Set-Cookie: (.*);/iU',$data,$matchs);
					foreach ($matchs[1] as $val) {
						$pookie.=$val.'; ';
					}
					preg_match("/Location: (.*?)\r\n/iU", $data, $matchs);
					$sid=explode('sid=',$matchs[1]);
					$sid=$sid[1];
				}
				if($p_skey && $skey[1]){
					$this->json='{"code":0,"uin":"'.$this->uin.'","sid":"'.$sid.'","skey":"@'.$skey[1].'","p_skey":"'.$p_skey.'","ptsig":"'.$ptsig[1].'","pookie":"'.$pookie.'"}';
				}else{
					$this->json='{"code":-3,"uin":"'.$this->uin.'","msg":"登录成功，获取对应信息失败！"}';
				}
			}elseif($r[0]==4){
				$this->json='{"code":-3,"msg":"验证码错误!"}';
				$this->checkvc();
			}elseif($r[0]==3){
				$this->json='{"code":-3,"msg":"密码错误！"}';
			}elseif($r[0]==19){
				$this->json='{"code":-3,"msg":"您的帐号暂时无法登录，请到 http://aq.qq.com/007 恢复正常使用！"}';
			}else{
				$this->json='{"code":-3,"msg":"'.str_replace('"','\'',$r[4]).'"}';
			}
		}else{
			$this->json='{"code":-3,"msg":"'.$ret.'"}';
		}
	}
	public function getp(){
		$url="http://encode.duapp.com/?type=1&uin=".$this->uin."&pwd=".strtoupper($this->pwd)."&vcode=".strtoupper($this->code);
		$getp=$this->get_curl($url,0,1);
		if($getp){
			return $getp;
		}else{
			$this->json='{"code":-3,"msg":"获取P值失败，请稍候重试！"}';
		}
	}
	public function dovc($sig) {
		if(strpos($this->code,',')){
			$subcapclass=9;
		}else{
			$subcapclass=0;
		}
		$url='http://captcha.qq.com/cap_union_new_verify';
		$post='aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$this->uin.'&color=&showtype=&lang=2052&cap_cd='.$this->sig.'&rnd=0.762142'.time().'&rand=0.744936'.time().'&sess='.$this->sess.'&subcapclass='.$subcapclass.'&vsig='.$sig.'&ans='.$this->code.'&collect='.$this->get_curl('http://getcollect.duapp.com/');
		$data=$this->get_curl($url,$post);
		$arr=json_decode($data,true);
		if(array_key_exists('errorCode',$arr) && $arr['errorCode']==0){
			$this->code = $arr['randstr'];
            $this->sig = $arr['ticket'];
            $this->login();
		}elseif($arr['errorCode']==50){
			$this->getvc($this->sig);
		}else{
			exit("<script language='javascript'>alert('验证失败，请重试。');history.go(-1);</script>");
		}
    }
	public function checkvc() {
		$url='http://check.ptlogin2.qq.com/check?regmaster=&pt_tea=1&pt_vcode=1&uin='.$this->uin.'&appid=549000912&js_ver=10132&js_type=1&login_sig=&u1=http%3A%2F%2Fqzs.qq.com%2Fqzone%2Fv5%2Floginsucc.html%3Fpara%3Dizone&r=0.397176'.time();
        $data = $this->get_curl($url);
        if (preg_match("/ptui_checkVC\('(.*?)'\);/", $data, $arr)) {
            $r = explode("','", $arr[1]);
            if ($r[0] == 1) {
                $this->json = '{"code":-1,"sig":"' . $r[1] . '"}';
                $this->getvc($r[1]);
            } else {
                $this->code = $r[1];
                $this->sig = $r[3];
                $this->login();
            }
        } else {
            exit("<script language='javascript'>alert('判断是否有验证码失败，请稍候重试！');history.go(-1);</script>");
        }
    }
	
	public function getvc($cap_cd){
		if($this->sess==0){
			$url='http://captcha.qq.com/cap_union_prehandle?aid=549000912&captype=&protocol=https&clientype=1&disturblevel=&apptype=2&noheader=0&color=&showtype=&fb=1&theme=&lang=2052&cap_cd='.$cap_cd.'&uid='.$this->uin.'&callback=&sess=';
			$data=$this->get_curl($url);
			$data=substr($data,1,-1);
			$arr=json_decode($data,true);
			$sess=$arr['sess'];
			if(!$sess)return array('saveOK'=>-3,'msg'=>'获取验证码参数失败');

			$url='http://captcha.qq.com/cap_union_new_show?aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$this->uin.'&color=&showtype=&lang=2052&sess='.$sess.'&cap_cd='.$cap_cd.'&rnd='.rand(100000,999999);
			$data=$this->get_curl($url);
			if(strpos($data,'img_index=')){
				if(preg_match("/=\"([0-9a-zA-Z\*\_\-]{187})\"/", $data, $match1)){
					preg_match('/\$=Number\(\"(\d+)\"\)/', $data, $Number);
					$height = $Number[1];
					$imgA = $this->getvcpic2($this->uin,$cap_cd,$match1[1],$match2[1],1);
					$imgB = $this->getvcpic2($this->uin,$cap_cd,$match1[1],$match2[1],0);
					$width = $this->captcha($imgA, $imgB);
					$ans = $width.','.$height.';';
					$this->code = $ans;
					$this->sess = $sess;
					$this->dovc($match1[1]);
				}else{
					$this->json='{"code":-3,"msg":"获取验证码失败，请稍候重试！"}';
				}
			}else{
				if(preg_match("/=\"([0-9a-zA-Z\*\_\-]{129})\"/", $data, $match1)){
					$this->json='{"code":-1,"cap_cd":"'.$cap_cd.'","sig":"'.$match1[1].'","sess":"'.$sess.'"}';
				}else{
					$this->json='{"code":-3,"msg":"获取验证码失败，请稍候重试！"}';
				}
			}
		}else{
			$url='http://captcha.qq.com/cap_union_new_getsig';
			$post='aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$this->uin.'&color=&showtype=&cap_cd='.$cap_cd.'&rnd=634076&rand=0.37335288'.time().'&sess='.$this->sess;
			$data=$this->get_curl($url,$post);
			$arr=json_decode($data,true);
			if($arr['initx'] && $arr['inity']){
				$height = $arr['inity'];
				$imgA = $this->getvcpic2($this->uin,$cap_cd,$arr['vsig'],$this->sess,1);
				$imgB = $this->getvcpic2($this->uin,$cap_cd,$arr['vsig'],$this->sess,0);
				$width = $this->captcha($imgA, $imgB);
				$ans = $width.','.$height.';';
				$this->code = $ans;
				$this->dovc($arr['vsig']);
			}elseif($arr['vsig']){
				$this->json='{"code":-1,"cap_cd":"'.$cap_cd.'","sig":"'.$arr['vsig'].'","sess":"'.$this->sess.'"}';
			}else{
				$this->json='{"code":-3,"msg":"获取验证码失败，请稍候重试！"}';
			}
		}
	}

	public function getvcpic($uin,$cap_cd,$sig,$sess) {
        $url='http://captcha.qq.com/cap_union_new_getcapbysig?aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$uin.'&color=&showtype=&lang=2052&cap_cd='.$cap_cd.'&rnd='.rand(100000,999999).'&rand=0.02398118'.time().'&sess='.$sess.'&vsig='.$sig.'&ischartype=1';
		return $this->get_curl($url);
    }

	public function getvcpic2($uin,$cap_cd,$sig,$sess,$img_index=0) {
        $url='http://captcha.qq.com/cap_union_new_getcapbysig?aid=549000912&captype=&protocol=http&clientype=1&disturblevel=&apptype=2&noheader=0&uid='.$uin.'&color=&showtype=&lang=2052&cap_cd='.$cap_cd.'&rnd='.rand(100000,999999).'&rand=0.02398118'.time().'&sess='.$sess.'&vsig='.$sig.'&img_index='.$img_index;
		return $url;
    }

	private function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept:application/json";
		$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
		$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
		$httpheader[] = "Connection:close";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		if($post){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if($header){
			curl_setopt($ch, CURLOPT_HEADER, TRUE);
		}
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		if(!$referer){
			curl_setopt($ch, CURLOPT_REFERER, "http://ptlogin2.qq.com/");
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
		if($ua){
			curl_setopt($ch, CURLOPT_USERAGENT,$ua);
		}else{
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
		}
		if($nobaody){
			curl_setopt($ch, CURLOPT_NOBODY,1);
		}
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

}