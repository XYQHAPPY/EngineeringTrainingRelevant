<?php  
    session_start();
    //include_once("mysql.php");
    if($_POST['submit'])  
    {  
        $con = mysql_connect("localhost:3306", "root", "root");  
        mysql_query("set names 'utf-8'");  
        mysql_select_db("test", $con);  
        $name = $_POST['user'];  
        $password = $_POST['password'];  
        if($_POST["radio"] == "radio1")  
        {  
            $sql = "select * from user where name ='$name' and password ='$password'" ;  
            $resultSet = mysql_query($sql);  
            mysql_close($con);  
            if(mysql_num_rows($resultSet)>0)  
            {  
                $_SESSION["user"] =  $name;  
                if(isset($_SESSION['user']))  
                    echo "<script>location.href='user.php';</script>";  
            }  
            else  
                echo "<script>alert('登录失败！如果忘记密码请联系管理员！')</script>";  
        }  
        else if($_POST["radio"] == "radio2")  
        {  
            $sql = "select * from qingjia where name ='$name' and shenpi ='$password'" ;  
            $resultSet = mysql_query($sql);  
            mysql_close($con);  
            if(mysql_num_rows($resultSet)>0)  
            {  
                $_SESSION["admin"] =  $name;  
                if(isset($_SESSION['admin']))  
                    echo "<script>location.href='admin.php';</script>";  
            }  
            else  
                echo "<script>alert('登录失败！如果忘记密码请联系管理员！')</script>";  
        }
        else if($_POST["radio"] == "radio3")  
        {  
            $sql = "select * from administrator where name ='$name' and shenpi ='$password'" ;  
            $resultSet = mysql_query($sql);  
            mysql_close($con);  
            if(mysql_num_rows($resultSet)>0)  
            {  
                $_SESSION["admin"] =  $name;  
                if(isset($_SESSION['admin']))  
                    echo "<script>location.href='admin.php';</script>";  
            }  
            else  
                echo "<script>alert('登录失败！如果忘记密码请联系管理员！')</script>";  
        }  
          
    }  
?>  
<!doctype html>  
<html>  
<head>  
<meta charset="utf-8">  
<title>学生考勤系统</title>  
</head>  
  
<body style="text-align: center; background-color: rgba(176,235,200,1.00);">  
<form id="form1" name="form1" method="post">  
<br><br><br><br>  
    <h1 >用户登录</h1><br>  
  <p>  
    <label for="user" >  
    用户名:</label>  
    <input type="text" name="user" id="user">  
    <label for="password"><br><br>  
      密码:</label>  
     <input type="password" name="password" id="password"><br><br>  
    <input name="radio" type="radio" id="radio" value="radio1" checked="checked">  
    <label for="radio">学生 </label>  
    <input type="radio" name="radio" id="radio" value="radio2">  
    <label for="radio">教师 </label><br><br>  
    <input type="radio" name="radio" id="radio" value="radio3">  
    <label for="radio">管理员 </label><br><br> 
    <input type="submit" name="submit" id="submit" value="登录" >  
</form>  
  
<form>  
  Copyright © 2018, Xiao yongqiang  
</form>  
  
</body>  
</html>  