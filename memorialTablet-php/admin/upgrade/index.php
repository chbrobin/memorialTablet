<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统升级</title>
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
        系统升级
    </div>
    <form id="fm" method="post" action="upload.php" enctype="multipart/form-data">
        <div class="fitem">
            <label>java jar文件:</label>
            <input type="file" name="java_jar"/>
        </div>
        <div class="fitem">
            <label>wwwroot zip文件:</label>
            <input type="file" name="wwwroot_zip"/>
        </div>
        <?php
        if(!empty($_REQUEST['successMsg'])) {
            echo "<span style=\"color:green;\">".$_REQUEST['successMsg']."</span>";
        }
        if(!empty($_REQUEST['errorMsg'])) {
            echo "<span style=\"color:red;\">".$_REQUEST['errorMsg']."</span>";
        }
        ?>
        <div class="fitem">
            <input type="submit" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px" value="升级"/>
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
        width:120px;
    }
    .fitem input{
        width:160px;
    }
</style>
</body>
</html>
