<?php
	include 'common/conn.php';
    include 'common/function.php';
	$realname = htmlspecialchars($_REQUEST['realname']);
	$tablet_number = htmlspecialchars($_REQUEST['tablet_number']);
	$idcard = htmlspecialchars($_REQUEST['idcard']);
	$wheresql = "";
	if($realname != "") {
		$wheresql = "$wheresql and realname = '$realname' ";
	}
	if($tablet_number != "") {
		$wheresql = "$wheresql and tablet_number = '$tablet_number' ";
	}
	if($idcard != "") {
		$wheresql = "$wheresql and idcard = '$idcard' ";
	}

	if($wheresql != "") {
	    $wheresql =" 1=1 $wheresql";
	} else {
        $wheresql =" 1=2 ";
	}

	$rs = mysql_query("select * from memorial_tablet where $wheresql ");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$searchParam = "realname=$realname&tablet_number=$tablet_number&idcard=$idcard";
	$attachment_url = $_config['attachment_url'];
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
              background:center no-repeat fixed url('<?php echo getBgImgUrl('background_image_result', $_config);?>');
              background-size: cover;
              color:#444;
              font-size:25px;
          }
          .media p {
              
          }
      </style>
  </head>
  <body>
    
<section class="container-fluid"  id="section1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">牌位选择确认</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container">
		<?php foreach ($items as $obj) { ?>
        <div class="media">
                <p style="text-align: center;">
                    <a href="detail.php?id=<?php echo $obj -> id; echo "&$searchParam"; ?>"><img src="<?php echo $attachment_url; echo $obj -> avatar_url; ?>" class="img-responsive thumbnail center-block " width="150" height="100"></a><br/>
                    <a href="detail.php?id=<?php echo $obj -> id; echo "&$searchParam"; ?>"><?php echo $obj -> realname; ?></a>
                </p>
        </div>
        <?php } ?>
		<div class="media">
                <p>
                    <a href="search.php<?php echo "?$searchParam"; ?>" class="btn btn-blue btn-lg btn-huge lato center-block" style="width: 100px;" data-toggle="modal" data-target="#myModal">返回</a>
                </p>
        </div>
    </div>
</section>

  </body>
</html>