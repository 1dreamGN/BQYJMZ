<?php
//群成员列表下载
if (isset($_GET['download'])) {
    $group = $_GET['group'];
    $data = $_POST['data'];
    $file_name = 'output_' . $group . '_' . date("Y-m-d") . '__' . time() . '.txt';
    $file_size = strlen($data);
    header("Content-Description: File Transfer");
    header("Content-Type:application/force-download");
    header("Content-Length: {$file_size}");
    header("Content-Disposition:attachment; filename={$file_name}");
    exit($data);
}