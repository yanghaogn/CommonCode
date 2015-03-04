<?php
 	$mysqld=mysqli_connect("localhost","sun","778951","demoDB");
 	
	if(mysqli_connect_errno()){
		printf("连接失败:%s\n",mysqli_connect_error());		
        exit();
	}else{	 
			$name=trim($_GET["name"]);
		   $pass=trim($_GET["pass"]);
 	   
		   
		   $sql="select count(*) as num from usr where name='".$name."'";
		 //  echo $sql;
 
  			if(getNum($sql)==0){
  				echo "用户不存在";
  				mysqli_close($mysqld);	
  				exit();
  			}
		   $sql="select count(*) as num from usr where name='".$name."' and pass='".$pass."'";
  			if(getNum($sql)==1){
  				echo "可用";
  			 	 echo "登录成功，正在跳转......";
		   	session_start();
		 		$_SESSION["_currentUsr"]=$name;
		 		echo $_SESSION["_currentUsr"];
		 	
  			}
  			echo "密码错误";
  			mysqli_close($mysqld);	
  		}
		  	function getNum($sql){
				global $mysqld;
				$res=mysqli_query($mysqld,$sql);
				if($res){
			 		if($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC)){			 			
       				return $newArray["num"];       				      			 
       				 
       			} 	
			 	}
			 return 0;
		}
			  
 
		  
	
 
		
?>

 