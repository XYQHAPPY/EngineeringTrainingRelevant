<?php

    session_start();  
    //获取上课时间用于判断迟到早退  
    $con = mysql_connect("localhost:3306", "root", "root");  
    mysql_query("set names 'utf-8'");  
    mysql_select_db("test", $con);  
    $stime = mysql_query("select * from shijian where id='1'",$con);  
    $stime=mysql_fetch_assoc($stime);
    $name = $_SESSION['user'];
    $result1 = mysql_query("select * from user where name='$name'",$con);
    $row1=mysql_fetch_assoc($result1);  
    $ID = $row1["ID"];
    mysql_close($con);  
    //退出登录      flag 1退出    2修改 3签到 4签离 5请假 6查询  
    if($_GET["flag"] == 1){  
        session_unset();  
    }  
    //链接数据库  
    if(isset($_SESSION['user']))  
    {
        //echo "链接成功";
        $con = mysql_connect("localhost:3306", "root", "root");  
        mysql_query("set names 'utf-8'");  
        mysql_select_db("test", $con);  
        if(isset($_GET['page']) && (int)$_GET['page']>0)  
            $Page=$_GET['page'];  
        else      
            $Page=1;  
        $resultSet = mysql_query("select * from user",$con);  
        $RecordCount=mysql_num_rows($resultSet);  
        $PageCount =ceil($RecordCount/10);  
        $sql = "select ID,name,phone,email,chidao,zaotui,kuangke,qingjia from user";  
        $resultSet = mysql_query($sql);  
    }  
    else  
    {  
        echo "<script>location.href='index.php';</script>";  
    }  
    //修改个人信息  
    if($_GET['flag'] == 2)  
    {  
        echo "<script>location.href='xinxi.php';</script>";  
    }  
    //签到        user中qiandao   1为签到  2为签离    
    if($_GET['flag'] == 3)  
    {  
        $name = $_SESSION['user'];  
        $sql = "select qiandao from user where name='$name'";  
        $result = mysql_query($sql);  
        $row=mysql_fetch_assoc($result);   
        $qiandao = $row['qiandao'];  
        if($qiandao  == '1')  
        {  
            echo "<script>alert('您已经签到过了')</script>";  
            echo "<script>location.href='user.php';</script>";  
        }  
        mysql_query("UPDATE user SET qiandao=1 WHERE name='$name'");  
        //得到数据库的上下课时间  
        $uptime = $stime['shangke'];  
        $dowmtime = $stime['xiake'];  
        //获取当前时间  
        date_default_timezone_set('Asia/Shanghai');  
        //$time = getdate();  
        $time = date("Y-m-d H:i:s");
        echo "签到时间：".$time."<br>";
        echo "上课时间：".$uptime."<br>";
        //echo "时间戳time：".strtotime($time)."<br>";
        //echo "上课时间戳time：".strtotime($uptime)."<br>";
        //以下判断迟到事件,上课十五分钟之内  
        if(strtotime($time)-strtotime($uptime)>0&&strtotime($time)-strtotime($uptime)<15*60)
        {  
            $sql = "select chidao from user where name='$name'";  
  
            $result = mysql_query($sql);  
            $row=mysql_fetch_assoc($result);  
            $chidao = $row["chidao"];  
            $chidao++;
            echo "迟到次数：".$chidao;
            mysql_query("UPDATE user SET chidao='$chidao' WHERE name='$name'");  
            //echo "<script>location.href='user.php';</script>";  
        }  
        //以下是判断旷课事件，上课15之后还未到  
        else if(strtotime($time)-strtotime($uptime)>15*60)  
        {  
            $sql = "select kuangke from user where name='$name'";  
  
            $result = mysql_query($sql);  
            $row=mysql_fetch_assoc($result);  
            $kuangke = $row["kuangke"];  
            $kuangke++;
            echo "旷课次数：".$kuangke;
            mysql_query("UPDATE user SET kuangke='$kuangke' WHERE name='$name'");  
            //echo "<script>location.href='user.php';</script>";  
        }  
          
    }  
    //签离  
    if($_GET['flag'] == 4)  
    {  
        $name = $_SESSION['user'];  
        $sql = "select qiandao from user where name='$name'";  
        $result = mysql_query($sql);  
        $row=@mysql_fetch_assoc($result);  
        $qiandao = $row['qiandao'];  
        if($qiandao  == '0')  
        {  
            echo "<script>alert('您已经签离过了')</script>";  
            echo "<script>location.href='user.php';</script>";  
        }  
        mysql_query("UPDATE user SET qiandao=0 WHERE name='$name'"); 
        echo "<script>alert('签离成功!')</script>";
        //得到数据库的上下课时间  
        $uptime = $stime['shangke'];  
        $dowmtime = $stime['xiake'];  
        //获取当前时间  
        date_default_timezone_set('Asia/Shanghai');  
        $time = date("Y-m-d H:i:s");  
        echo "签离时间：".$time."<br>";
        echo "下课时间：".$dowmtime."<br>";
        //判断早退事件  
        if($uptime<$time&&$time<$dowmtime)  
        {  
            $sql = "select zaotui from user where name='$name'";  
  
            $result = mysql_query($sql);  
            $row=mysql_fetch_assoc($result);  
            $zaotui = $row["zaotui"];  
            $zaotui++;
            echo "早退次数：".$zaotui;
            mysql_query("UPDATE user SET zaotui='$zaotui' WHERE name='$name'");  
              
            //echo "<script>location.href='user.php';</script>";  
        }  
    }  
    //请假  
    if($_GET['flag'] == 5)  
    {  
        $_SESSION["ID"] = $ID;  
        if(isset($_SESSION['ID'])) 
            echo "<script>location.href='qingjia2/qingjia.php';</script>";  
    }  
    //请假进度  
    if($_GET['flag'] == 6)  
    {  
        $name = $_SESSION['user'];  
        $sql = "select name from qingjia where name='$name'";  
        $result = mysql_query($sql);  
        $row=@mysql_fetch_assoc($result);  
        $jindu = $row['name'];  
        if($jindu == '')  
            echo "<script>alert('用户没有请假')</script>";  
        else  
        {  
            echo "<script>alert('$jindu')</script>";  
            echo "<script>location.href='qingjia2/qingjialist.php';</script>";  
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
<h1>欢迎登入考勤系统</h1>  
<p>用户名：<a ><?php echo $_SESSION['user']?></a>  <a style="color:rgba(45,5,251,1.00)" href="user.php?flag=1">退出登录</a></p>  
<p>请选择你的操作：   
<!--flag 1退出 2修改 3签到 4签离 5请假 6查询-->  
<a href="user.php?flag=3" >签到</a>    
<a href="user.php?flag=4" >签离</a>    
<a href="user.php?flag=5" >请假</a>    
<a href="user.php?flag=6" >查询请假进度</a>    
<a href="user.php?flag=2">修改个人信息</a></p><br>  
<form id="form1" name="form1" method="post" action="chaxun.php">  
    <tr colspan="10">  
    查询:  <input type="text" name="chaxun" id="chaxun " />  
    <select name="xuanze" id="选择">  
                        <option value="name">姓名</option>  
                        <option value="phone">电话</option>  
                        <option value="email">email</option>  
                        <option value="chidao">迟到</option>  
                        <option value="zaotui">早退</option>  
                        <option value="kuangke">旷课</option>  
                        <option value="qingjia">请假</option>  
                   </select>  
        <input type="submit" name="submit" id="submit" value="确认" />  
    <tr>  
</form>  
<br>  
 <table width="100%" border="2">  
  <tbody>  
    <tr>
    <th scope="col" width="10%">ID</th>
      <th scope="col" width="10%">姓名</th>  
      <th scope="col" width="10%">电话</th>  
      <th scope="col" width="10%">email</th>  
      <th scope="col" width="10%">迟到</th>  
      <th scope="col" width="10%">早退</th>  
      <th scope="col" width="10%">旷课</th>  
      <th scope="col" width="10%">请假</th>  
    </tr>  
    <?php 
        @mysql_data_seek($resultSet,($Page-1)*10);//将结果集的指针移动指定的行数  
        for($i=0;$i<10;$i++)  
        {  
            $row=@mysql_fetch_assoc($resultSet);
            if($row){  
    ?>  
    <tr>  
    <th scope="col" width="10%"><?=$row['ID'] ?></th> 
      <th scope="col" width="10%"><?=$row['name'] ?></th>  
      <th scope="col" width="10%"><?=$row['phone'] ?></th>  
      <th scope="col" width="10%"><?php echo $row['email'] ?></th>  
      <th scope="col" width="10%"><?php echo $row['chidao'] ?></th>  
      <th scope="col" width="10%"><?php echo $row['zaotui'] ?></th>  
      <th scope="col" width="10%"><?php echo $row['kuangke'] ?></th>  
      <th scope="col" width="10%"><?php echo $row['qingjia'] ?></th>  
    </tr>  
    <?php }   
        }   
  @mysql_free_result($resultSet);  ?>  
  </tbody>  
  
</table>  
   <p><?php   // 显示分页链接的代码  
if($Page== 1)               //如果是第1页，则不显示第1页的链接  
        echo  "第一页  上一页 ";    
else echo " <a href='?page=1'>第一页</a> <a href='?page=". ($Page-1)."'>上一页</a> ";  
for($i=1;$i<= $PageCount;$i++)   {        //设置数字页码的链接  
        if ($i==$Page) echo "$i  ";     //如果是某页，则不显示某页的链接  
        else echo " <a href='?page=$i'>$i</a> ";}   
if($Page== $PageCount)           // 设置“下一页”链接  
        echo  " 下一页  末页 ";  
else echo " <a href='?page=" . ($Page+1) . "'>下一页</a>   
 <a href='?page=" . $PageCount . "'>末页</a> ";  
echo "   共".$RecordCount. "条记录 ";  //共多少条记录  
 echo " $Page / $PageCount 页";  //当前页的位置?>  
</p>  
<br><br>  
<form>  
  Copyright © 2018, Xiao yongqiang 
</form>  
</body>  
</html> 