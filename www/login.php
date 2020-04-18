<body bgcolor="#F8F8F6">
<?php 
 session_start(); 
header("Content-type:text/html;charset=utf-8");
$username = trim($_POST['username']); 
$password = trim($_POST['password']); 


$database = "port";
$dataname = "root";
$datapasswd = "123456";
$datalocal = "127.0.0.1";
$dataport = "3306";
$con = mysqli_connect($datalocal,$dataname,$datapasswd,$database);
if(!$con){
    echo "数据库连接异常";
}


//查询数据库
$query = "select * from user where username='$username' and password=$password";
$result1 = mysqli_query($con,$query);


//函数返回结果集中行的数量
if(mysqli_num_rows($result1)>0){
//mysqli_fetch_array以数组的形式返回，关联数组
while($row = mysqli_fetch_array($result1)){
	echo $row['password'];
	echo $row['username'];
	echo $password;
	echo $username;
	if(($username=='')||($password=='')) 
 { 
   header('refresh:3;url=login.html'); 
   echo "改用户名或密码不能为空，3秒后跳转到登录页面"; 
   exit; 
  } 
else if(($username!=$row['username'])||($password!=$row['password'])) 
  { 
   //用户名或密码错误 
   header('refresh:3;url=login.html'); 
   echo "用户名或密码错误，3秒后跳转到登录页面"; 
   exit; 
  } 
  else if(($username==$row['username'])&&($password==$row['password'])) 
  { 
   //登录成功将信息保存到session中 
   $_SESSION['username']=$username; 
   $_SESSION['islogin']=1; 
   //将其保存到cookie 
    setcookie($row['username'],$username,time()+7*24*60*60); 
    setcookie($row['password'],md5($username.md5($password)),time()+7*24*60*60); 
  
   //跳转到用户首页 
   header('refresh:0;url=index.php'); 
  } 
	
}
}




 
?>