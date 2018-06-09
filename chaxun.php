<?php
    @session_start();  
    if(isset($_SESSION['user'])||isset($_SESSION['admin'])){  
  
    }  
    else{  
        echo "<script>location.href='login.php';</script>";  
    }  
    //连接数据库  
    $con = mysql_connect("localhost:3306", "root", "root");  
        mysql_query("set names 'utf-8'");  
        mysql_select_db("test", $con);  
          
          
    if($_POST["submit"]){  
          
        $chaxun = $_POST["chaxun"];  
        $xuanze = $_POST["xuanze"];  
          
        if(isset($_GET['page']) && (int)$_GET['page']>0)  
            $Page=$_GET['page'];  
        else      
            $Page=1;  
              
        $sql = "select * from user where $xuanze='$chaxun'";  
        $resultSet = mysql_query($sql);  
        $RecordCount=mysql_num_rows($resultSet);  
        $PageCount =ceil($RecordCount/10);  
        $sql = "select * from user where $xuanze='$chaxun'";  
        $resultSet = mysql_query($sql);  
    }  
  
  
?>  
<!doctype html>  
<html>  
<head>  
<meta charset="utf-8">  
<title>shaynerain学生考勤系统</title>  
</head>  
<body style="text-align: center; background-color: rgba(176,235,200,1.00);">  
<h1>查询结果</h1>  
<a  <?php if(isset($_SESSION['admin'])){  
            echo "href=" ; echo "admin.php"; }  
            else {echo "href=" ; echo "user.php";}?>>返回主页</a></p>  
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
 echo " $Page / $PageCount 页";      //当前页的位置?>  
</p>  
<br><br>  
<form>  
  Copyright © 2018, Xiao yongqiang  
</form>  
</body>  
</html>  