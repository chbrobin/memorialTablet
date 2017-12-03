<?php

$id = intval($_REQUEST['id']);
$realname = htmlspecialchars($_REQUEST['realname']);
$idcard = htmlspecialchars($_REQUEST['idcard']);
$tablet_number = htmlspecialchars($_REQUEST['tablet_number']);
$birthday = htmlspecialchars($_REQUEST['birthday']);
$memorialday = htmlspecialchars($_REQUEST['memorialday']);
$native_place = htmlspecialchars($_REQUEST['native_place']);
$address = htmlspecialchars($_REQUEST['address']);
$brief = htmlspecialchars($_REQUEST['brief']);
$achievement = htmlspecialchars($_REQUEST['achievement']);
$interests = htmlspecialchars($_REQUEST['interests']);

include '../../common/conn.php';
//包含一个文件上传类
include "../common/fileupload.class.php";

//无限制时长
set_time_limit(0);

$up = new fileupload;
//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
$up -> set("israndname", true);

// 上传头像
$up -> set("path", "../../../data/attachment/tablet/$id/img");
$updateAvatarVideoUrlSql = "";
$up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
$up -> set("maxsize", 1 * 1024 * 1024); // 1M
if($up -> upload("avatar_url")) {
    $avatar_name = $up->getFileName();
    $avatar_url = "tablet/$id/img/$avatar_name";
    $updateAvatarVideoUrlSql ="$updateAvatarVideoUrlSql , avatar_url='$avatar_url'";
} else {
    if($up -> getErrorNum() != 4) {
        echo json_encode(array('errorMsg'=> $up -> getErrorMsg()));
        exit;
    }
}
$avatar_url = empty($avatar_url) ? '' : $avatar_url;

// 上传视频
$up -> set("path", "../../../data/attachment/tablet/$id/video");
$up -> set("allowtype", array("mp4"));
$up -> set("maxsize", 500 * 1024 * 1024); // 500M
if(!empty($_FILES["video_url"])) {
    if($up -> upload("video_url")) {
        $video_name = $up->getFileName();
        $video_url = "tablet/$id/video/$video_name";
        $updateAvatarVideoUrlSql ="$updateAvatarVideoUrlSql , video_url='$video_url'";
    } else {
        if($up -> getErrorNum() != 4) {
            echo json_encode(array('errorMsg'=> $up -> getErrorMsg()));
            exit;
        }
    }
}
$video_url = empty($video_url) ? '' : $video_url;

// 更新数据库
$sql = "update memorial_tablet set realname='$realname',idcard='$idcard',tablet_number='$tablet_number',birthday='$birthday',memorialday='$memorialday', native_place = '$native_place',
		address='$address', brief='$brief', achievement='$achievement', interests='$interests' $updateAvatarVideoUrlSql where id=$id";

$result = @mysql_query($sql);

if ($result){
	echo json_encode(array(
		'id' => $id,
		'realname' => $realname,
		'idcard' => $idcard,
		'tablet_number' => $tablet_number,
		'birthday' => $birthday,
		'memorialday' => $memorialday,
		'native_place' => $native_place,
		'address' => $address,
		'brief' => $brief,
		'achievement' => $achievement,
		'interests' => $interests,
		'video_url' => $video_url,
		'avatar_url' => $avatar_url
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>