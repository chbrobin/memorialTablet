<?php
include '../../common/conn.php';
include '../../common/function.php';
$com_port = !empty($_REQUEST['com_port']) ? htmlspecialchars($_REQUEST['com_port']) : '';
$com_module_id = !empty($_REQUEST['com_module_id']) ? htmlspecialchars($_REQUEST['com_module_id']) : '';
$com_module_address_id = !empty($_REQUEST['com_module_address_id']) ? htmlspecialchars($_REQUEST['com_module_address_id']) : '0';
$interval_time = !empty($_REQUEST['interval_time']) ? htmlspecialchars($_REQUEST['interval_time']) : '';
$lighten_type = !empty($_REQUEST['lighten_type']) ? htmlspecialchars($_REQUEST['lighten_type']) : '';
$close_delay_time = !empty($_REQUEST['close_delay_time']) ? htmlspecialchars($_REQUEST['close_delay_time']) : '';
$baud_rate = intval(getTabletConfigValue('baud_rate'));
if($lighten_type == 'on' || $lighten_type == 'onoff') {
    $flag = 'on';
    $close_delay_time = 0;
} else if($lighten_type == 'off') {
    $flag = 'off';
}
$start = intval($_REQUEST['start']);
$end = !empty($_REQUEST['end']) ? intval($_REQUEST['end']) : $start;
if($start > $end) {
    $controlResult = array();
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['message'] = "调试结束";
    echo json_encode($controlResult);
    exit;
}

$controlResult = lightControl($_config['com_soa_host'],$com_port, $baud_rate, $com_module_id, $com_module_address_id, $flag, $close_delay_time);

if($start == $end) {
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['message'] = $controlResult['message']."<br/>################################# 调试结束】#################################";
    echo json_encode($controlResult);
    exit;
}
$next = $start + 1;
$controlResult['jscode'] = "reloadPage($next)";
$controlResult['start'] = $start;
$com_port_id = getComPortIdByComPort($com_port);
$tablet_number = getTabletNumberByComInfo($com_port_id, $com_module_id, $com_module_address_id);
$controlResult['message'] = "牌位号:$tablet_number"."==>".$controlResult['message'];
$controlResult['exec_flag'] = 1;
echo json_encode($controlResult);
?>

