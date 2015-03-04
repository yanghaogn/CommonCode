<?php
 	$mysqld=mysqli_connect("localhost","sun","778951","demoDB");
 	
	if(mysqli_connect_errno()){
		printf("连接失败:%s\n",mysqli_connect_error());		
        exit();
	}else{	 
			  $name=trim($_GET["name"]);
		  $sex=trim($_GET["sex"]);
		  $pass=trim($_GET["pass"]);
		  $email=trim($_GET["email"]);
		  //if(_varify("name",$name))
		  $sql="insert into usr(name,email,pass,sex,regTime) values('".$name."','".$email."','".$pass."','".$sex."',now())";
  			$res=mysqli_query($mysqld,$sql);
		   if($res){
		   	echo "注册成功，正在跳转......";
		    	session_start();
		 	$_SESSION[_currentUsr]=$name;
		   	
		   }
		   
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

 