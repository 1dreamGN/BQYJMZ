<?php
/*
 * 3G挂机协议
 *Author：消失的彩虹海 & 快乐是福 & 云上的影子 & 龙魂
*/
class qzone {
	public $msg;
	public function __construct($uin, $sid = null) {
		$this->uin = $uin;
		$this->sid = $sid;
	}
	public function gq()
	{
		$url = 'http://pt.3g.qq.com/s?aid=nLogin3gqqbysid&3gqqsid=' . $this->sid;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'MQQBrowser WAP (Nokia/MIDP2.0)');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($curl);
		curl_close($curl);
		if (preg_match('/nqqchatMain/i', $content)) {
			preg_match('/sid=(.{24})&/iU', $content, $sid);
			$url = 'http://q16.3g.qq.com/g/s?aid=chgStatus&s=10&sid=' . $sid[1];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_USERAGENT, 'MQQBrowser WAP (Nokia/MIDP2.0)');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_exec($curl);
			curl_close($curl);
			$resultStr = $this->uin . ' 3G挂机成功!';
		} elseif (preg_match('/设备锁/i', $content)) {
			$this->msg[] = $this->uin . ' 你已开启QQ设备锁，请使用QQ手机版登录';
		} elseif (preg_match('/sid已经过期/i', $content)) {
			$this->sidzt = 1;
			$this->msg[] = $this->uin . ' 3G挂机失败！SID已失效';
		} else $resultStr = $content;
		$this->msg[] = $resultStr;
	}
	public function robot($nc) {
		$apiurl = 'http://i.itpk.cn/api.php?question=';
		$ch = curl_init($apiurl . $msg);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($ch);
		curl_close($ch);
		$content = str_replace("[cqname]", $nc, $content);
		$content = str_replace("[name]", "你", $content);
		return $content;
	}
	public function sendmsg($qq, $sid, $sendmsg) {
		global $method;
		$url = 'http://q32.3g.qq.com/g/s?sid=' . $sid . '&3G_UIN=' . $qq . '&saveURL=0&aid=nqqChat';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser WAP (Nokia/MIDP2.0)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		echo $url = curl_exec($ch);
		curl_close($ch);
		$url = htmlspecialchars($url);
		$qq2 = explode('【QQ功能】<br/>', $url);
		$qq2 = explode('">', $qq2[1]);
		$qq2 = explode('q=', $qq2[0]);
		$m = explode('提示</a>)', $url);
		$m = explode('<input', $m[1]);
		$msg = explode('<br/>', $url);
		$nc = explode(':', $msg[2]);
		$nc = $nc[0];
		$qq2 = $qq2[1];
		$array = explode($nc, $m[0]);
		$tj = (count($array) - 1);
		$sc = array($msg[3], $msg[5], $msg[7]);
		$resultStr = '';
		for ($i = 0;$i < $tj;$i++) {
			$arr1 = array(' ', '',);
			$arr2 = array('', '',);
			$msg = str_replace($arr1, $arr2, $sc[$i]);
			$d = date("Y-m-j H:i:s");
			if ($method = 'robot') {
				$msg3 = robot($msg);
				if ($msg3 == '') $msg3 = "{$nc}
			不懂这是什么意思哦～";
			} elseif ($method = 'diy') {
				$msg3 = $sendmsg;
			}
			$resultStr.= '问:<FONT color=green>' . $msg . '</FONT><br>答:' . $msg3 . '<hr>';
			$url5 = 'http://q16.3g.qq.com/g/s?sid=' . $sid . '&aid=sendmsg&tfor=qq&referer=';
			$post = 'msg=' . $msg3 . '&u=' . $qq2 . '&saveURL=0&do=send';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL, $url5);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_exec($ch);
			curl_close($ch);
			sleep(1);
		}
		return $resultStr;
	}
}
?>