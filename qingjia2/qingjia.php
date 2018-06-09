
<?php 
    session_start();
    $ID = $_SESSION["ID"];
    echo "shuju".$ID;
    if($_POST['submit'])  
    {
        $con = mysql_connect("localhost:3306", "root", "root");  
        mysql_query("set names 'utf-8'");  
        mysql_select_db("test", $con);
        $ID = $_POST['ID'];
        if(isset($ID))
        {
            echo "<script>alert('提交成功')</script>";
            echo "<script>location.href='../user.php';</script>";  
        }
        else
            echo "<script>alert('跳转失败！')</script>";
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>请假</title>
<link href="css/style.css" rel='stylesheet' type='text/css' />

</head>
<body style="text-align: center; background-color: rgba(176,235,200,1.00);">
	<h1>请假表单</h1>
	<div class="login-01">
			<form method="post">
				<ul>
				<li class="first">
					<a href="#" class=" icon user"></a><input type="text" class="text" readonly="readonly" name="ID" id="ID" value="ID：<?php echo $_SESSION['ID']?>" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'ID：<?php echo $_SESSION['ID']?>';}" >
					<div class="clear"></div>
				</li>
                <li class="first">
					<a href="#" class=" icon user"></a><input type="text" class="text" readonly="readonly" name="name" id="name" value="姓名：<?php echo $_SESSION['user']?>" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = '姓名：<?php echo $_SESSION['user']?>';}" >
					<div class="clear"></div>
				</li>
				<li class="second">
				<a href="#" class=" icon msg"></a><textarea value="Message" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = '内容';}">请假原由</textarea>
				<div class="clear"></div>
				</li>
			</ul>
			<input type="submit" name="submit" id="submit" value="提交" >
			<div class="clear"></div>
		</form>
</div>
	<!--start-copyright-->
   		<div class="copy-right">
   			<div class="wrap">
				<p>Copyright @ 2018.Xiao YongQiang</p>
		</div>
	</div>
	<!--//end-copyright-->
</body>
</html>