<?php
include 'common/conn.php';
include 'common/function.php';
$realname = !empty($_REQUEST['realname']) ? htmlspecialchars($_REQUEST['realname']) : '';
$tablet_number = !empty($_REQUEST['tablet_number']) ? htmlspecialchars($_REQUEST['tablet_number']) : '';
$idcard = !empty($_REQUEST['idcard']) ? htmlspecialchars($_REQUEST['idcard']) : '';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>江阴神华寺祭拜信息系统</title>
    <meta name="description" content="江阴神华寺祭拜信息系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="generator" content="Codeply">

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
      <style>
          html,body {
              height:100%;
              background:center no-repeat fixed url('<?php echo getBgImgUrl('background_image_search', $_config);?>');
              background-size: cover;
              color:#444;
              font-size:25px;
          }
      </style>
  </head>
  <body>
    
<section class="container-fluid"  id="section1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">牌位查询</h1>
                <hr>
            </div>
        </div>
    </div>
    <form action="result.php" method="post">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <div class="media">
            <p>
                姓    名：<input type="text" class="form-control" id="realname" name="realname" value="<?php echo $realname; ?>"/>
            </p>
            <p>
                牌位号码：<input type="text" class="form-control" id="tablet_number" name="tablet_number" value="<?php echo $tablet_number; ?>"/>
            </p>
            <p>
                身 份 证：<input type="text" class="form-control" id="idcard" name="idcard" value="<?php echo $idcard; ?>"/>
            </p>
            <p>
                <a href="index.php" class="btn btn-blue btn-huge pull-right" data-toggle="modal" data-target="#myModal">返回</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" class="btn btn-blue btn-huge pull-right" data-toggle="modal" data-target="#myModal" style="margin-right: 20px;" value="查找"/>

                <input type="reset" class="btn btn-blue btn-huge pull-right" data-toggle="modal" data-target="#myModal" style="margin-right: 20px;" value="重置"/>
            </p>
        </div>
    </div>
    </form>
</section>

  </body>
</html>