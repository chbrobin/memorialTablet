<?php
	include '../../common/conn.php';
	include '../../common/function.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	$id = htmlspecialchars($_REQUEST['id']);
	$realname = htmlspecialchars($_REQUEST['realname']);
	$tablet_number = htmlspecialchars($_REQUEST['tablet_number']);
	$idcard = htmlspecialchars($_REQUEST['idcard']);
	$wheresql = "";
	if($id != "") {
        $wheresql = "$wheresql and id = '$id' ";
	}
	if($realname != "") {
		$wheresql = "$wheresql and realname = '$realname' ";
	}
	if($tablet_number != "") {
		$wheresql = "$wheresql and tablet_number = '$tablet_number' ";
	}
	if($idcard != "") {
		$wheresql = "$wheresql and idcard = '$idcard' ";
	}

	$com_ports = getTabletConfigValue('com_ports');
	if($com_ports) {
		$com_port_items = explode("|", $com_ports);
	} else {
		$com_port_items = array();
	}

	$rs = mysql_query("select count(*) from memorial_tablet where 1=1 $wheresql ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("select * from memorial_tablet where 1=1 $wheresql limit $offset,$rows");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		$comPortIndex = intval($row -> com_port) -1;
		$comPort = $com_port_items[$comPortIndex];
		$row -> com_info  = $comPort."		".$row -> com_module_id."		".$row -> com_module_address;
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>