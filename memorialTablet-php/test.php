<?php
include 'common/conn.php';
$rs = mysql_query("select tablet_number from tablet_com order by tablet_number asc");
$items = array();
while($row = mysql_fetch_object($rs)){
    $tablet_number = $row -> tablet_number;
    if(strlen($tablet_number) == 4) {
        $tablet_number_alias = substr($tablet_number,0,1)."0".substr($tablet_number,1);
        $sql = "update tablet_com set tablet_number_alias='$tablet_number_alias', update_time = now() where tablet_number = '$tablet_number'";
        echo $sql."<br/>";
        $result = @mysql_query($sql);
    }
}
?>
