<?php
include '../../common/conn.php';
include '../../common/function.php';
$com_port = !empty($_REQUEST['com_port']) ? htmlspecialchars($_REQUEST['com_port']) : '';
$com_port_index = getComPortIndex($com_port);
$com_module_id = !empty($_REQUEST['com_module_id']) ? htmlspecialchars($_REQUEST['com_module_id']) : '';
$com_module_address_id = !empty($_REQUEST['com_module_address_id']) ? htmlspecialchars($_REQUEST['com_module_address_id']) : '0';
$tablet_number = !empty($_REQUEST['tablet_number']) ? htmlspecialchars($_REQUEST['tablet_number']) : '';
echo $com_port_index.'AAAAAAAAAAA';
if($com_port_index < 0) {
    echo 'com_port error';
    exit;
}

$rs = mysql_query("select count(*) from tablet_com where com_port = '$com_port' and com_module_id='$com_module_id' and com_module_address = '$com_module_address_id' ");
$row = mysql_fetch_row($rs);
$cnt = $row[0];
if($cnt > 0) {
    $sql = "update tablet_com set tablet_number='$tablet_number', update_time = now() where com_port = '$com_port' and com_module_id='$com_module_id' and com_module_address = '$com_module_address_id' ";
    $result = @mysql_query($sql);

} else {
    $sql = "insert into tablet_com(com_port,com_module_id,com_module_address,tablet_number) values('$com_port','$com_module_id','$com_module_address_id','$tablet_number')";
    $result = @mysql_query($sql);
}

echo $com_module_address_id.'==>'.$tablet_number;
?>

