<?php
include '../../common/conn.php';
include '../../common/function.php';
$lighten_type = !empty($_REQUEST['lighten_type']) ? htmlspecialchars($_REQUEST['lighten_type']) : '';
$ids = !empty($_REQUEST['ids']) ? htmlspecialchars($_REQUEST['ids']) : '';
$com_port  = !empty($_REQUEST['com_port']) ? htmlspecialchars($_REQUEST['com_port']) : '';
$start = intval($_REQUEST['start']);
$db_start = $start - 1;

$where_sql = "";
if($com_port != "") {
    $com_port_id = getComPortIdByComPort($com_port);
    $where_sql = " where com_port_id = $com_port_id ";
}

$sql = "select distinct com_port_id, com_module_id from tablet_com $where_sql order by com_port_id asc  limit $db_start,1 ";
$rs = mysql_query($sql);
$obj = mysql_fetch_object($rs);
if($obj) {
    $com_port_id = $obj -> com_port_id;
    $com_port = getComPortByComPortId($com_port_id);
    $com_module_id = $obj -> com_module_id;
} else {
    $controlResult = array();
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['com_port'] = '';
    $controlResult['com_module_id'] = '';
    $controlResult['message'] = "调试结束";
    echo json_encode($controlResult);
    exit;
}
$lighten_type = $_REQUEST['lighten_type'];
$end = !empty($_REQUEST['end']) ? intval($_REQUEST['end']) : $start;
if($start > $end) {
    $controlResult = array();
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['com_port'] = '';
    $controlResult['com_module_id'] = '';
    $controlResult['message'] = "调试结束";
    echo json_encode($controlResult);
    exit;
}
$baud_rate = intval(getTabletConfigValue('baud_rate'));

$controlResult = multiControl($_config['com_soa_host'],$com_port, $baud_rate, $com_module_id, $lighten_type);

if($start == $end) {
    $controlResult['exec_flag'] = 0;
    $controlResult['start'] = $start;
    $controlResult['com_port'] = $com_port;
    $controlResult['com_module_id'] = $obj -> com_module_id;
    $controlResult['message'] = $controlResult['message']."<br/>################################# 调试结束】#################################";
    echo json_encode($controlResult);
    exit;
}
$next = $start + 1;
$controlResult['jscode'] = "reloadPage($next)";
$controlResult['start'] = $start;
$controlResult['com_port'] = $com_port;
$controlResult['com_module_id'] = $obj -> com_module_id;
$controlResult['exec_flag'] = 1;
echo json_encode($controlResult);
?>

