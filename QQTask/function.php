<?php
function get_count($table, $where = '1=1', $key = '*', $exe)
{
    global $db, $prefix;
    $stmt = $db->prepare("select count({$key}) as count from {$prefix}{$table} where {$where}");
    $stmt->execute($exe);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    return $count;
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
function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $head = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $header[] = "Accept:application/json";
    $header[] = "Accept-Encoding:gzip,deflate,sdch";
    $header[] = "Accept-Language:zh-CN,zh;q=0.8";
    $header[] = "Connection:keep-alive";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($head) {
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        if ($referer == 1) {
            curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
    }
    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    $ret = mb_convert_encoding($ret, "UTF-8", "UTF-8");
    return $ret;
}

function run_once($row, $timeout, $ctimeout)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $row['url']);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $ctimeout);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_NOBODY, 1);
    curl_setopt($curl, CURLOPT_NOSIGNAL, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($curl);
    curl_close($curl);
}

function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function curl_run($url)
{
    global $conf;
    $ch = curl_init();
    $urlarr = parse_url($url);
    if ($conf['localcron'] == 1 && $urlarr['host'] == $_SERVER['HTTP_HOST']) {
        $url = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', 'http://127.0.0.1:80/', $url);
        $url = str_replace('https://' . $_SERVER['HTTP_HOST'] . '/', 'https://127.0.0.1:443/', $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: ' . $_SERVER['HTTP_HOST']));
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_NOSIGNAL, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    curl_close($ch);
    return true;
}

function duo_curl($urls)
{
    $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36';
    $queue = curl_multi_init();
    $map = array();
    foreach ($urls as $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
        curl_multi_add_handle($queue, $ch);
        $map[(string)$ch] = $url;
    }
    $responses = array();
    do {
        while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM) ;
        if ($code != CURLM_OK) {
            break;
        }
        while ($done = curl_multi_info_read($queue)) {
            $info = curl_getinfo($done['handle']);
            $error = curl_error($done['handle']);
            $results = curl_multi_getcontent($done['handle']);
            $responses[$map[(string)$done['handle']]] = compact('info', 'error', 'results');
            curl_multi_remove_handle($queue, $done['handle']);
            curl_close($done['handle']);
        }
        if ($active > 0) {
            curl_multi_select($queue, 0.5);
        }
    } while ($active);
    curl_multi_close($queue);
    return $responses;
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

function get_con($con = 0)
{
    $row = file('../Status/data/1.txt');
    shuffle($row);
    if ($con) {
        $arr = explode('|', $con);
        shuffle($arr);
        $con = $arr[0];
        return str_replace(array('[时间]', '[语录]', '[表情]'), array(date("Y-m-d H:i:s"), $row[0], '[em]e' . rand(100, 204) . '[/em]'), $con);
    } else {
        return $row[0];
    }
}

function dojob()
{
    $fp = fsockopen($_SERVER["HTTP_HOST"], $_SERVER['SERVER_PORT']);
    $out = "GET {$_SERVER['PHP_SELF']}?key={$_GET['key']} HTTP/1.0" . PHP_EOL;
    $out .= "Host: {$_SERVER['HTTP_HOST']}" . PHP_EOL;
    $out .= "Connection: Close" . PHP_EOL . PHP_EOL;
    fputs($fp, $out);
    fclose($fp);
}
?>