<?php
$id = intval($_REQUEST['id']);
$realname = htmlspecialchars($_REQUEST['realname']);
$tablet_number = htmlspecialchars($_REQUEST['tablet_number']);
$idcard = htmlspecialchars($_REQUEST['idcard']);

include 'common/conn.php';
include 'common/function.php';
$rs = mysql_query("select * from memorial_tablet where id = $id ");
$result = mysql_fetch_object($rs);

$rsTabletImages = mysql_query("select * from tablet_attachment where tablet_id = $id and attachment_type='image' limit 20");
$tablet_images = array();
while($rowTabletImages = mysql_fetch_object($rsTabletImages)){
    array_push($tablet_images, $rowTabletImages);
}

$rsTabletVideos = mysql_query("select * from tablet_attachment where tablet_id = $id and attachment_type='video' limit 20");
$tablet_videos = array();
while($rowTabletVideos = mysql_fetch_object($rsTabletVideos)){
    array_push($tablet_videos, $rowTabletVideos);
}
$attachment_url = $_config['attachment_url'];
$closeDelayTime = intval(getTabletConfigValue('close_delay_time'));
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>江阴神华寺祭拜信息系统</title>
    <meta name="description" content="江阴神华寺祭拜信息系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="generator" content="Codeply">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.ad-gallery.css">

	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.ad-gallery.js"></script>
    <script type="text/javascript" src="js/jquery.lbslider.js"></script>
    <style>
    html,body {
        height:100%;
        background:center no-repeat fixed url('<?php echo getBgImgUrl('background_image_detail', $_config);?>');
        background-size: cover;
        color:#444;
    }
    table,table tr th, table tr td { border:0px solid #FFFFFF; }
    table {min-height: 25px; line-height: 25px; text-align: center; border-collapse: collapse;}
    #slides {
        display:none;
    }

    /**************************** album & video *********************************/
    #gallery-container {
        width: 100%;
    }
    .ad-gallery {
        width: 750px;
        height:562px;
        margin-left: 5px;
    }

    .slider-wrap {
    position: relative;
    margin: 50px auto;
    width: 100%;
    }
    .slider {
    position: relative;
    width: 100%;
    margin: auto;
    }
    ul {
    margin: 0;
    padding: 0;
    }
    ul li {
    list-style: none;
    text-align: center;
    }
    ul li span {
    display: inline-block;
    vertical-align: middle;
    background: black;
    }
    .slider-arrow {
    position: absolute;
    top: 40px;
    width: 20px;
    height: 20px;
    background: black;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 50%;
    }
    .sa-left {
        margin-right: 40px;
        background: url(img/ad_prev.png);
        width: 30px;
        height: 30px;
    }
    .sa-right {
        background: url(img/ad_next.png);
        width: 30px;
        height: 30px;
        right: 10px;
        margin-right: 0px;
    }
    .centered {
        margin-top:5%;
    }
    /**************************** album & video *********************************/
    </style>
  </head>
  <body>
    <section class="container-fluid" id="section1">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top:-80px;">
                <h3 class="text-center">生平信息介绍</h3>
                <hr>
            </div>
        </div>
        <div class="row">
                <div class="col-md-3 centered">
                    <div><img src="<?php echo $attachment_url; echo $result -> avatar_url; ?>" class=" thumbnail center-block" style="width:100%"/></div>
                    <div  style="text-align: center;">
                    <p><?php echo $result -> realname ?></p>
                    <p><?php echo $result -> birthday ?> ~ <?php echo $result -> memorialday ?></p>
                    <p>籍贯:<?php echo $result -> native_place ?></p>
                    <p>原住址:<?php echo $result -> address ?></p>
                    </div>
                </div>
                <hr style='border-top:500px solid #eee; width:1px;height:100%;float:left;margin-left:-1px;' />
                <div class="col-md-9" style="text-align: center;">
                    <div class="media">
                        <table style="border-collapse:separate; border-spacing:0px 10px;">
                            <tr>
                                <td width="10%">生平简介</td>
                                <td width="90%">
                                    <?php echo $result -> brief ?>
                                </td>
                            </tr>
                            <tr>
                                <td>主要成就</td>
                                <td>
                                    <?php echo $result -> achievement ?>
                                </td>
                            </tr>
                            <tr>
                                <td>兴趣爱好</td>
                                <td>
                                    <?php echo $result -> interests ?>
                                </td>
                            </tr>
                            <tr>
                                <td>图片资料</td>
                                <td>
                                    <div id="gallery-container">
                                        <div id="gallery" class="ad-gallery">
                                            <div class="ad-image-wrapper">
                                            </div>
                                            <div class="ad-controls">
                                            </div>
                                            <div class="ad-nav">
                                                <div class="ad-thumbs">
                                                    <ul class="ad-thumb-list">
                                                        <?php  $index = 0;foreach($tablet_images as $tablet_image) { ?>
                                                        <li>
                                                            <a href="<?php echo $attachment_url.$tablet_image->attachment_path;?>">
                                                                <img src="<?php echo $attachment_url.$tablet_image->attachment_path.'_thumb';?>" class="image0" width="60" title="" alt="<?php echo $tablet_image->memo;?>" class="image<?php echo $index;?>">
                                                            </a>
                                                        </li>
                                                        <?php $index= $index + 1;} ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                    <div class="slider-wrap">
                        <div class="slider">
                            <ul>
                            <?php foreach($tablet_videos as $tablet_video) { ?>
                            <li>
                                <div style="float:right;width:45%">
                                    <video width="400" height="300" src="<?php echo $attachment_url.$tablet_video->attachment_path;?>" controls="controls">
                                        your browser does not support the video tag
                                    </video>
                                </div>
                            <div style="width:50%;margin-left: 50px;"><?php echo $tablet_video->memo;?></div>
                            </li>
                            <?php } ?>
                            </ul>
                        </div>

                        <a href="#" class="slider-arrow sa-left"></a> <a href="#" class="slider-arrow sa-right"></a>
                    </div>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="media">
                    <p class="text-center">

                    </p>
                    <form action="result.php" method="post">
                    <p class="text-center">
                        <span id="tip" style="color:yellow;"></span>
                        <br>
			<select name="closeDelayTime" id="closeDelayTime" style="width:80px;height:60px;background-color:#B8860B;boder-color:#B8860B;">
    			  <?php 
				for($index = 1; $index < 30; $index ++) {
                $indexTime = $index * 60 * 1000;
				if($closeDelayTime == $index) {
					echo "<option value='$indexTime' selected='selected'>$index 分钟</option>";
				} else {
					echo "<option value='$indexTime'>$index 分钟</option>";
				}
			  } ?>
			  
			</select>
                        <a href="#" data-value="0" id="lighten-href" data-id="<?php echo $result -> id ?>" class="btn btn-blue btn-lg btn-huge lato"><span id="light-text">亮灯</a>
                        <input type="hidden" name="realname" value="<?php echo $realname; ?>"/>
                        <input type="hidden" name="tablet_number" value="<?php echo $tablet_number; ?>"/>
                        <input type="hidden" name="idcard" value="<?php echo $idcard; ?>"/>
                        <input type="submit" value="返回" class="btn btn-blue btn-lg btn-huge lato"/>
                    </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function() {
    var galleries = $('.ad-gallery').adGallery();
    galleries[0].settings.display_next_and_prev = true;
    galleries[0].next_link.find("div").show();// modify by chbrobin add
    galleries[0].prev_link.find("div").show();// modify by chbrobin add

    $('#switch-effect').change(
        function() {
            galleries[0].settings.effect = $(this).val();
            return false;
        }
    );
    $('#toggle-slideshow').click(
        function() {
            galleries[0].slideshow.toggle();
            return false;
        }
    );
    $('#toggle-description').click(
        function() {
            if(!galleries[0].settings.description_wrapper) {
                galleries[0].settings.description_wrapper = $('#descriptions');
            } else {
                galleries[0].settings.description_wrapper = false;
            }
            return false;
        }
    );

    jQuery('.slider').lbSlider({
        leftBtn: '.sa-left',
        rightBtn: '.sa-right',
        visible: 1,
        autoPlay: false,
        autoPlayDelay: 5
    });

	$("#lighten-href").click(function() {
	    var id = $("#lighten-href").attr('data-id');
        var closeDeplayTime = $("#closeDelayTime").val();
		$.post("lighten.php",{flag:'on',id: id,closeDelayTime:closeDeplayTime},function(result){
            if (result.error = 0){
                $("#tip").html('');
                $("#tip").hide();
            } else {
                $("#tip").html(result.message);
                $("#tip").show();
                $("#tip").fadeOut(3000);
            }
		},'json');
		return false;
	});
});
</script>
</body>
</html>