<?php
$crontype = 1;
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$func = $_GET['func'] ? $_GET['func'] : "zan";
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if ($row['skeyzt'] == 0) {
        $uin = $row['qq'];
        $sid = $row['sid'];
        $skey = $row['skey'];
        $p_skey = $row['p_skey'];
        $pookie = $row['pookie'];
        $p_skey = $row['p_skey'];
        include_once "qzone.class.php";
        $qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
        if ($func == "zan") {
            $qzone->like(2);
        }
        foreach ($qzone->msg as $result) {
            $ret .= $result . '<br/>';
        }
        include_once "autoclass.php";
    } else {
        $ret = '状态已失效';
    }
} else {
    $ret = 'Qid不正常！';
}
exit('{"ret":"' . $ret . '"}');
?>