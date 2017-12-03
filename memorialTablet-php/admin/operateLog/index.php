<?php
	include '../common/checklogin.php';
	include '../../common/config.php';

	$object_id = !empty($_REQUEST['object_id']) ? intval($_REQUEST['object_id']) : '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>操作日志</title>
	<link rel="stylesheet" type="text/css" href="../script/easyui.css">
	<link rel="stylesheet" type="text/css" href="../script/icon.css">
	<link rel="stylesheet" type="text/css" href="../script/color.css">
	<link rel="stylesheet" type="text/css" href="../script/demo.css">
	<script type="text/javascript" src="../script/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="../script/jquery.easyui.min.js"></script>
</head>
<body>
	<form action="index.php">
	操作对像ID：<input type="text" name="id" value="<?php echo $object_id; ?>" style="width:50px;"/>
	<input type="submit" value="查询" id="search_button"/>
	</form>
	</p>
	<table id="dg" title="日志列表" class="easyui-datagrid" style="width:100%;height:620px;"
			url="get.php?<?php echo "object_id=$object_id"?>"
			toolbar="#toolbar" pagination="true" pageSize="20"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="object_info" width="50">日志对象</th>
				<th field="memo" width="50">日志内容</th>
				<th field="create_time" width="50">日期</th>
			</tr>
		</thead>
	</table>
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