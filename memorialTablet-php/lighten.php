<?php
	include 'common/conn.php';
	include 'common/function.php';

    $id = intval($_REQUEST['id']);
    $flag = $_REQUEST['flag'];

    $rs = mysql_query("select mt.id, mt.realname, tc.com_port_id, tc.com_module_id, tc.com_module_address from memorial_tablet mt
                       left join tablet_com tc on mt.tablet_number = tc.tablet_number
                       where mt.id = $id ");
    $obj = mysql_fetch_object($rs);
    if($obj) {
        $comPortId = intval($obj -> com_port_id);
        $comModuleId = $obj -> com_module_id;
        $comModuleAddress = $obj -> com_module_address;
        $realname = $obj -> realname;
    }

    $baudRate = intval(getTabletConfigValue('baud_rate'));

    $closeDelayTime = intval($_REQUEST['closeDelayTime']);
	

    $com_ports = getTabletConfigValue('com_ports');
    if($com_ports) {
        $com_port_items = explode("|", $com_ports);
    } else {
        $com_port_items = array();
    }

    $comPort = getComPortByComPortId($comPortId);
    $controlResult = lightControl($_config['com_soa_host'],$comPort, $baudRate, $comModuleId, $comModuleAddress, $flag, $closeDelayTime);
    addOperateLog(0, 1, $id, $realname, $controlResult['message']);
    echo json_encode($controlResult);

?>