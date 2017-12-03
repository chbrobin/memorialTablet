<?php

$tablet_id = htmlspecialchars($_REQUEST['tablet_id']);
$attachment_type = htmlspecialchars($_REQUEST['attachment_type']);

include '../../common/conn.php';
include '../../common/function.php';
//包含一个文件上传类
include "../common/fileupload.class.php";

$rs = mysql_query("select count(*) from tablet_attachment where attachment_type = '$attachment_type' and tablet_id = $tablet_id ");
$row = mysql_fetch_row($rs);
$attachment_count = $row[0];

// 上传视频
$up = new fileupload;
//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
$up -> set("israndname", true);
if($attachment_type == 'video') {
    $maxVideoCount = intval(getTabletConfigValue('max_attachment_video_size'));
    if($attachment_count >= $maxVideoCount) {
        echo json_encode(array('errorMsg' => '最多上传'.$maxVideoCount.'个视频'));
        exit;
    }
    $up -> set("path", "../../../data/attachment/tablet/$tablet_id/video");
    $up -> set("allowtype", array("mp4"));
    $up -> set("maxsize", 500 * 1024 * 1024); // 500M
    if (!empty($_FILES["video_url"])) {
        if ($up->upload("video_url")) {
            $video_names = $up->getFileName();
            foreach ($video_names as $video_name) {
                $video_url = "tablet/$tablet_id/video/$video_name";
                $sql = "insert into tablet_attachment(tablet_id, attachment_type, attachment_path) values('$tablet_id', 'video', '$video_url')";
                $result = @mysql_query($sql);
            }
        } else {
            if ($up->getErrorNum() != 4) {
                echo json_encode(array('errorMsg' => $up->getErrorMsg()));
                exit;
            }
        }
    }
} else if($attachment_type == 'image') {
    $maxImageCount = intval(getTabletConfigValue('max_attachment_image_size'));
    if($attachment_count >= $maxImageCount) {
        echo json_encode(array('errorMsg' => '最多上传'.$maxImageCount.'个图片'));
        exit;
    }

    $up -> set("path", "../../../data/attachment/tablet/$tablet_id/image");
    $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
    $up -> set("maxsize", 1 * 1024 * 1024); // 1M
    $up -> set("mkthumbnailflag", true);
    if (!empty($_FILES["image_url"])) {
        if ($up->upload("image_url")) {
            $image_names = $up->getFileName();
            foreach ($image_names as $image_name) {
                $image_url = "tablet/$tablet_id/image/$image_name";
                $sql = "insert into tablet_attachment(tablet_id, attachment_type, attachment_path) values('$tablet_id', 'image', '$image_url')";
                $result = @mysql_query($sql);
            }
        } else {
            if ($up->getErrorNum() != 4) {
                echo json_encode(array('errorMsg' => $up->getErrorMsg()));
                exit;
            }
        }
    }
}
echo json_encode(array(
    'tablet_id' => $tablet_id,
));
?>