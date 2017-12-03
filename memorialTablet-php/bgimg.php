<?php
include "common/config.php";
include "admin/common/fileupload.class.php";

$attachment_url = $_config['attachment_url'];
$up = new fileupload;
for($index = 23; $index <= 24; $index ++) {
    $path = "../data/attachment/bgimg/bg".$index.".jpg";
    $thumb_path = "../data/attachment/bgimg/thumb/bg".$index.".jpg";
    $up->mkThumbnail($path, 147, 147, $thumb_path);
}
?>