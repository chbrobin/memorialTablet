<?php
	include '../../common/conn.php';
    $configType = $_REQUEST['configType'];
    $bgType = !empty($_REQUEST['bgType']) ? $_REQUEST['bgType'] : '';
    $bgpage = !empty($_REQUEST['bgpage']) ? htmlspecialchars($_REQUEST['bgpage']) : 'index';

    if($configType == 'bgimg') {
        if($bgType == 'upload') {
            //包含一个文件上传类
            include "../common/fileupload.class.php";
            //无限制时长
            set_time_limit(0);
            upload_bgimg('background_image_index');
            upload_bgimg('background_image_search');
            upload_bgimg('background_image_result');
            upload_bgimg('background_image_detail');
        } else if($bgType == 'select') {
            $configs = $_POST["config"];
            foreach($configs as $key=>$value) {
                update_config($key, $value);
            }
        }
        header("Location:bgconfig.php?bgType=$bgType&bgpage=$bgpage&successMsg=配置更新成功");
    } else if($configType == 'sys' || $configType == 'param') {
        $configs = $_POST["config"];
        foreach($configs as $key=>$value) {
            update_config($key, $value);
        }
        header("Location:index.php?configType=$configType&successMsg=配置更新成功");
    }

    function upload_bgimg($imgKey) {
        $up = new fileupload;
        //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
        $up -> set("isfixname", true);
        $up -> set("fixfilename", $imgKey);
        // 上传头像
        $up -> set("path", "../../../data/attachment/bgimg/");
        $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
        $up -> set("maxsize", 5 * 1024 * 1024); // 1M
        if($up -> upload($imgKey)) {
            $img_name = $up->getFileName();
            $img_url = "bgimg/$img_name";
            update_config($imgKey, $img_url);
        } else {
            if($up -> getErrorNum() != 4) {
                header("Location:bgconfig.php?configType=bgimg&errorMsg=".$up -> getErrorMsg());
                exit;
            }
        }
        $img_url = empty($img_url) ? '' : $img_url;
        return $img_url;
    }

    function update_config($key, $value) {
        $rs = mysql_query("select count(*) from tablet_config where config_key = '$key' ");
        $row = mysql_fetch_row($rs);
        $cnt = $row[0];
        if($cnt > 0) {
            $sql = "update tablet_config set config_value='$value', update_time = now() where config_key = '$key'";
            $result = @mysql_query($sql);

        } else {
            $sql = "insert into tablet_config(config_key,config_value) values('$key','$value')";
            $result = @mysql_query($sql);
        }
        return $result;
    }
?>