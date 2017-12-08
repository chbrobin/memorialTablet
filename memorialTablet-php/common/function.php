<?php
function addOperateLog($operator_id,$operate_type,$object_id,$object_info,$memo) {
    $sql = "insert into operate_log(operator_id, operate_type, object_id, object_info, memo) values ('$operator_id', '$operate_type', '$object_id','$object_info','$memo')";
    $result = @mysql_query($sql);
    return $result;
}

function getTabletConfigValue($key) {
    $rs = mysql_query("SELECT config_value FROM tablet_config WHERE config_key = '$key'");
    $obj = mysql_fetch_object($rs);
    return $obj ? $obj -> config_value : "";
}

function getComPortIndex($com_port) {
    $com_ports = getTabletConfigValue('com_ports');
    if($com_ports) {
        $com_port_items = explode("|", $com_ports);
    } else {
        $com_port_items = array();
    }
    for($i = 0 ; $i < sizeof($com_port_items); $i ++) {
        if($com_port_items[$i] == $com_port) {
            return $i + 1;
        }
    }
    return -1;
}

function getComPortByComPortId($comPortId) {
    $com_ports = getTabletConfigValue('com_ports');
    if($com_ports) {
        $com_port_items = explode("|", $com_ports);
    } else {
        $com_port_items = array();
    }

    $comPortIndex = $comPortId -1;
    if($comPortIndex < 0 || $comPortIndex > sizeof($com_port_items)) {
        return "UNKNOW_COM";
    }
    $comPort = $com_port_items[$comPortIndex];
    return $comPort;
}

function getBgImgUrl($key,$_config) {
    $rs = mysql_query("SELECT config_value, update_time FROM tablet_config WHERE config_key = '$key'");
    $obj = mysql_fetch_object($rs);
    $_t = date("YmdHis" ,strtotime( $obj -> update_time));
    $attachment_url = $_config['attachment_url'];
    $background_image_value = getTabletConfigValue($key);
    $bg_url = $attachment_url.$background_image_value."?_t=$_t";
    return $bg_url;
}

function send_post($url, $post_data) {
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array('method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60
        )
    );
    $context = stream_context_create($options);
    return @file_get_contents($url, false, $context);
}

function lightControl($cms_soa_host, $comPort, $baudRate, $comModuleId, $comModuleAddress, $flag, $closeDelayTime) {
    $post_data = array(
        'comPort' => $comPort,
        'baudRate' => $baudRate,
        'comModuleId' => $comModuleId,
        'comModuleAddress' => $comModuleAddress,
        'flag'=> $flag,
        'closeDelayTime' => $closeDelayTime
    );

    $result = array();
    $post_result_str = send_post($cms_soa_host, $post_data);
    if($post_result_str) {
        $post_result_obj = json_decode($post_result_str);
        if($post_result_obj -> code == 0) {
            $result['error'] = 0;
            $result['message'] = '亮灯成功';
        } else {
            $result['error'] = 1;
            $result['message'] = $post_result_obj -> message;
        }
    } else {
        $result['error'] = 1;
        $result['message'] = '串口通信服务无法连接！';
    }
    return $result;
}
?>