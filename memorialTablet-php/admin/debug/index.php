﻿<?php
include '../common/checklogin.php';
include '../../common/conn.php';
include '../../common/function.php';

$com_ports = getTabletConfigValue('com_ports');
if($com_ports) {
    $com_port_items = explode("|", $com_ports);
} else {
    $com_port_items = array();
}

$debug_type = empty($_REQUEST['debug_type']) ? 'com': $_REQUEST['debug_type'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>江阴神华寺信息系统后台</title>
    <title>牌位数据管理</title>
    <link rel="stylesheet" type="text/css" href="../script/easyui.css">
    <link rel="stylesheet" type="text/css" href="../script/demo.css">
    <script type="text/javascript" src="../script/jquery-1.6.min.js"></script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:100px;
        }
        .fitem input{
            width:160px;
        }
        .fitem .input-radio{
            width:10px;
        }
    </style>
</head>
<body class="easyui-layout" style="overflow-y: hidden"  scroll="no">
<div class="easyui-dialog" style="width:800px;height:600px;padding:10px 20px;" closed="true" buttons="#dlg-buttons-tablet">
    <form id="form1" action="index.php">
        <div class="fitem">
            <h1>
            <?php if($debug_type == 'tablet') {?>
               牌位号核对
            <?php } else if($debug_type == 'com') { ?>
                COM灯控
            <?php } ?>
            </h1>
        </div>

        <div class="fitem">
            <label>COM端口：</label>
            <select name="com_port">
                <?php
                foreach($com_port_items as $com_port_item) {
                    echo "<option value='$com_port_item'>$com_port_item</option>";
                }
                ?>
            </select>
        </div>
        <div class="fitem">
            <label>COM模块ID：</label>
            <input id="com_module_id" name="com_module_id" type="text"/>
        </div>

        <?php if($debug_type == 'com') {?>
        <div class="fitem">
            <label>COM模块地址：</label>
            <input id="com_module_address_id_start" type="text" value="0" style="width:50px;"/>~<input id="com_module_address_id_end" type="text" value="31" style="width:50px;"/>(0~31)
        </div>
        <?php } ?>

        <div class="fitem">
            <label>间隔时间：</label>
            <input id="interval_time" type="text" value="500"/>(毫秒)
        </div>
        <div class="fitem">
            <label>操作类型：</label>
            开灯 <input type="radio" name="lighten_type" value="on" class="input-radio" checked="checked"/>&nbsp;&nbsp;&nbsp;&nbsp;
            关灯 <input type="radio" name="lighten_type" value="off" class="input-radio"/>&nbsp;&nbsp;&nbsp;&nbsp;
            开灯后关灯 <input type="radio" name="lighten_type" value="onoff" class="input-radio"/>
        </div>
        <div class="fitem">
            <label>关灯间隔：</label>
            <input name="close_delay_time" value="500"/>(分钟)
        </div>

        <?php if($debug_type == 'tablet') {?>
	    <div class="fitem">
            <label>牌位号核对：</label>
            <input id="com_module_address_id_start" type="text" value="0" style="width:50px;"/>
            <input id="com_module_address_id_end" type="hidden" value="" style="width:50px;"/>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="start()" style="width:90px" id="start_link_fx">灯控</a>
            <input id="tablet_number" name="tablet_number" type="text"  style="width:50px;"/>
	        <input type="button" value="保存" id="save_template_number" />
	        <span id="tablet_number_tip" style="color:red"></span>
        </div>
        <?php } ?>

        <div class="fitem">
            <span id="tip"></span><br/>
            <?php if($debug_type == 'com') {?>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="start()" style="width:90px" id="start_link">开始</a>
            <?php } ?>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="goon()" style="width:90px;display:none;" id="goon_link">继续</a>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="pause()" style="width:90px;display:none;" id="pause_link">暂停</a>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="clearlog()" style="width:90px;" id="clearlog_link">请空日志</a>
        </div>
        <span id="result_span"></span>
    </form>
</div>
<div id="result"></div>
<script type="text/javascript">
    var exeFlag = true;
    var currentIndex = -1;
    function clearlog(){
        $("#result_span").html("");
    }
    function printTest(data) {
        $("#result_span").append("运行结果： " + data.start + "==>" + data.message + "</br>");
    }
    function goon() {
        exeFlag = true;
        reloadPage(currentIndex + 1);
        $("#pause_link").show();
        $("#start_link").hide();
        $("#goon_link").hide();
    }
    function start() {
        var com_module_id = $("#com_module_id").val();
        if(com_module_id == '') {
            $("#tip").show();
            $("#tip").html('请输入COM模块ID');
            $("#tip").css('color','red');
            $("#tip").fadeOut(5000);
            return;
        }

        currentIndex = $("#com_module_address_id_start").val();
        if(currentIndex == '' || currentIndex == -1) {
            $("#tip").show();
            $("#tip").html('请填写COM模块地址');
            $("#tip").css('color','red');
            $("#tip").fadeOut(2000);
            return;
        }

        var interval_time = $("#interval_time").val();
        if(interval_time == '' || parseInt(interval_time) < 0) {
            $("#tip").show();
            $("#tip").html('请输入大于100毫秒间隔时间');
            $("#tip").css('color','red');
            $("#tip").fadeOut(5000);
            return;
        }

        exeFlag = true;
        $("#pause_link").show();
        $("#start_link").hide();
        $("#goon_link").hide();
        reloadPage(currentIndex);
    }

    function pause() {
        exeFlag = false;
        $("#goon_link").show();
        $("#pause_link").hide();
        $("#start_link").hide();
    }
    function reloadPage(start) {
        var end = $("#com_module_address_id_end").val();
        var interval_time = parseInt($("#interval_time").val());
        $.ajax({
            url: 'debug.php?com_module_address_id=' + start + '&start='+ start + '&end='+end+'&' + $('#form1').serialize(),
            type: 'GET',
            async: true,
            cache: false,
            contentType: false,
            dataType: 'json',
            success: function (returndata) {
                printTest(returndata);
                if (!isNaN(interval_time)) {
                    $(this).delay(interval_time).queue(function() {
                        if (returndata.exec_flag == 1) {
                            currentIndex = returndata.start;
                            if (exeFlag) {
                                $.globalEval(returndata.jscode);
                            }
                        } else {
                            $("#start_link").show();
                            $("#goon_link").hide();
                            $("#pause_link").hide();
                        }
                    });
                }
            }
        });
    }


$("#save_template_number").click(function() {
if($('#tablet_number').val() == '') {
$('#tablet_number_tip').html('tablet_number empty');
return;
}
        var start = $("#com_module_address_id_start").val();
$.ajax({
            url: 'save_tablet_number.php?com_module_address_id=' + start + '&' + $('#form1').serialize(),
            type: 'GET',
            async: true,
            cache: false,
            contentType: false,
success: function (returndata) {
$('#tablet_number').val('D');
$('#tablet_number_tip').html('');
$('#tablet_number_tip').html(returndata);
	
}

});
});
</script>
</body>
</html>
