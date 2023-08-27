<?php
function send_mail($from, $host, $Port, $pwd, $nick, $to, $sub, $msg)
{
    include_once 'smtp.class.php';
    $From = $from;
    $Host = $host;
    $Port = $Port;
    $SMTPAuth = 1;
    $Username = $from;
    $Password = $pwd;
    $Nickname = $nick;
    $SSL = false;
    $mail = new SMTP($Host, $Port, $SMTPAuth, $Username, $Password, $SSL);
    $mail->att = array();
    if ($mail->send($to, $From, $sub, $msg, $Nickname)) {
        return true;
    } else {
        return $mail->log;
    }
}

function subdate($time)
{
    $b = substr($time, 0, 10);
    $c = date('Y-m-d');
    if ($b == $c) {
        return '1';
    }
}

function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr, $left);
    if ($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    $ckey_length = 4;
    $key = md5($key ? $key : 'qq1340176819');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function get_sz($len = 12)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str);
    $randstr = '';
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr;
}

function C($name = null, $value = null, $default = null)
{
    static $_config = array();
    if (empty($name)) {
        return $_config;
    }
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value)) return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return null;
        }
        $name = explode('.', $name);
        $name[0] = strtoupper($name[0]);
        if (is_null($value)) return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return null;
    }
    if (is_array($name)) {
        $_config = array_merge($_config, array_change_key_case($name, CASE_UPPER));
        return null;
    }
    return null;
}

function safestr($str)
{
    if (!get_magic_quotes_gpc()) {
        return addslashes($str);
    } else {
        return $str;
    }
}

function getip()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else {
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    $ips = explode(', ', $ip);
    return $ip;
}

function get_ip_city($ip)
{
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=';
    @($city = file_get_contents($url . $ip));
    $city = str_replace(array('var remote_ip_info = ', '};'), array('', '}'), $city);
    $city = json_decode($city, true);
    if ($city['city']) {
        $location = $city['city'];
    } else {
        $location = $city['province'];
    }
    if ($location) {
        return $location;
    } else {
        return;
    }
}

function getspider($useragent = '')
{
    if (!$useragent) {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
    }
    $useragent = strtolower($useragent);
    if (strpos($useragent, 'baiduspider') !== false) {
        return 'baiduspider';
    }
    if (strpos($useragent, 'googlebot') !== false) {
        return 'googlebot';
    }
    if (strpos($useragent, 'soso') !== false) {
        return 'soso';
    }
    if (strpos($useragent, 'bing') !== false) {
        return 'bing';
    }
    if (strpos($useragent, 'yahoo') !== false) {
        return 'yahoo';
    }
    if (strpos($useragent, 'sohu-search') !== false) {
        return 'Sohubot';
    }
    if (strpos($useragent, 'sogou') !== false) {
        return 'sogou';
    }
    if (strpos($useragent, 'youdaobot') !== false) {
        return 'YoudaoBot';
    }
    if (strpos($useragent, 'yodaobot') !== false) {
        return 'YodaoBot';
    }
    if (strpos($useragent, 'robozilla') !== false) {
        return 'Robozilla';
    }
    if (strpos($useragent, 'msnbot') !== false) {
        return 'msnbot';
    }
    if (strpos($useragent, 'lycos') !== false) {
        return 'Lycos';
    }
    if (strpos($useragent, 'ia_archiver') !== false || strpos($useragent, 'iaarchiver') !== false) {
        return 'alexa';
    }
    if (strpos($useragent, 'archive.org_bot') !== false) {
        return 'Archive';
    }
    if (strpos($useragent, 'robozilla') !== false) {
        return 'Robozilla';
    }
    if (strpos($useragent, 'sitebot') !== false) {
        return 'SiteBot';
    }
    if (strpos($useragent, 'mj12bot') !== false) {
        return 'MJ12bot';
    }
    if (strpos($useragent, 'gosospider') !== false) {
        return 'gosospider';
    }
    if (strpos($useragent, 'gigabot') !== false) {
        return 'Gigabot';
    }
    if (strpos($useragent, 'yrspider') !== false) {
        return 'YRSpider';
    }
    if (strpos($useragent, 'gigabot') !== false) {
        return 'Gigabot';
    }
    if (strpos($useragent, 'jikespider') !== false) {
        return 'jikespider';
    }
    if (strpos($useragent, 'addsugarspiderbot') !== false) {
        return 'AddSugarSpiderBot';
    }
    if (strpos($useragent, 'testspider') !== false) {
        return 'TestSpider';
    }
    if (strpos($useragent, 'etaospider') !== false) {
        return 'EtaoSpider';
    }
    if (strpos($useragent, 'wangidspider') !== false) {
        return 'WangIDSpider';
    }
    if (strpos($useragent, 'foxspider') !== false) {
        return 'FoxSpider';
    }
    if (strpos($useragent, 'docomo') !== false) {
        return 'DoCoMo';
    }
    if (strpos($useragent, 'yandexbot') !== false) {
        return 'YandexBot';
    }
    if (strpos($useragent, 'ezooms') !== false) {
        return 'Ezooms';
    }
    if (strpos($useragent, 'sinaweibobot') !== false) {
        return 'SinaWeiboBot';
    }
    if (strpos($useragent, 'catchbot') !== false) {
        return 'CatchBot';
    }
    if (strpos($useragent, 'surveybot') !== false) {
        return 'SurveyBot';
    }
    if (strpos($useragent, 'dotbot') !== false) {
        return 'DotBot';
    }
    if (strpos($useragent, 'purebot') !== false) {
        return 'Purebot';
    }
    if (strpos($useragent, 'ccbot') !== false) {
        return 'CCBot';
    }
    if (strpos($useragent, 'mlbot') !== false) {
        return 'MLBot';
    }
    if (strpos($useragent, 'adsbot-google') !== false) {
        return 'AdsBot-Google';
    }
    if (strpos($useragent, 'ahrefsbot') !== false) {
        return 'AhrefsBot';
    }
    if (strpos($useragent, 'spbot') !== false) {
        return 'spbot';
    }
    if (strpos($useragent, 'augustbot') !== false) {
        return 'AugustBot';
    }
    return false;
}

