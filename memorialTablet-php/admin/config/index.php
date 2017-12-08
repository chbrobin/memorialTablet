<?php
	include '../../common/conn.php';
	include '../../common/function.php';

	$configType = !empty($_REQUEST['configType']) ? htmlspecialchars($_REQUEST['configType']) : 'sys';

	$rs = mysql_query("select * from tablet_config");
	$result = array();
	while($row = mysql_fetch_object($rs)){
	    $key = $row -> config_key;
		$result[$key] = $row -> config_value;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>牌位数据管理</title>
	<link rel="stylesheet" type="text/css" href="../script/easyui.css">
	<link rel="stylesheet" type="text/css" href="../script/icon.css">
	<link rel="stylesheet" type="text/css" href="../script/color.css">
	<link rel="stylesheet" type="text/css" href="../script/demo.css">
	<script type="text/javascript" src="../script/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="../script/jquery.easyui.min.js"></script>
    <style>
     li {float:left;list-style:none;
    </style>
</head>
<body>
	<div style="width:800px;padding:10px 20px" closed="false" buttons="#dlg-buttons">
		<div class="ftitle">
			<?php if($configType == 'param') { echo '参数配置'; } else if($configType == 'sys') { echo '系统配置'; } ?>
		</div>
		<form id="fm" method="post" action="update.php?configType=<?php echo $configType ?>" enctype="multipart/form-data">
			<?php if($configType == 'param') { ?>
			<div class="fitem">
				<label>亮灯时长:</label>
				<input type="text" class="easyui-textbox" name="config[close_delay_time]" value="<?php echo !empty($result['close_delay_time']) ? $result['close_delay_time'] : ''; ?>"/>(分钟)
			</div>
			<div class="fitem">
				<label>最大视频数:</label>
				<input type="text" class="easyui-textbox" name="config[max_attachment_video_size]" value="<?php echo !empty($result['max_attachment_video_size']) ? $result['max_attachment_video_size'] : ''; ?>"/>
			</div>
			<div class="fitem">
				<label>最大图片数:</label>
				<input type="text" class="easyui-textbox" name="config[max_attachment_image_size]" value="<?php echo !empty($result['max_attachment_image_size']) ? $result['max_attachment_image_size'] : ''; ?>"/>
			</div>
			<?php } ?>

			<?php if($configType == 'sys') { ?>
			<div class="fitem">
				<label>波特率:</label>
				<input type="text" class="easyui-textbox" name="config[baud_rate]" value="<?php echo !empty($result['baud_rate']) ? $result['baud_rate'] : ''; ?>"/>
			</div>
			<div class="fitem">
				<label>COM端口:</label>
				<input type="text" class="easyui-textbox" name="config[com_ports]" value="<?php echo !empty($result['com_ports']) ? $result['com_ports'] : ''; ?>"/>(格式如 COM1|COM2|COM3)
			</div>
			<?php } ?>

			<?php
			if(!empty($_REQUEST['successMsg'])) {
				echo "<span style=\"color:green;\">".$_REQUEST['successMsg']."</span>";
			}
			?>
            <div class="fitem">
                <input type="submit" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px" value="保存"/>
            </div>
		</form>
	</div>


	<style type="text/css">
    		#fm{
    			margin:0;
    			padding:10px 30px;
    		}
    		.ftitle{
    			font-size:14px;
    			font-weight:bold;
    			padding:5px 0;
    			margin-bottom:10px;
    			border-bottom:1px solid #ccc;
    		}
    		.fitem{
    			margin-bottom:5px;
    		}
    		.fitem label{
    			display:inline-block;
    			width:80px;
    		}
    		.fitem input{
    			width:160px;
    		}
    	</style>
</body>
</html>