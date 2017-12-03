<?php
include 'config.php';

$conn = @mysql_connect($_config['db']['dbhost'],$_config['db']['dbuser'],$_config['db']['dbpwd']);
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}

mysql_select_db('memorial_tablet', $conn);
mysql_query("set names 'utf8'");

?>