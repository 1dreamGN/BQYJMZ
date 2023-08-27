<?php

//Code By Safe3 

//Days of high Cloud pale

function customError($errno, $errstr, $errfile, $errline)
{
    echo "<b>Error number:</b> [$errno],error on line $errline in $errfile<br />";
    die();
}


set_error_handler("customError", E_ERROR);

$getfilter = "'|(and|or|limit)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|bqyj_.+?|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

$postfilter = "\\b(and|or|limit)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|bqyj_.+?|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

$cookiefilter = "\\b(and|or|limit)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|UPDATE.+?SET|bqyj_.+?|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

//$ArrPGC=array_merge($_GET,$_POST,$_COOKIE);

function StopAttack($StrFiltKey, $StrFiltValue, $ArrFiltReq)
{
    if ($StrFiltKey != "index_logo" && $StrFiltKey != "sig" && $StrFiltKey != "PHPSESSID") {
        if (is_array($StrFiltValue)) {
            $StrFiltValue = implode($StrFiltValue);
        }
        if (preg_match("/" . $ArrFiltReq . "/is", $StrFiltValue) == 1) {
            //slog("\r\nOperation Ip: " . $_SERVER["REMOTE_ADDR"] . "\r\nOperation Time: " . strftime("%Y-%m-%d %H:%M:%S") . "\r\nOperation Page:" . $_SERVER["PHP_SELF"] . "\r\nSubmit Way: " . $_SERVER["REQUEST_METHOD"] . "\r\nSubmit parameters: " . $StrFiltKey . "\r\nSubmit Data: " . $StrFiltValue);
            print "Tips：Please do not enter illegal characters！";
            exit();
        }
        if (preg_match("/" . $ArrFiltReq . "/is", $StrFiltValue) == 1) {
            //slog("\r\nOperation Ip: " . $_SERVER["REMOTE_ADDR"] . "\r\nOperation Time: " . strftime("%Y-%m-%d %H:%M:%S") . "\r\nOperation Page:" . $_SERVER["PHP_SELF"] . "\r\nSubmit Way: " . $_SERVER["REQUEST_METHOD"] . "\r\nSubmit parameters: " . $StrFiltKey . "\r\nSubmit Data: " . $StrFiltValue);
            print "Tips：Please do not enter illegal characters！";
            exit();
        }


        if (strpos($StrFiltValue, "limit") || strpos($StrFiltValue, "or") || strpos($StrFiltValue, "and") || strpos($StrFiltValue, "update") || strpos($StrFiltValue, "set") || strpos($StrFiltValue, "bqyj_")) {
            //slog("\r\nOperation Ip: " . $_SERVER["REMOTE_ADDR"] . "\r\nOperation Time: " . strftime("%Y-%m-%d %H:%M:%S") . "\r\nOperation Page:" . $_SERVER["PHP_SELF"] . "\r\nSubmit Way: " . $_SERVER["REQUEST_METHOD"] . "\r\nSubmit parameters: " . $StrFiltKey . "\r\nSubmit Data: " . $StrFiltValue);
            print "Tips：Please do not enter illegal characters！";
            exit();
        }
    }
}

foreach ($_GET as $key => $value) {
    StopAttack($key, $value, $getfilter);
}

foreach ($_POST as $key => $value) {
    StopAttack($key, $value, $postfilter);
}

foreach ($_COOKIE as $key => $value) {
    StopAttack($key, $value, $cookiefilter);
}

function slog($logs)
{
    $toppath = $_SERVER["DOCUMENT_ROOT"] . "/log.txt";
    $Ts = fopen($toppath, "a+");
    fputs($Ts, $logs . "\r\n");
    fclose($Ts);
}

?>