<?php
 	$mysqld=mysqli_connect("localhost","sun","778951","demoDB");
 	
	if(mysqli_connect_errno()){
		printf("连接失败:%s\n",mysqli_connect_error());		
        exit();
	}else{
		  $type=trim($_GET["type"]);
		   $value=trim($_GET["value"]);
		  if($type=="name") $type="name";
		  if(!_varify($type,$value)) exit();
		  if($type=="pass"){
		  		echo "可用"; 
		  		exit();
		  	}
		  $sql="select count(*) as num from usr where ".$type."='".$value."'";
		  $out="不可用";
		  if($type=="name") $out="用户名已存在";
		  if($type=="email") $out="邮箱已注册";
		  $res=mysqli_query($mysqld,$sql);
		  if($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC)){
				if($newArray["num"]==0) $out="可用";				 
		  	}
		  echo $out;
		  mysqli_close($mysqld);	
	}
	function _varify($type,$value){
		//return true;
		if($type=="name"){
		 		if(strlen($value)>20) {
		 			echo "用户名过长";
		 			return false;
		 		
		 		}
		 		if(strlen($value)<3) {
		 			echo "用户名过短";
		 			return false;
		 		
		 		}
		  		 
		  	}
		 if($type=="email"){
		 		if(strlen($value)>50) {
		 			echo "邮箱过长";
		 			return false;
		 		}
		  		if(!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$",$value)){
		  				echo"请输入正确的邮箱地址";
		  				return false;
		  			}
		  }
		  if($type=="pass"){
		  	if(strlen($value)>15){
		  		echo "密码过长";
		  		return false;
		  	}
		  	if(strlen($value)<4){
		  		echo "密码过短";
		  		return false;
		  	}
		 // 	if($value)
		  	}
		  	return true;
	}
		
?>

 