<?php

/* Author：消失的彩虹海 & 快乐是福 & 云上的影子 & 顾念 */

class qzone
{
    public $msg;
	private $qzonetoken = null;

    public function __construct($uin, $sid = null, $skey = null, $p_skey = null, $pookie = null)
    {
        $this->uin = $uin;
        $this->sid = $sid;
        $this->skey = $skey;
        $this->p_skey = $p_skey;
        $this->pookie_new = $pookie;
        $this->gtk = $this->getGTK($skey);
        $this->gtk1 = $this->getGTK($p_skey);
        if ($p_skey == null)
            $this->cookie = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . ';';
        else {
            $this->cookie = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . '; p_skey=' . $p_skey . '; p_uin=o0' . $uin . ';';
            $this->cookie1 = 'pt2gguin=o0' . $uin . '; uin=o0' . $uin . '; skey=' . $skey . ';';
        }
    }
    public function getSpecialnew()
    {
        $ua = 'Mozilla/5.0 (Linux; U; Android 4.0.3; zh-CN; Lenovo A390t Build/IML74K) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.9.457 U3/0.8.0 Mobile Safari/533.1';
        $url = "https://mobile.qzone.qq.com/get_feeds?g_tk=" . $this->gtk1 . "&res_type=1&res_attach=&refresh_type=2&format=json";
        $json = $this->get_curl($url, 0, 1, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '获取说说列表成功！';
            $shuos = $arr['data']['vFeeds'];
            return $shuos;
        } elseif (strpos($arr['message'], '务器繁忙')) {
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        } elseif (strpos($arr['message'], '登录') || strpos($arr['message'], '数错误')) {
            $this->skeyzt = 1;
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        } else {
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        }
    }
    public function quantu()
    {
        if ($shuos = $this->getnew()) {
            foreach ($shuos as $shuo) {
                $albumid = '';
                $lloc = '';
                if ($shuo['original']) {
                    $albumid = $shuo['original']['cell_pic']['albumid'];
                    $lloc = $shuo['original']['cell_pic']['picdata'][0]['lloc'];
                }
                if ($shuo['pic']) {
                    $albumid = $shuo['pic']['albumid'];
                    $lloc = $shuo['pic']['picdata'][0]['lloc'];
                }
                if (!empty($albumid)) {
                    $touin = $shuo['userinfo']['user']['uin'];
                    $this->quantu_do($touin, $albumid, $lloc);
                    if ($this->skeyzt) break;
                }
            }
        }
    }

    public function quantu_do($touin, $albumid, $lloc)
    {
        $url = "http://app.photo.qq.com/cgi-bin/app/cgi_annotate_face?g_tk=" . $this->gtk1;
        $post = "format=json&uin={$this->uin}&hostUin=$touin&faUin={$this->uin}&faceid=&oper=0&albumid=$albumid&lloc=$lloc&facerect=10_10_50_50&extdata=&inCharset=GBK&outCharset=GBK&source=qzone&plat=qzone&facefrom=moodfloat&faceuin={$this->uin}&writeuin={$this->uin}&facealbumpage=quanren&qzreferrer=http://user.qzone.qq.com/$uin/infocenter?via=toolbar";
        $json = $this->get_curl($url, $post, 'http://user.qzone.qq.com/' . $uin . '/infocenter?via=toolbar', $this->cookie);
        $json = mb_convert_encoding($json, "UTF-8", "gb2312");
        $arr = json_decode($json, true);
        if (!array_key_exists('code', $arr)) {
            $this->msg[] = "圈{$touin}的图{$albumid}失败，原因：获取结果失败！";
        } elseif ($arr['code'] == -3000) {
            $this->skeyzt = 1;
            $this->msg[] = "圈{$touin}的图{$albumid}失败，原因：SKEY已失效！";
        } elseif ($arr['code'] == 0) {
            $this->msg[] = "圈{$touin}的图{$albumid}成功";
        } else {
            $this->msg[] = "圈{$touin}的图{$albumid}失败，原因：" . $arr['message'];
        }
    }

