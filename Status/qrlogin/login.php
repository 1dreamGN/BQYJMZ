<?php
error_reporting(0);
header('Content-type: application/json');
class qq_qrlogin{
    public function login_sig(){
        
        $var1 = 'http://xui.ptlogin2.qq.com/cgi-bin/xlogin?proxy_url=http%3A//qzs.qq.com/qzone/v6/portal/proxy.html&daid=5&pt_qzone_sig=1&hide_title_bar=1&low_login=0&qlogin_auto_login=1&no_verifyimg=1&link_target=blank&appid=549000912&style=22&target=self&s_url=http%3A//qzs.qq.com/qzone/v5/loginsucc.html?para=izone&pt_qr_app=手机QQ空间&pt_qr_link=http%3A//z.qzone.com/download.html&self_regurl=http%3A//qzs.qq.com/qzone/v6/reg/index.html&pt_qr_help_link=http%3A//z.qzone.com/download.html';

        $var2 = $this -> get_curl($var1, 0, 1, 0, 1);
        preg_match('/pt_login_sig=(.*?);/', $var2, $var5);

        return $var5[1];
    }
    public function getqrpic(){
        
        $var7 = 'http://ptlogin2.qq.com/ptqrshow?appid=549000912&e=2&l=M&s=3&d=72&v=4&t=0.5409099' . time() . '&daid=5';

        $var8 = $this -> get_curl($var7, 0, 0, 0, 1, 0, 0, 1);

        $var8['header'];

        preg_match('/qrsig=(.*?);/', $var8['header'], $var12);

        if($var13 = $var12[1])exit('{"saveOK":0,"qrsig":"' . $var13 . '","data":"' . base64_encode($var8['body']) . '"}');
        else exit('{"saveOK":1,"msg":"二维码获取失败"}');
    }
    public function qqlogin(){
        
        $var17 = empty($_GET['qrsig'])?exit('{"saveOK":-1,"msg":"qrsig不能为空"}'):$_GET['qrsig'];
        $var18 = $this -> login_sig();
        $var19 = 'http://ptlogin2.qq.com/ptqrlogin?u1=http%3A%2F%2Fqzs.qq.com%2Fqzone%2Fv5%2Floginsucc.html%3Fpara%3Dizone&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-0-' . time() . '7886&js_ver=10034&js_type=1&login_sig=' . $var18 . '&pt_uistyle=32&aid=549000912&daid=5&pt_qzone_sig=1&';
        $var21 = $this -> get_curl($var19, 0, 0, 'qrsig=' . $var17 . '; ', 1);
        if(preg_match("/ptuiCB\('(.*?)'\);/", $var21, $var25)){
            $var26 = explode("','", str_replace("', '", "','", $var25[1]));
            if($var26[0] == 0){
                preg_match('/Set-Cookie: u_(.*?)=/', $var21, $var30);
                $var30 = $var30[1];
                preg_match('/skey=@(.{9});/', $var21, $var34);
                $var35 = $this -> get_curl($var26[2], 0, 0, 0, 1);
                if($var35){
                    preg_match('/p_skey=(.*?);/', $var35, $var39);
                    $var40 = $var39[1];
                }
                if($var40){
                    exit('ptuiCB("0","' . $var30 . '","' . $var44 . '","@' . $var34[1] . '","' . $var40 . '","' . $var47 . '","' . urlencode($var26[5]) . '");');
                }else{
                    exit('ptuiCB("6","' . $var30 . '","登录成功，获取相关信息失败！' . $var26[2] . '");');
                }
            }elseif($var26[0] == 65){
                exit('ptuiCB("1","' . $var30 . '","二维码已失效。");');
            }elseif($var26[0] == 66){
                exit('ptuiCB("2","' . $var30 . '","二维码未失效。");');
            }elseif($var26[0] == 67){
                exit('ptuiCB("3","' . $var30 . '","正在验证二维码。");');
            }else{
                exit('ptuiCB("6","' . $var30 . '","' . str_replace('"', "'", $var26[4]) . '");');
            }
        }else{
            exit('{"saveOK":6,"msg":"' . $var21 . '"}');

        }
    }
    private function get_curl($var0, $var1 = 0, $var2 = 0, $var3 = 0, $var4 = 0, $var5 = 0, $var6 = 0, $var7 = 0){
        
        $var60 = curl_init();
        curl_setopt($var60, CURLOPT_URL, $var0);

        $var62[] = 'Accept:application/json';

        $var62[] = 'Accept-Encoding:gzip,deflate,sdch';
        $var62[] = 'Accept-Language:zh-CN,zh;q=0.8';
        $var62[] = 'Connection:close';

        curl_setopt($var60, CURLOPT_HTTPHEADER, $var62);

        if($var1){
            curl_setopt($var60, CURLOPT_POST, 1);
            curl_setopt($var60, CURLOPT_POSTFIELDS, $var1);
        }
        if($var4){
            curl_setopt($var60, CURLOPT_HEADER, TRUE);
        }
        if($var3){
            curl_setopt($var60, CURLOPT_COOKIE, $var3);
        }
        if($var2){
            curl_setopt($var60, CURLOPT_REFERER, 'http://ptlogin2.qq.com/');
        }
        if($var5){
            curl_setopt($var60, CURLOPT_USERAGENT, $var5);
        }else{
            curl_setopt($var60, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
        }
        if($var6){
            curl_setopt($var60, CURLOPT_NOBODY, 1);
        }
        curl_setopt($var60, CURLOPT_ENCODING, 'gzip');
        curl_setopt($var60, CURLOPT_RETURNTRANSFER, 1);
        $var78 = curl_exec($var60);
        if($var7){
            $var80 = curl_getinfo($var60, CURLINFO_HEADER_SIZE);
            $var4 = substr($var78, 0, $var80);
            $var84 = substr($var78, $var80);
            $var78 = array();
            $var78['header'] = $var4;
            $var78['body'] = $var84;
        }
        curl_close($var60);
        return $var78;

    }
}
$login = new qq_qrlogin();
if($_GET['do'] == 'qqlogin'){
    $login -> qqlogin();
}
if($_GET['do'] == 'getqrpic'){
    $login -> getqrpic();
}