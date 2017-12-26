<?php
include 'function.php';
include "../common/fileupload.class.php";

// 上传jar包
$up = new fileupload;
//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
$up -> set("israndname", false);
$up -> set("path", "../../../bin/java/lib/");
$up -> set("allowtype", array("jar"));
$up -> set("maxsize", 1 * 1024 * 1024); // 500M
if (!empty($_FILES["java_jar"])) {
    $java_jar_name = $_FILES["java_jar"]["name"];
    if($java_jar_name != "memorial-tablet-1.0-SNAPSHOT.jar") {
        // $errorMsg = "非法jar包";
        // header("Location:index.php?errorMsg=$errorMsg");
        // exit;
    }
    if ($up->upload("java_jar")) {
        // 升级成功
    } else {
        if ($up->getErrorNum() != 4) {
            $errorMsg = $up->getErrorMsg();
            header("Location:index.php?errorMsg=$errorMsg");
            exit;
        }
    }
}

$up = new fileupload;
//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
$up -> set("israndname", true);
$up -> set("path", "../../../data/wwwrootzip/");
$up -> set("allowtype", array("zip"));
$up -> set("maxsize", 10 * 1024 * 1024); // 500M
if (!empty($_FILES["wwwroot_zip"])) {
    $java_jar_name = $_FILES["wwwroot_zip"]["name"];
    if($java_jar_name != "wwwroot.zip") {
        $errorMsg = "非法zip包";
        header("Location:index.php?errorMsg=$errorMsg");
        exit;
    }
    if ($up->upload("wwwroot_zip")) {
        // 升级成功
        $z = new Unzip();
        $zip_file_path = "../../../data/wwwrootzip/".$up -> getFileName();
        echo $zip_file_path;
        $z->unzip($zip_file_path,'../../', false, true);
    } else {
        if ($up->getErrorNum() != 4) {
            $errorMsg = $up->getErrorMsg();
            header("Location:index.php?errorMsg=$errorMsg");
            exit;
        }
    }
}

$successMsg = "升级成功，请重启工控机";
header("Location:index.php?successMsg=$successMsg");
exit;
?>