    public function getll()
    {
        $url = 'https://mobile.qzone.qq.com/list?g_tk=' . $this->gtk . '&format=json&list_type=msg&action=0&res_uin=' . $this->uin . '&count=20';
        $get = $this->get_curl($url, 0, 1, $this->cookie);
        $arr = json_decode($get, true);
        if ($arr['data']['vFeeds']) return $arr['data']['vFeeds'];
        else $this->msg[] = '没有留言！';
    }

    public function getliuyan()
    {
        $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0';
        $url = 'http://m.qzone.qq.com/cgi-bin/new/get_msgb?uin=' . $this->uin . '&hostUin=' . $this->uin . '&start=0&s=0.935081' . time() . '&format=json&num=20&inCharset=utf-8&outCharset=utf-8&g_tk=' . $this->gtk1;
        $json = $this->get_curl($url, 0, 'http://user.qzone.qq.com/', $this->cookie, 0, $ua);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '获取留言列表成功！';
            return $arr['data']['commentList'];
        } else {
            $this->msg[] = '获取留言列表失败！';
        }
    }

    public function PCdelll($id, $uin)
    {
        $url = "http://m.qzone.qq.com/cgi-bin/new/del_msgb?g_tk=" . $this->gtk1;
        $post = "qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fmsgboard%2Fmsgbcanvas.html%23page%3D1&hostUin=" . $this->uin . "&idList=" . $id . "&uinList=" . $uin . "&format=json&iNotice=1&inCharset=utf-8&outCharset=utf-8&ref=qzone&json=1&g_tk=" . $this->gtk;
        $data = $this->get_curl($url, $post, 'http://ctc.qzs.qq.com/qzone/msgboard/msgbcanvas.html', $this->cookie);
        $arr = json_decode($data, true);
        if ($arr) {
            if (array_key_exists('code', $arr) && $arr['code'] == 0) {
                $this->msg[] = '删除 ' . $uin . ' 留言成功！';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = '删除 ' . $uin . ' 留言失败！原因:' . $arr['message'];
            } elseif (array_key_exists('code', $arr)) {
                $this->msg[] = '删除 ' . $uin . ' 留言失败！' . $arr['message'];
            }
        } else {
            $this->msg[] = "未知错误，删除失败！";
        }
    }

    public function cpdelll($id, $uin)
    {
        $url = 'https://mobile.qzone.qq.com/operation/operation_add?g_tk=' . $this->gtk;
        $post = 'opr_type=delugc&res_type=334&res_id=' . $id . '&real_del=0&res_uin=' . $this->uin . '&format=json';
        $data = $this->get_curl($url, $post, 1, $this->cookie);
        $arr = json_decode($data, true);
        if ($arr) {
            if (array_key_exists('code', $arr) && $arr['code'] == 0) {
                $this->msg[] = '删除 ' . $uin . ' 留言成功！';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = '删除 ' . $uin . ' 留言失败！原因:' . $arr['message'];
            } else {
                $this->msg[] = '删除 ' . $uin . ' 留言失败！原因:' . $arr['message'];
            }
        } else {
            $this->msg[] = '未知错误，删除失败！可能留言已删尽';
        }
    }

    public function delll($do = 0)
    {
        if ($do) {
            if ($liuyans = $this->getliuyan()) {
                foreach ($liuyans as $row) {
                    $cellid = $row['id'];
                    $uin = $row['uin'];
                    if ($cellid) {
                        $this->PCdelll($cellid, $uin);
                    }
                }
            }
        } else {
            if ($liuyans = $this->getll()) {
                foreach ($liuyans as $row) {
                    $cellid = $row['id']['cellid'];
                    $uin = $row['userinfo']['user']['uin'];
                    if ($cellid) {
                        $this->cpdelll($cellid, $uin);
                    }
                }
            }
        }
    }

    public function pczhuanfa($con, $touin, $tid)
    {
        $url = 'http://taotao.qzone.qq.com/cgi-bin/emotion_cgi_forward_v6?g_tk=' . $this->gtk1.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
        $ua = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36';
        $post = 'tid=' . $tid . '&t1_source=1&t1_uin=' . $touin . '&signin=0&con=' . $con . '&with_cmt=0&fwdToWeibo=0&forward_source=2&code_version=1&format=json&out_charset=UTF-8&hostuin=' . $this->uin . '&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F' . $this->uin . '%2Finfocenter';
        $json = $this->get_curl($url, $post, "http://user.qzone.qq.com/" . $this->uin . "/infocenter", $this->cookie, $ua);
        if ($json) {
            $arr = json_decode($json, true);
            if ($arr[code] == 0) {
                $this->shuotid = $arr[tid];
                $this->msg[] = $this->uin . '转发' . $touin . '说说成功[PC]';
            } else if ($arr[code] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = $this->uin . '转发' . $touin . '说说失败[PC]！原因:' . $arr[message];
            } else {
                $this->msg[] = $this->uin . '转发' . $touin . '说说失败[PC]！原因' . $json;
            }
        } else {
            $this->msg[] = $this->uin . '获取转发' . $touin . '说说结果失败[PC]';
        }
    }

    public function cpzhuanfa($con, $touin, $tid)
    {
        $url = 'http://mobile.qzone.qq.com/operation/operation_add?g_tk=' . $this->gtk1.'&qzonetoken='.$this->getToken();
        $post = 'res_id=' . $tid . '&res_uin=' . $touin . '&format=json&reason=' . urlencode($con) . '&res_type=311&opr_type=forward&operate=1&sid=' . $this->sid;
        $json = $this->get_curl($url, $post, 1, $this->cookie);
        if ($json) {
            $arr = json_decode($json, true);
            if ($arr['code'] == 0) {
                $this->msg[] = $this->uin . '转发' . $touin . '说说成功[CP]';
            } else if ($arr[code] == -3000) {
                $this->sidzt = 1;
                $this->msg[] = $this->uin . '转发' . $touin . '说说失败[CP]！原因:' . $arr['message'];
            } else {
                $this->msg[] = $this->uin . '转发' . $touin . '说说失败[CP]！原因:' . $arr['message'];
            }
        } else {
            $this->msg[] = $this->uin . '获取转发' . $touin . '说说结果失败[CP]';
        }
    }

    public function getmynew($uin = null)
    {
        if (empty($uin)) $uin = $this->uin;
        $url = 'http://sh.taotao.qq.com/cgi-bin/emotion_cgi_feedlist_v6?hostUin=' . $uin . '&ftype=0&sort=0&pos=0&num=10&replynum=0&code_version=1&format=json&need_private_comment=1&g_tk=' . $this->gtk;
        $json = $this->get_curl($url, 0, 0, $this->cookie);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '获取说说列表成功！';
            return $arr['msglist'];
        } else {
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        }
    }

    public function zhuanfa($do = 0, $uins = array(), $con = null)
    {
        if (count($uins) == 1 && $uins[0] != '') {
            $uin = $uins[0];
            if ($shuos = $this->getmynew($uin)) {
                foreach ($shuos as $shuo) {
                    $cellid = $shuo['tid'];
                    if ($do) {
                        $this->pczhuanfa($con, $uin, $cellid);
                        if ($this->skeyzt) break;
                    } else {
                        $this->cpzhuanfa($con, $uin, $cellid);
                        if ($this->skeyzt) break;
                    }
                }
            }
        } elseif (count($uins) > 1) {
            global $getss;
            if ($shuos = $this->getnew($getss)) {
                foreach ($shuos as $shuo) {
                    $uin = $shuo['userinfo']['user']['uin'];
                    if (in_array($uin, $uins)) {
                        $cellid = $shuo['id']['cellid'];
                        if ($do) {
                            $this->pczhuanfa($con, $uin, $cellid);
                            if ($this->skeyzt) break;
                        } else {
                            $this->cpzhuanfa($con, $uin, $cellid);
                            if ($this->skeyzt) break;
                        }
                    }
                }
            }
        } else {
            global $getss;
            if ($shuos = $this->getnew($getss)) {
                foreach ($shuos as $shuo) {
                    $uin = $shuo['userinfo']['user']['uin'];
                    $cellid = $shuo['id']['cellid'];
                    if ($do) {
                        $this->pczhuanfa($con, $uin, $cellid);
                        if ($this->skeyzt) break;
                    } else {
                        $this->cpzhuanfa($con, $uin, $cellid);
                        if ($this->skeyzt) break;
                    }
                }
            }
        }
    }

    public function cpshuo($content, $richval = '', $sname = '', $lon = '', $lat = '')
    {
        $url = 'http://mobile.qzone.qq.com/mood/publish_mood?qzonetoken='.$this->getToken().'&g_tk=' . $this->gtk1;
        $post = 'opr_type=publish_shuoshuo&res_uin=' . $this->uin . '&content=' . $content . '&richval=' . $richval . '&lat=' . $lat . '&lon=' . $lon . '&lbsid=&issyncweibo=0&is_winphone=2&format=json&source_name=' . $sname;
        $result = $this->get_curl($url, $post, 1, $this->cookie);
        $arr = json_decode($result, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = $this->uin . ' 发布说说成功[CP]';
        } elseif ($arr['code'] == -3000) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . ' 发布说说失败[CP]！原因:SID已失效，请更新SID';
        } elseif (@array_key_exists('code', $json)) {
            $this->msg[] = $this->uin . ' 发布说说失败[CP]！原因:' . $arr['message'];
        } else {
            $this->msg[] = $this->uin . ' 发布说说失败[CP]！原因:' . $result;
        }
    }

    public function pcshuo($content, $richval = 0)
    {
        $url = 'http://taotao.qq.com/cgi-bin/emotion_cgi_publish_v6?g_tk=' . $this->gtk1.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
        $post = 'syn_tweet_verson=1&paramstr=1&pic_template=';
        if ($richval) {
            $post .= "&richtype=1&richval=" . $this->uin . ",{$richval}&special_url=&subrichtype=1&pic_bo=uAE6AQAAAAABAKU!%09uAE6AQAAAAABAKU!";
        } else {
            $post .= "&richtype=&richval=&special_url=";
        }
        $post .= "&subrichtype=&con=" . $content . "&feedversion=1&ver=1&ugc_right=1&to_tweet=0&to_sign=0&hostuin=" . $this->uin . "&code_version=1&format=json&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F" . $this->uin . "%2F311";
        $ua = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";
        $json = $this->get_curl($url, $post, 'http://user.qzone.qq.com/' . $this->uin . '/311', $this->cookie);
        if ($json) {
            $arr = json_decode($json, true);
            $arr['feedinfo'] = '';
            if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
                $this->zt = 1;
                $this->msg[] = $this->uin . ' 发布说说成功[PC]';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = $this->uin . ' 发布说说失败[PC]！原因:SID已失效，请更新SID';
            } elseif ($arr['code'] == -10045) {
                $this->msg[] = $this->uin . ' 发布说说失败[PC]！原因:' . $arr['message'];
            } elseif (@array_key_exists('code', $arr)) {
                $this->msg[] = $this->uin . ' 发布说说失败[PC]！原因:' . $arr['message'];
            } else {
                $this->msg[] = $this->uin . ' 发布说说失败[PC]！原因' . $json;
            }
        } else {
            $this->msg[] = $this->uin . ' 获取发布说说结果失败[PC]';
        }
    }

    public function shuo($do = 0, $content, $image = null)
    {
        if (!empty($image)) {
            if ($pic = $this->url_get($image)) {
                $image_size = getimagesize($image);
                $richval = $this->uploadimg($pic, $image_size);
            }
        } else {
            $richval = null;
        }
        if ($do) {
            $this->pcshuo($content, $richval);
        } else {
            $this->cpshuo($content, $richval);
        }
    }

	public function pcdel($cellid){
		$url='http://taotao.qq.com/cgi-bin/emotion_cgi_delete_v6?g_tk='.$this->gtk1;
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

    public function cpdel($cellid, $appid)
    {
        $url = 'http://mobile.qzone.qq.com/operation/operation_add?g_tk=' . $this->gtk1;
        $post = "opr_type=delugc&res_type={$appid}&res_id={$cellid}&real_del=0&res_uin=" . $this->uin . "&format=json";
        $ua = "Mozilla/5.0 (Linux; U; Android 4.0.3; zh-CN; Lenovo A390t Build/IML74K) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.9.457 U3/0.8.0 Mobile Safari/533.1";
        $json = $this->get_curl($url, $post, 1, $this->cookie, 0, $ua);
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '删除说说' . $cellid . '成功[CP]';
        } elseif ($arr['code'] == -3000) {
            $this->skeyzt = 1;
            $this->msg[] = '删除说说' . $cellid . '失败[CP]！原因:SID已失效，请更新SID';
        } elseif (@array_key_exists('code', $json)) {
            $this->msg[] = '删除说说' . $cellid . '失败[CP]！原因:' . $arr['message'];
        } else {
            $this->msg[] = '删除说说' . $cellid . '失败[CP]！原因:' . $json;
        }
    }

    public function shuodel($do = 0)
    {
        if ($shuos = $this->getmynew()) {
            foreach ($shuos as $shuo) {
                $cellid = $shuo['tid'];
                $this->pcdel($cellid);
            }
        }
    }

    public function cpreply($content, $uin, $cellid, $type, $param)
    {
        $post = 'res_id=' . $cellid . '&res_uin=' . $uin . '&format=json&res_type=' . $type . '&content=' . $content . '&busi_param=' . $param . '&opr_type=addcomment';
        $url = 'http://mobile.qzone.qq.com/operation/publish_addcomment?qzonetoken='.$this->getToken().'&g_tk=' . $this->gtk1;
        $json = $this->get_curl($url, $post, 1, $this->cookie);
        if ($json) {
            $arr = json_decode($json, true);
            if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
                $this->msg[] = '评论 ' . $uin . ' 的说说成功[CP]';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[CP]！原因:SID已失效，请更新SID';
            } elseif (@array_key_exists('message', $arr)) {
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[CP]！原因:' . $arr['message'];
            } else {
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[CP]！原因:' . $json;
            }
        } else {
            $this->msg[] = '获取评论' . $uin . '的说说结果失败[CP]！';
        }
    }

    public function pcreply($content, $uin, $cellid, $from, $richval = 0)
    {
        $post = 'topicId=' . $uin . '_' . $cellid . '__' . $from . '&feedsType=100&inCharset=utf-8&outCharset=utf-8&plat=qzone&source=ic&hostUin=' . $uin . '&isSignIn=&platformid=52&uin=' . $this->uin . '&format=json&ref=feeds&content=' . $content . '&richval=&richtype=&private=0&paramstr=1&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F' . $this->uin;
		$url='http://h5.qzone.qq.com/proxy/domain/taotao.qzone.qq.com/cgi-bin/emotion_cgi_re_feeds?g_tk='.$this->gtk1;
        $json = $this->get_curl($url, $post, 'http://user.qzone.qq.com/' . $this->uin, $this->cookie);
        if ($json) {
            $arr = json_decode($json, true);
            $arr['data']['feeds'] = '';
            if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
                $this->msg[] = '评论 ' . $uin . ' 的说说成功[PC]';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[PC]！原因:SKEY已失效，请更新SKEY';
            } elseif ($arr['code'] == -3001) {
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[PC]！原因:需要验证码';
            } elseif (@array_key_exists('message', $arr)) {
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[PC]！原因:' . $arr['message'];
            } else {
                $this->msg[] = '评论 ' . $uin . ' 的说说失败[PC]！原因' . $json;
            }
        } else {
            $this->msg[] = '获取评论结果失败[PC]';
        }
    }

    public function reply($do = 0, $contents = '')
    {
        global $getss;
        if ($shuos = $this->getnew($getss)) {
            foreach ($shuos as $shuo) {
                $uin = $shuo['userinfo']['user']['uin'];
                if ($this->is_comment($this->uin, $shuo['comment']['comments'])) {
                    $appid = $shuo['comm']['appid'];
                    $typeid = $shuo['comm']['feedstype'];
                    $curkey = urlencode($shuo['comm']['curlikekey']);
                    $uinkey = urlencode($shuo['comm']['orglikekey']);
                    $from = $shuo['userinfo']['user']['from'];
                    $cellid = $shuo['id']['cellid'];
                    if ($do) {
                        $this->pcreply($contents, $uin, $cellid, $from);
                        if ($this->skeyzt) break;
                    } else {
                        $param = $this->array_str($shuo['operation']['busi_param']);
                        $this->cpreply($contents, $uin, $cellid, $appid, $param);
                    }
                    usleep(100000);
                }
            }
        }
    }

    public function cplike($uin, $type, $unikey, $curkey)
    {
        $post='opuin='.$uin.'&unikey='.$unikey.'&curkey='.$curkey.'&appid='.$appid.'&opr_type=like&format=purejson';
        $url='http://h5.qzone.qq.com/proxy/domain/w.qzone.qq.com/cgi-bin/likes/internal_dolike_app?g_tk='.$this->gtk1;
        $json = $this->get_curl($url, $post, 1, $this->cookie);
        if ($json) {
            $arr = json_decode($json, true);
            if (@array_key_exists('code', $arr) && ($arr['code'] == 0)) {
                $this->msg[] = '赞' . $uin . '的说说成功[CP]';
            } else if ($arr[code] == -3000) {
                $this->sidzt = 1;
                $this->msg[] = '赞' . $uin . '的说说失败[CP]！原因:' . $arr['message'];
            } else if ($arr['code'] == -11210) {
                $this->msg[] = '赞' . $uin . '的说说失败[CP]！原因:' . $arr['message'];
            } else {
                $this->msg[] = '赞' . $uin . '的说说失败[CP]！原因:' . $arr['message'];
            }
        } else {
            $this->msg[] = '获取赞' . $uin . '的说说结果失败[CP]！';
        }
    }

    public function pclike($uin, $curkey, $unikey, $from, $appid, $typeid, $abstime, $fid)
    {
        $post = 'qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F' . $this->uin . '&opuin=' . $this->uin . '&unikey=' . $unikey . '&curkey=' . $curkey . '&from=' . $from . '&appid=' . $appid . '&typeid=' . $typeid . '&abstime=' . $abstime . '&fid=' . $fid . '&active=0&fupdate=1';
        $randserver = array('w.cnc.','w.');
		$url='http://'.$randserver[rand(0,1)].'qzone.qq.com/cgi-bin/likes/internal_dolike_app?g_tk='.$this->gtk1;
        $ua = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36';
        $get = $this->get_curl($url, $post, 'http://user.qzone.qq.com/' . $this->uin, $this->cookie, 0, $ua);
        preg_match('/callback\((.*?)\)\;/is', $get, $json);
        if ($json = $json[1]) {
            $arr = json_decode($json, true);
            if ($arr['message'] == 'succ' || $arr['msg'] == 'succ') {
                $this->msg[] = '赞 ' . $uin . ' 的说说成功[PC]';
            } elseif ($arr['code'] == -3000) {
                $this->skeyzt = 1;
                $this->msg[] = '赞 ' . $uin . ' 的说说失败[PC]！原因:SKEY已失效，请更新SKEY';
            } elseif (@array_key_exists('message', $arr)) {
                $this->msg[] = '赞 ' . $uin . ' 的说说失败[PC]！原因:' . $arr['message'];
            } else {
                $this->msg[] = '赞 ' . $uin . ' 的说说失败[PC]！原因:' . $json;
            }
        } else {
            $this->msg[] = '获取赞' . $uin . '的说说结果失败[PC]';
        }
    }

    public function like($do)
    {
        if ($shuos = $this->getnew()) {
            $i = 0;
            foreach ($shuos as $shuo) {
                $like = $shuo['like']['isliked'];
                if ($like == 0) {
                    $uin = $shuo['userinfo']['user']['uin'];
                    $appid = $shuo['comm']['appid'];
                    $typeid = $shuo['comm']['feedstype'];
                    $curkey = urlencode($shuo['comm']['curlikekey']);
                    $uinkey = urlencode($shuo['comm']['orglikekey']);
                    $from = $shuo['userinfo']['user']['from'];
                    $abstime = $shuo['comm']['time'];
                    $cellid = $shuo['id']['cellid'];
                    if ($do == '2') {
                        $this->pclike($uin, $curkey, $uinkey, $from, $appid, $typeid, $abstime, $cellid);
                        if ($this->skeyzt) break;
                    } else {
                        $this->cplike($uin, $appid, $uinkey, $curkey);
                        if ($this->sidzt) break;
                    }
                    ++$i;
                    usleep(100000);
                }
            }
        } else {
            if ($i == 0) $this->msg[] = '没有要赞的说说[PC]';
        }
    }

    public function getnew($do = '')
    {
        if ($do == 'my') {
            $url = "http://mobile.qzone.qq.com/list?g_tk=" . $this->gtk1 . "&res_attach=&format=json&list_type=shuoshuo&action=0&res_uin=" . $this->uin . "&count=20";
            $json = $this->get_curl($url, 0, 1, $this->cookie);
        } else {
            $url = "http://h5.qzone.qq.com/webapp/json/mqzone_feeds/getActiveFeeds?g_tk=" . $this->gtk1;
            $post = 'res_type=0&res_attach=&refresh_type=2&format=json&attach_info=';
            $json = $this->get_curl($url, $post, 1, $this->cookie);

        }
        $arr = json_decode($json, true);
        if (@array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = '获取说说列表成功！';
            if (isset($arr['data']['vFeeds']))
                return $arr['data']['vFeeds'];
            else
                return $arr['data']['feeds']['vFeeds'];
        } elseif (strpos($arr['message'], '务器繁忙')) {
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        } elseif ($arr['message'] == "系统繁忙" || strpos($arr['message'],'登录')) {
            $this->skeyzt = 1;
            $this->msg[] = '获取最新说说失败！原因:SKEY已失效，请更新SKEY';
            return false;
        } else {
            $this->msg[] = '获取最新说说失败！原因:' . $arr['message'];
            return false;
        }
    }

    public function get_curl($url, $post = 0, $referer = 1, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
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
                curl_setopt($ch, CURLOPT_REFERER, 'http://h5.qzone.qq.com/mqzone/index');
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

    public function url_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept:*/*";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    private function getGTK($skey)
    {
        $len = strlen($skey);
        $hash = 5381;
        for ($i = 0; $i < $len; $i++) {
            $hash += (($hash << 5) & 0xffffffff) + ord($skey[$i]);
        }
        return $hash & 0x7fffffff;//计算g_tk
    }

    public function is_comment($uin, $arrs)
    {
        if ($arrs) {
            foreach ($arrs as $arr) {
                if ($arr['user']['uin'] == $uin) {
                    return false;
                    break;
                }
            }
            return true;
        } else {
            return true;
        }
    }

    public function array_str($array)
    {
        $str = '';
        if ($array[-100]) {
            $array100 = explode(' ', trim($array[-100]));
            $new100 = implode('+', $array100);
            $array[-100] = $new100;
        }
        foreach ($array as $k => $v) {
            if ($k != '-100') {
                $str = $str . $k . '=' . $v . '&';
            }
        }
        $str = urlencode($str . '-100=') . $array[-100] . '+';
        $str = str_replace(':', '%3A', $str);
        return $str;
    }

	private function getToken($url = 'https://h5.qzone.qq.com/mqzone/index', $pc = false){
		if($this->qzonetoken)return $this->qzonetoken;
		if($pc){
			$ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
		}else{
			$ua='Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1';
		}
		$json=$this->get_curl($url,0,0,$this->cookie,0,$ua);
		preg_match('/\(function\(\){ try{*.return (.*?);} catch\(e\)/i',$json,$match);
		if($data=$match[1]){
			$word=array('([]+[][(![]+[])[!+[]+!![]+!![]]+([]+{})[+!![]]+(!![]+[])[+!![]]+(!![]+[])[+[]]][([]+{})[!+[]+!![]+!![]+!![]+!![]]+([]+{})[+!![]]+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!![]+[])[+[]]+(!![]+[])[+!![]]+([][[]]+[])[+[]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(!![]+[])[+[]]+([]+{})[+!![]]+(!![]+[])[+!![]]]((!![]+[])[+!![]]+([][[]]+[])[!+[]+!![]+!![]]+(!![]+[])[+[]]+([][[]]+[])[+[]]+(!![]+[])[+!![]]+([][[]]+[])[+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]+!![]+!![]]+(![]+[])[!+[]+!![]]+([]+{})[+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+{}+[])[+!![]]+(!![]+[])[+[]]+([][[]]+[])[!+[]+!![]+!![]+!![]+!![]]+([]+{})[+!![]]+([][[]]+[])[+!![]])())'=>'https','([][[]]+[])'=>'undefined','([]+{})'=>'[object Object]','(+{}+[])'=>'NaN','(![]+[])'=>'false','(!![]+[])'=>'true');
			foreach($word as $k=>$v){
				$data=str_replace($k,"'".$v."'",$data);
			}
			$data=str_replace(array('!+[]','+!![]','+[]'),array('+1','+1','+0'),$data);
			$data=str_replace(array("+(","+'"),array(".(",".'"),$data);
			eval('$result='.$data.';');
			$this->qzonetoken=$result;
			return $this->qzonetoken;
		}else{
			$this->msg[]='获取qzonetoken失败！';
			return false;
		}
    }

    public function uploadimg($image, $image_size = array())
    {
        $url = 'http://mobile.qzone.qq.com/up/cgi-bin/upload/cgi_upload_pic_v2?g_tk=' . $this->gtk1 . '&qzonetoken=84937d74d2b778e8a7d3a47f55f1cb071c1a4d611317f8d5829dafb9b6ddf90eee3c26aac513cf951edc14bcd91acd963a__mqzone_index&g_tk=' . $this->gtk1;
        $post = 'picture=' . urlencode(base64_encode($image)) . '&base64=1&hd_height=' . $image_size[1] . '&hd_width=' . $image_size[0] . '&hd_quality=90&output_type=json&preupload=1&charset=utf-8&output_charset=utf-8&logintype=sid&Exif_CameraMaker=&Exif_CameraModel=&Exif_Time=&uin=' . $this->uin;
        $data = preg_replace("/\s/", "", $this->get_curl($url, $post, 1, $this->cookie, 0, 1));
        preg_match('/_Callback\((.*)\);/', $data, $arr);
        $data = json_decode($arr[1], true);
        if ($data && array_key_exists('filemd5', $data)) {
            $this->msg[] = '图片上传成功！';
            $post = 'output_type=json&preupload=2&md5=' . $data['filemd5'] . '&filelen=' . $data['filelen'] . '&batchid=' . time() . rand(100000, 999999) . '&currnum=0&uploadNum=1&uploadtime=' . time() . '&uploadtype=1&upload_hd=0&albumtype=7&big_style=1&op_src=15003&charset=utf-8&output_charset=utf-8&uin=' . $this->uin . '&logintype=sid&refer=shuoshuo';
            $img = preg_replace("/\s/", "", $this->get_curl($url, $post, 1, $this->cookie, 0, 1));
            preg_match('/_Callback\(\[(.*)\]\);/', $img, $arr);
            $data = json_decode($arr[1], true);
            if ($data && array_key_exists('picinfo', $data)) {
                if ($data[picinfo][albumid] != "") {
                    $this->msg[] = '图片信息获取成功！';
                    return '' . $data['picinfo']['albumid'] . ',' . $data['picinfo']['lloc'] . ',' . $data['picinfo']['sloc'] . ',' . $data['picinfo']['type'] . ',' . $data['picinfo']['height'] . ',' . $data['picinfo']['width'] . ',,,';
                } else {
                    $this->msg[] = '图片信息获取失败！';
                    return;
                }
            } else {
                $this->msg[] = '图片信息获取失败！';
                return;
            }
        } else {
            $this->msg[] = '图片上传失败！原因：' . $data['msg'];
            return;
        }
    }

    public function getSubstr($str, $leftStr, $rightStr)
    {
        $left = strpos($str, $leftStr);
        $right = strpos($str, $rightStr, $left);
        if ($left < 0 or $right < $left) return '';
        return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
    }
}

?>