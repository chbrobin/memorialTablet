﻿<?php
include '../../common/conn.php';
include '../../common/function.php';
$lighten_type = !empty($_REQUEST['lighten_type']) ? htmlspecialchars($_REQUEST['lighten_type']) : '';
$ids = !empty($_REQUEST['ids']) ? htmlspecialchars($_REQUEST['ids']) : '';
$start = intval($_REQUEST['start']);
$db_start = $start - 1;
$rs = mysql_query("select id, tablet_number, com_port, com_module_id, com_module_address from memorial_tablet order by tablet_number asc limit $db_start,1 ");
$obj = mysql_fetch_object($rs);
if($obj) {
    $com_port = $obj -> com_port;
    $com_module_id = $obj -> com_module_id;
    $com_module_address_id = $obj -> com_module_address;
}
$lighten_type = $_REQUEST['lighten_type'];
if($lighten_type == 'on' || $lighten_type == 'onoff') {
    $flag = 'on';
} else if($lighten_type == 'off') {
    $flag = 'off';
}
$close_delay_time = intval($_REQUEST['close_delay_time']);
$end = !empty($_REQUEST['end']) ? intval($_REQUEST['end']) : $start;
if($start > $end) {
    $controlResult = array();
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['message'] = "调试结束";
    echo json_encode($controlResult);
    exit;
}
$baud_rate = intval(getTabletConfigValue('baud_rate'));

$controlResult = lightControl($_config['com_soa_host'],$com_port, $baud_rate, $com_module_id, $com_module_address_id, $flag, $close_delay_time);

if($start == $end) {
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['id'] = $obj -> id;
    $controlResult['tablet_number'] = $obj -> tablet_number;
    $controlResult['message'] = $controlResult['message']."<br/>################################# 调试结束】#################################";
    echo json_encode($controlResult);
    exit;
}
$next = $start + 1;
$controlResult['jscode'] = "reloadPage($next)";
$controlResult['start'] = $start;
$controlResult['id'] = $obj -> id;
$controlResult['tablet_number'] = $obj -> tablet_number;
$controlResult['exec_flag'] = 1;
echo json_encode($controlResult);
?>
