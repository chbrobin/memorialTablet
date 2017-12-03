<?php
include 'common/conn.php';


$action = empty($_REQUEST['action'])? "list" : $_REQUEST['action'];

if($action == 'save') {
    $url = $_REQUEST['url'];
    $urlInfoArr = explode("?txPlayerId=", $url);
    $base_url = $urlInfoArr[0];
    $rs = mysql_query("select count(*) from url where base_url ='$base_url' ");
    $row = mysql_fetch_row($rs);
    if(intval($row[0]) > 0) {
        $sql = "update url set url='$url', update_time = now() where base_url = '$base_url'";
        $result = @mysql_query($sql);
    } else {
        $sql = "insert into url(base_url,url) values('$base_url','$url')";
        $result = @mysql_query($sql);
    }
} else {
    $rs = mysql_query("select id, url from url order by update_time desc limit 10");
    $items = array();
    while($row = mysql_fetch_object($rs)){
        array_push($items, $row);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>直播</title>
</head>
<body>
<br/>
<?php foreach($items as $item) {
    echo "$item->url"."<br/>";
} ?>



