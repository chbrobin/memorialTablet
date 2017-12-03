<?php
include '../common/conn.php';
session_start();
$userid = $_SESSION['userid'];
$newpass = htmlspecialchars($_REQUEST['newpass']);
$newpass = md5($newpass);
// 更新数据库
$sql = "update admin_user set password='$newpass' where id= $userid ";
$result = @mysql_query($sql);

echo $_REQUEST['newpass'];
?>