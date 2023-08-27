<?php
$crontype = 1;
include_once "conn.php";
$qid = is_numeric($_GET['qid']) ? $_GET['qid'] : exit('No Qid!');
$result = $db->query("SELECT * FROM {$prefix}qqs where qid='{$qid}' limit 1");
if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if ($row['skeyzt'] == 0) {
        $uin = $row['qq'];
        $mynick = get_qqnick($uin);
        $sid = $row['sid'];
        $skey = $row['skey'];
        $p_skey = $row['p_skey'];
        $pookie = $row['pookie'];
        $p_skey = $row['p_skey'];
        include_once "qzone.class.php";
        $qzone = new qzone($uin, $sid, $skey, $p_skey, $pookie);
        $shuos = $qzone->getSpecialnew();
        include_once "autoclass.php";
    } else {
        $ret = '状态已失效';
    }
} else {
    $ret = 'Qid不正常！';
}
foreach ($shuos as $shuo) {
    $uin = $shuo['userinfo']['user']['uin'];
    $name = $shuo['userinfo']['user']['nickname'];
    $title = $shuo['original']['cell_summary']['summary'];
    $time = $shuo['original']['cell_comm']['time'];
    $data .= '<div class="list-group-item bb">
                            <div class="media-box">
                                <div class="pull-left">
                                    <img src="http://q4.qlogo.cn/headimg_dl?dst_uin=' . $uin . '&spec=100" alt="Image"
                                         class="media-box-object img-circle thumb44 img-thumbnail">
                                </div>
                                <div class="media-box-body clearfix">
                                    <strong class="media-box-heading text-primary" data-toggle="tooltip"
                                            data-original-title="' . $name . '">
                                        ' . $name . '
                                    </strong>
                                    <p class="mb0">
                                        <small><i class="fa fa-clock-o pr-sm"></i> ' . date('Y-m-d H:i:s', $time) . ' 赞了我
                                        </small>
                                    </p>
									<p>' . $mynick . '' . $title . '<p>
                                </div>
                            </div>
                        </div>';
}
$arr = array('ret' => $data);
exit(json_encode($arr));
?>