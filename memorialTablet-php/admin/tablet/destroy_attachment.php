<?php

$id = intval($_REQUEST['id']);

include '../../common/conn.php';

$sql = "delete from tablet_attachment where id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>