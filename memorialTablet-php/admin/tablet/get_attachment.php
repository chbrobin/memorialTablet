<?php
include '../../common/conn.php';

if(!empty($_REQUEST['id'])) {
    $id = htmlspecialchars($_REQUEST['id']);
    $rs = mysql_query("select * from tablet_attachment where id = $id ");
    $result = mysql_fetch_object($rs);
    echo json_encode($result);
    exit;
}

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();
$tablet_id = htmlspecialchars($_REQUEST['tablet_id']);
$attachment_type = htmlspecialchars($_REQUEST['attachment_type']);

$rs = mysql_query("select count(*) from tablet_attachment where attachment_type = '$attachment_type' and tablet_id = $tablet_id ");
$row = mysql_fetch_row($rs);
$result["total"] = $row[0];
$rs = mysql_query("select * from tablet_attachment where attachment_type = '$attachment_type' and tablet_id = $tablet_id limit $offset,$rows");

$items = array();
while($row = mysql_fetch_object($rs)){
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);

?>