<body bgcolor="#F8F8F6">
<?php 
 header("Content-Type:text/html;charset=utf-8"); 
 session_start(); 
 //清除session 
 $username=$_SESSION['username']; 
 $_SESSION=array(); 
 session_destroy(); 
 //清除cookie 
 setcookie("username",'',time()-1); 
 setcookie("code",'',time()-1); 
 echo "<br><br><br><br><br><br><br><br><br><br><center>$username,欢迎下次光临"; 
 echo "重新<a href='login.html'>登录</a></center>"; 
?>