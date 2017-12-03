<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	$object_id = htmlspecialchars($_REQUEST['object_id']);
	$wheresql = "";
	if($object_id != "") {
        $wheresql = "$wheresql and object_id = '$object_id' ";
	}

	include '../../common/conn.php';
	
	$rs = mysql_query("select count(*) from operate_log where 1=1 $wheresql ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("select * from operate_log where 1=1 $wheresql order by id desc limit $offset,$rows");
	
	$items = array();
	$tablet_ids = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
		array_push($tablet_ids, $row -> object_id);
	}

    /**
    $ids = join(",", array_unique($tablet_ids));
	$rs_tablet = mysql_query("select id, realname from memorial_tablet where id in ($ids)");
	$realname_arr = array();
    while($row_tablet = mysql_fetch_object($rs_tablet)){
        $object_id = $row_tablet -> id;
        $realname_arr["object_info_$object_id"] = $row_tablet -> realname;
    }

    foreach($items as $item) {
        $object_id = $item -> object_id;
        $k = "object_info_$object_id";
        $item -> object_info =  $realname_arr["$k"];
    }
    */
	$result["rows"] = $items;
	echo json_encode($result);
?>