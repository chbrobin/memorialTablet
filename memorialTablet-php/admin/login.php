<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link href="../css/login.css" type="text/css" rel="stylesheet" rev="stylesheet"/>
</head>
<body class="denglu02">
<form action="logincheck.php" method="post">  
	<input type="hidden" name="action" value="submit">
	<div class="dl">
		<div class="biaoti"><img src="../img/ico02.gif" /></div>
		<div class="log">
			<ul class="xuzhi02" >
				<li class="li-back">
				<img src="../img/bg03.jpg" style="width:300px;height:200px;">
				</li>
			</ul>
			  <ul class="deng02">
				<li style=" width:100%; height:60px;">
					<p style="float:left;font-size:18px; color:#666;line-height:30px; ">用户名:</p> 
					<input id="username" class="i-text" type="text" name="username" datatype="s6-18" maxlength="100">
				</li>
				<div style="clear:both;"></div>
		
				<li style=" width:100%; height:60px;"> 
					<p style="float:left;font-size:18px; color:#666;line-height:30px; ">密&nbsp;&nbsp;&nbsp;码:</p> 
					<input id="password" class="i-text" type="password" name="password" maxlength="100">
				</li>
				<div style="clear:both;"></div>
				
				<li style=" width:100%; height:60px;">
				  <button id="logonbtn" class="btn-login02" type="submit" > 
					<span>登&nbsp;&nbsp;&nbsp;&nbsp;录</span>
				  </button>
				</li>
			</ul>
			
		</div>
	</div>
</form>	
</body>
</html>
