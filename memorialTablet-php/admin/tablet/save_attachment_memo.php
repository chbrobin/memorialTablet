<?php

$id = htmlspecialchars($_REQUEST['id']);
$memo = htmlspecialchars($_REQUEST['memo']);

include '../../common/conn.php';
include '../../common/function.php';


// 更新数据库
$sql = "update tablet_attachment set memo='$memo'where id='$id'";
$result = @mysql_query($sql);
echo json_encode(array(
    'id' => $id,
));
?>