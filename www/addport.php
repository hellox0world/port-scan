<body bgcolor="#F8F8F6">
<p align='right'><a href='index.php'>返回主页</a></p>

<?php 


header ( "Content-type:text/html;charset=utf-8" );  

$database = "port";
$dataname = "root";
$datapasswd = "123456";
$datalocal = "127.0.0.1:3306";
//$dataport = "3306";
$con = mysqli_connect($datalocal,$dataname,$datapasswd,$database);
if(!$con){
    echo "数据库连接异常";
}
//设置查询数据库编码
mysqli_query($con,'set names utf8');

//通过表单插入数据到数据库中
//接收参数
$number = $_POST['number'];
$name = $_POST['name'];
$grade = $_POST['grade'];
$describes = $_POST['describes'];



$quer = "select * from port where number=$number";
$result = mysqli_query($con,$quer);

//函数返回结果集中行的数量
if(mysqli_num_rows($result)>0){
	echo "<br><br><br><br><br><br><br><br><br></hr><h3><center>已经存在端口信息如需要请<a href='login.html'>修改</a></center></h3></br>";
}
else{

	//mysqli_fetch_array以数组的形式返回，关联数组
	if(!$row = mysqli_fetch_array($result)){
	
	//插入数据库
	$sql = "insert into port (number,name,grade,describes) value ('$number','$name','$grade','$describes')";
	//echo $sql;
	$result0 = mysqli_query($con,$sql);
	if(!$result0){
		echo "插入失败</br>";
	}
	else{
		echo "<br><br><br><br><br><br><br></hr><h5><center>成功添加数据</center></h5></br>";
	}
}
}






//查询数据库
$query = "select * from port where number=$number";
$result1 = mysqli_query($con,$query);

//函数返回结果集中行的数量
if(mysqli_num_rows($result1)>0){
//mysqli_fetch_array以数组的形式返回，关联数组
while($row = mysqli_fetch_array($result1)){
       
echo     
 "<center>
<table>
 <tr>
 <td>端口：".$row['number']."</td>
   <td>   服务名称：".$row['name']."</td>
   <td>   危险等级：".$row['grade']."</td>
   <td>   描述：".$row['describes']. "</td>
 </tr>
</table>
</center>";
 }      
}
//关闭数据库
 mysqli_close($con);
 ?>