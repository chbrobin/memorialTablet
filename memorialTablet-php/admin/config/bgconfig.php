<?php
	include '../../common/conn.php';
	include '../../common/function.php';

	$bgType = !empty($_REQUEST['bgType']) ? htmlspecialchars($_REQUEST['bgType']) : 'select';
	$bgpage = !empty($_REQUEST['bgpage']) ? htmlspecialchars($_REQUEST['bgpage']) : 'index';

	$rs = mysql_query("select * from tablet_config");
	$result = array();
	while($row = mysql_fetch_object($rs)){
	    $key = $row -> config_key;
		$result[$key] = $row -> config_value;
	}
    $attachment_url = $_config['attachment_url'];
    $maxpage = 41;
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
</head>
<body>
    <?php if($bgType == 'select') { ?>
	<div style="width:100%;padding:10px 20px" closed="false" buttons="#dlg-buttons">
		<div class="ftitle"><strong>选择背景</strong>&nbsp;<a href="?bgType=upload">上传背景</a></div>

		<form id="fm" method="post" action="update.php?configType=bgimg&bgType=select&bgpage=<?php echo $bgpage; ?>" enctype="multipart/form-data">
		<?php if($bgpage != 'index') { ?> <a href="?configType=bgimg&bgType=select&bgpage=index">首页</a><?php } else { ?> <strong>首页</strong> <?php } ?>&nbsp;
		<?php if($bgpage != 'search') { ?> <a href="?configType=bgimg&bgType=select&bgpage=search">搜索页</a><?php } else { ?> <strong>搜索页</strong> <?php } ?>&nbsp;
		<?php if($bgpage != 'result') { ?> <a href="?configType=bgimg&bgType=select&bgpage=result">搜索结果页</a><?php } else { ?> <strong>搜索结果页</strong> <?php } ?>&nbsp;
		<?php if($bgpage != 'detail') { ?> <a href="?configType=bgimg&bgType=select&bgpage=detail">详情页</a><?php } else { ?> <strong>详情页</strong> <?php } ?>&nbsp;
		<input type="submit" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px" value="保存"/>
        <?php
            if(!empty($_REQUEST['errorMsg'])) {
                echo "<span style=\"color:red;\">".$_REQUEST['errorMsg']."</span>";
            }
        ?>
        <?php
            if(!empty($_REQUEST['successMsg'])) {
                echo "<span style=\"color:green;\">".$_REQUEST['successMsg']."</span>";
            }
        ?>
        <?php if($bgpage == 'index') { ?>
            <a href="../../index.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
        <?php } else if($bgpage == 'search') { ?>
            <a href="../../search.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
        <?php } else if($bgpage == 'result') { ?>
            <a href="../../result.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
        <?php } else if($bgpage == 'detail') { ?>
            <a href="../../detail.php?id=1&realname=&tablet_number=&idcard=" target="_blank">预览</a>
         <?php } ?>
		<br/>
		    <div style="margin-left:-40px;margin-top:10px;">
		    <?php if($bgpage == 'index') { ?>
			<div>
                <?php for($index=1; $index<= $maxpage; $index++) {
                 $indexbg = 'bgimg/bg'.$index.'.jpg';
                 $indexthumb = 'bgimg/thumb/bg'.$index.'.jpg';
                ?>
                <div style="float:left;margin-left:10px;">
                    <img src="<?php echo $attachment_url.$indexthumb;?>" height="100px;"/><br/>
                    <input type="radio" name="config[background_image_index]" value="<?php echo $indexbg;?>"
                    <?php if(!empty($result['background_image_index']) && $result['background_image_index'] == $indexbg) { echo 'checked="checked"';} ?>/>
                </div>
                <?php } ?>
			</div>

			<?php } else if($bgpage == 'search') { ?>
			<div>
                <?php
                for($index=1; $index<=$maxpage; $index++) {
                $indexbg = 'bgimg/bg'.$index.'.jpg';
                $indexthumb = 'bgimg/thumb/bg'.$index.'.jpg';
                ?>
                <div style="float:left;margin-left:10px;">
                    <img src="<?php echo $attachment_url.$indexthumb;?>" height="100px;"/><br/>
                    <input type="radio" name="config[background_image_search]" value="<?php echo $indexbg;?>"
                    <?php if(!empty($result['background_image_search']) && $result['background_image_search'] == $indexbg) { echo 'checked="checked"';} ?>/>
                </div>
                <?php } ?>
			</div>
			<?php } else if($bgpage == 'result') { ?>
			<div>
                <?php for($index=1; $index<=$maxpage; $index++) {
                $indexbg = 'bgimg/bg'.$index.'.jpg';
                $indexthumb = 'bgimg/thumb/bg'.$index.'.jpg';
                ?>
                <div style="float:left;margin-left:10px;">
                    <img src="<?php echo $attachment_url.$indexthumb;?>" height="100px;"/><br/>
                    <input type="radio" name="config[background_image_result]" value="<?php echo $indexbg;?>"
                    <?php if(!empty($result['background_image_result']) && $result['background_image_result'] == $indexbg) { echo 'checked="checked"';} ?>/>
                </div>
                <?php } ?>
			</div>
			<?php } else if($bgpage == 'detail') { ?>
			<div>
                <?php for($index=1; $index<=$maxpage; $index++) {
                $indexbg = 'bgimg/bg'.$index.'.jpg';
                $indexthumb = 'bgimg/thumb/bg'.$index.'.jpg';
                ?>
                <div style="float:left;margin-left:10px;">
                    <img src="<?php echo $attachment_url.$indexthumb;?>" height="100px;"/><br/>
                    <input type="radio" name="config[background_image_detail]" value="<?php echo $indexbg;?>"
                    <?php if(!empty($result['background_image_detail']) && $result['background_image_detail'] == $indexbg) { echo 'checked="checked"';} ?>/>
                </div>
                <?php } ?>
			</div>
			 <?php } ?>
			 </div>
		</form>
	</div>
	<?php } ?>

	<?php if($bgType == 'upload') { ?>
	<div style="width:800px;padding:10px 20px" closed="false" buttons="#dlg-buttons">
		<div class="ftitle"><a href="?bgType=select">选择背景</a>&nbsp;<strong>上传背景</strong></div>
		<form id="fm" method="post" action="update.php?configType=bgimg&bgType=upload" enctype="multipart/form-data">
			<span style="color:red;">请上传gif,png,jpg,jpeg图片格式，图片大小控制在3M以内，<a href="http://optimizilla.com/" target="_blank">在线优化</a></span>
			<div class="fitem">
				<label>首页:</label>
				<input type="file" name="background_image_index"/>
				<img src="<?php echo getBgImgUrl('background_image_index', $_config);?>" height="100px;"/>
				<a href="../../index.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
			</div>
			<div class="fitem">
				<label>搜索页:</label>
				<input type="file" name="background_image_search"/>
				<img src="<?php echo getBgImgUrl('background_image_search', $_config);?>" height="100px;"/>
				<a href="../../search.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
			</div>
			<div class="fitem">
				<label>搜索结果页:</label>
				<input type="file" name="background_image_result"/>
				<img src="<?php echo getBgImgUrl('background_image_result', $_config);?>" height="100px;"/>
				<a href="../../result.php?realname=&tablet_number=&idcard=" target="_blank">预览</a>
			</div>
			<div class="fitem">
				<label>详情页:</label>
				<input type="file" name="background_image_detail"/>
				<img src="<?php echo getBgImgUrl('background_image_detail', $_config);?>" height="100px;"/>
				<a href="../../detail.php?id=1&realname=&tablet_number=&idcard=" target="_blank">预览</a>
			</div>
			<?php
				if(!empty($_REQUEST['errorMsg'])) {
					echo "<span style=\"color:red;\">".$_REQUEST['errorMsg']."</span>";
				}
			?>
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
	<?php } ?>

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