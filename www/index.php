<body bgcolor="#F8F8F6">
<?php 
 header("Content-Type:text/html;charset=utf-8"); 
 session_start(); 
 //首先判断Cookie是否有记住用户信息 
 if(isset($_COOKIE['username'])) 
 { 
  $_SESSION['username']=$_COOKIE['username']; 
  $_SESSION['islogin']=1; 
 } 
 if(isset($_SESSION['islogin'])) 
 { 
  //已经登录 
  
  echo "<p align='right'><a href='logout.php'>注销</a></p>"; 
  echo "<br><br><br><br><br><br><br><br><center>".$_SESSION['username'].":你好，欢迎进入个人中心！<br/></center>"; 
  
  echo "<br><center><a href='addport.html'>添加端口信息</a><center>"; 
  
 } 
 else
 { //未登录 
  echo "<br><br><br><br><br><br><br><br><br><br><center>你还未登录，请<a href='login.html'>登录</acenter></center>"; 
 } 
?>