function get_count($table, $where = '1=1', $key = '*', $exe)
{
    global $db, $prefix;
    $stmt = $db->prepare("select count({$key}) as count from {$prefix}{$table} where {$where}");
    $stmt->execute($exe);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    return $count;
}

function get_results($d, $exe)
{
    global $db;
    $stmt = $db->prepare($d);
    $stmt->execute($exe);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_fetch($d)
{
    global $db;
    $rowss = $db->query($d);
    $row = $rowss->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_isvip($vip, $end)
{
    if ($vip) {
        if (strtotime($end) > time()) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function get_gxzt($do)
{
    if ($do == 0 && $do != "") {
        return '更新成功';
    } elseif ($do == -3) {
        return '更新失败';
    } elseif ($do == -2) {
        return '需要验证码';
    } else {
        return '';
    }
}

function get_fzgg()
{
    global $db;
    $mysql = (require "database.php");
    $dbhost = $mysql['DB_HOST'] . ':' . $mysql['DB_PORT'];
    $dbuser = $mysql['DB_USER'];
    $dbpassword = $mysql['DB_PWD'];
    $dbmysql = $mysql['DB_NAME'];
    if ($con = mysql_connect($dbhost, $dbuser, $dbpassword)) {
        mysql_select_db($dbmysql, $con);
    } else {
        exit('数据库链接失败！');
    }
    mysql_query("set names utf8");
    $domain = $_SERVER['HTTP_HOST'];
    $results = mysql_query("select * from bqyj_separate where urls='{$domain}' limit 1");
    if ($separate = mysql_fetch_array($results)) {
        $tableqz = $separate['prefix'] . "_";
    } else {
        $tableqz = $mysql['DB_PREFIX'];
    }
    $result = mysql_query("select * from {$tableqz}webconfigs");
    while ($row = mysql_fetch_array($result)) {
        $config[$row['vkey']] = $row['value'];
    }
    return $config['web_separate_gg'];
}

function getxz($do, $did = 0)
{
    if ($do == 1) {
        if ($did) {
            return 'btn-success';
        } else {
            return '触屏版';
        }
    } elseif ($do == 2) {
        if ($did) {
            return 'btn-success';
        } else {
            return 'P&nbsp;C版';
        }
    } else {
        if ($did) {
            return 'btn-default';
        } else {
            return '已关闭';
        }
    }
}

function getzt($do)
{
    if ($do == 2) {
        return "Pc版";
    } elseif ($do == 0) {
        return "关闭";
    } else {
        return "触屏";
    }
}

function getzts($do)
{
    if ($do == 0) {
        return true;
    } else {
        return false;
    }
}

function zhtime($time = '')
{
    if ($time) {
        return str_replace(array('2016-', '0000-'), array('', ''), $time);
    } else {
        return '0000-00-0 00:00:00';
    }
}

function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
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

function getqd($do, $did = 0)
{
    if ($do) {
        if ($did) {
            return 'btn btn-success';
        } else {
            return '已开启';
        }
    } else {
        if ($did) {
            return 'btn btn-danger';
        } else {
            return '未开启';
        }
    }
}

function getGTK($skey)
{
    $len = strlen($skey);
    $hash = 5381;
    for ($i = 0; $i < $len; $i++) {
        $hash += (($hash << 5) & 0xffffffff) + ord($skey[$i]);
    }
    return $hash & 0x7fffffff;
}

function get_qqnick($uin)
{
    if ($data = file_get_contents("http://users.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?get_nick=1&uins=" . $uin)) {
        $data = str_replace(array('portraitCallBack(', ')'), array('', ''), $data);
        $data = mb_convert_encoding($data, "UTF-8", "GBK");
        $row = json_decode($data, true);
        return $row[$uin][6];
    }
}

function get_index($do)
{
    if ($do == '0' or !$do) {
        return 'other/index/index_tgv2.php';
    } elseif ($do == '1') {
        return 'other/index/index_qqmz.php';
    } else {
        return $do;
    }
}

function checkfunc($f, $m = false)
{
    if (function_exists($f)) {
        return 'fa fa-fw fa-check mr';
    } else {
        if ($m == false) {
            return 'fa fa-fw fa-times mr';
        } else {
            return 'fa fa-fw fa-times mr';
        }
    }
}

function checkclass($f, $m = false)
{
    if (class_exists($f)) {
        return 'fa fa-fw fa-check mr';
    } else {
        if ($m == false) {
            return 'fa fa-fw fa-times mr';
        } else {
            return 'fa fa-fw fa-times mr';
        }
    }
}

?>