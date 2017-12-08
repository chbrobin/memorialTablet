<?php
    include '../../common/conn.php';
	include '../common/checklogin.php';
	include '../../common/config.php';
	include '../../common/function.php';

	$id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
	$realname = !empty($_REQUEST['realname']) ? htmlspecialchars($_REQUEST['realname']) : '';
	$tablet_number = !empty($_REQUEST['tablet_number']) ? htmlspecialchars($_REQUEST['tablet_number']) : '';
	$idcard = !empty($_REQUEST['idcard']) ? htmlspecialchars($_REQUEST['idcard']) : '';
	$com_port = !empty($_REQUEST['com_port']) ? htmlspecialchars($_REQUEST['com_port']) : '';
	$com_module_id = !empty($_REQUEST['com_module_id']) ? htmlspecialchars($_REQUEST['com_module_id']) : '';
	$com_module_address_id = !empty($_REQUEST['com_module_address_id']) ? htmlspecialchars($_REQUEST['com_module_address_id']) : '';

	$attachment_url = $_config['attachment_url'];
    $com_ports = getTabletConfigValue('com_ports');
    if($com_ports) {
        $com_port_items = explode("|", $com_ports);
    } else {
        $com_port_items = array();
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
			width:60px;
		}
		.fitem input{
			width:160px;
		}
	</style>
</head>
<body>
	<form action="index.php">
		牌位ID：<input type="text" name="id" value="<?php echo $id; ?>" style="width:50px;"/>
		姓名：<input type="text" name="realname" value="<?php echo $realname; ?>" style="width:100px;"/>
		牌位号：<input type="text" name="tablet_number" value="<?php echo $tablet_number; ?>" style="width:100px;"/>
		身份证：<input type="text" name="idcard" value="<?php echo $idcard; ?>" style="width:150px;"/>
		<input type="submit" value="查询" id="search_button"/>
	</form>
	</p>
	<table id="dg" title="牌位列表" class="easyui-datagrid" style="width:100%;height:620px;"
			url="get.php?<?php echo "id=$id&realname=$realname&tablet_number=$tablet_number&idcard=$idcard&com_port=$com_port&com_module_id=$com_module_id&com_module_address_id=$com_module_address_id"?>"
			toolbar="#toolbar" pagination="true" pageSize="20"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
			    <th field="id" width="50">牌位ID</th>
				<th field="realname" width="50">姓名</th>
				<th field="idcard" width="50">身份证</th>
				<th field="tablet_number" width="50">牌位号</th>
				<th field="birthday" width="50">生日</th>
				<th field="memorialday" width="50">祭日</th>
				<th field="native_place" width="50">籍贯</th>
				<th field="address" width="50">原住址</th>
					<th field="com_info" width="50">端口		模块		地址</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar" style="display:none">
		<!-- a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newTablet()">添加牌位</a -->
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editTablet()">基本信息管理</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editVideo()">视频管理</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editImage()">相册管理</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="viewTablet()">预览牌位</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="lighten('on')">亮灯</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="lighten('off')">关灯</a>
	</div>

	<div id="dlgAttachmentMemo" class="easyui-dialog" style="width:500px;height:200px;padding:10px 20px;display:none;" closed="true" buttons="#dlg-buttons-attachment-memo">
		<form id="fmAttachmentMemo" method="post" enctype="multipart/form-data" novalidate>
			<input id="memo_attachment_id" name="id" type="hidden"/>
			<textarea id="memo_attachment_text" name="memo"  style="width:430px;height:95px;" class="easyui-validatebox" data-options="validType:'length[0,200]',invalidMessage:'不超过200字'">
			</textarea>
		</form>
	</div>
	<div id="dlg-buttons-attachment-memo" style="display:none">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAttachmentMemo()" style="width:90px">保存</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgAttachmentMemo').dialog('close');" style="width:90px">取消</a>
	</div>

	<div id="dlgTablet" class="easyui-dialog" style="width:800px;height:600px;padding:10px 20px;display:none;" closed="true" buttons="#dlg-buttons-tablet">
		<form id="fm" method="post" enctype="multipart/form-data" novalidate>
			<div class="fitem">
				<label>姓名:</label>
				<input name="realname" class="easyui-textbox" data-options="required:true,missingMessage:''">

				<label style="margin-left:60px;">身份证:</label>
                <input name="idcard" class="easyui-textbox" data-options="required:true,missingMessage:''">
			</div>
			<div class="fitem">
				<label>牌位号:</label>
				<input name="tablet_number" class="easyui-textbox" data-options="required:true,missingMessage:''">
                <label style="margin-left:60px;">生日:</label>
                <input name="birthday" class="easyui-textbox" data-options="required:true,missingMessage:''">
			</div>
			<div class="fitem">
				<label>祭日:</label>
				<input name="memorialday" class="easyui-textbox" data-options="required:true,missingMessage:''">
                <label style="margin-left:60px;">籍贯:</label>
                <input name="native_place" class="easyui-textbox" data-options="required:true,missingMessage:''">
			</div>
			<div class="fitem">
				<label>原住址:</label>
				<input name="address" class="easyui-textbox" style="width:400px;" data-options="required:true,missingMessage:''">
			</div>
			<div class="fitem">
				<label>生平简介:</label>
				<textarea name="brief" style="width:400px;height:50px;">
				</textarea>
			</div>
			<div class="fitem">
				<label>主要成就:</label>
				<textarea name="achievement" style="width:400px;height:50px;">
				</textarea>
			</div>
			<div class="fitem">
				<label>兴趣爱好:</label>
				<textarea name="interests" style="width:400px;height:50px;">
				</textarea>
			</div>
			<div class="fitem">
				<label>头像:</label>
				<input type="file" name="avatar_url"/>
			</div>
            <div class="fitem">
                <label>&nbsp;</label>
                <img id="avatar_url" width="150px"/>&nbsp;&nbsp;<span style="color:red">请上传gif、png、jpg、jpeg格式图片(1M以内)</span>
            </div>
		</form>
	</div>
	<div id="dlg-buttons-tablet" style="display:none">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveTablet()" style="width:90px">保存</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgTablet').dialog('close');" style="width:90px">取消</a>
	</div>

	<div id="dlgVideo" class="easyui-dialog" style="width:850px;height:600px;padding:10px 20px;display:none;" closed="true" buttons="#dlg-buttons-video">
		<form id="fmVideo" method="post" enctype="multipart/form-data" novalidate>
			<div class="fitem">
				<label>视频:</label>
				<input type="file" name="video_url[]"/>
				<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveVideo()" style="width:90px">上传</a>
			</div>
		</form>
		<div id="video_div" style="width:800px;">
			<div class="fitem"></div>
		</div>
	</div>
	<div id="dlg-buttons-video" style="display:none">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgVideo').dialog('close');" style="width:90px">关闭</a>
	</div>

	<div id="dlgImage" class="easyui-dialog" style="width:800px;height:600px;padding:10px 20px;display:none;" closed="true" buttons="#dlg-buttons-video">
		<form id="fmImage" method="post" enctype="multipart/form-data" novalidate>
			<div class="fitem">
				<label>图片:</label>
				<input type="file" name="image_url[]"/>
				<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveImage()" style="width:90px">上传</a>
			</div>
		</form>
		<div id="image_div" style="width:800px;">
			<div class="fitem"></div>
		</div>
	</div>
	<div id="dlg-buttons-video" style="display:none">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgImage').dialog('close');" style="width:90px">关闭</a>
	</div>
	<?php include_once ("index_script.php") ?>
</body>
</html>