<?php  
	include '../common/conn.php';
	
	echo $_config['db']['dbhost'];
	
    if(isset($_POST["action"]) && $_POST["action"] == "submit")  
    {  
        $user = $_POST["username"];  
        $psw = $_POST["password"];  
        if($user == "" || $psw == "")  
        {  
            echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";  
        }  
        else  
        {
            $password = md5($psw);
            $sql = "select id, username,password from admin_user where username = '$_POST[username]' and password = '$password'";
            $result = mysql_query($sql);  
            $num = mysql_num_rows($result);  
            if($num)  
            {  
                $row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中  
				session_start();  
				$_SESSION['userid'] = $row[0];  
				$_SESSION['username'] = $row[1];  
				header("Location:index.php");
                

            }  
            else  
            {  
                echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";
            }  
        }  
    }  
    else  
    {  
        echo "<script>alert('提交未成功！'); history.go(-1);</script>";
    }  
  
?>  