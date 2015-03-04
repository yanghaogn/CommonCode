<?php
   $mysqld=mysqli_connect("localhost","sun","778951","demoDB"); 	
	if(mysqli_connect_errno()){
	  	printf("连接失败:%s\n",mysqli_connect_error());		
      exit();
	}else{
		  
		  $type=trim($_GET["type"]);
		   $name=trim($_GET["name"]);
		 
		  	if($type=="addr"){
		  		$addr=trim($_GET["addr"]);
		  		$addr=getAddr($addr);
		  		$info=trim($_GET["info"]);
		  		if($addr=="") {
		  			mysqli_close($mysqld); 
		  			echo "地址为空"; 		  			
		  			return;
		  		}
		  		if($name=="") {
		  			mysqli_close($mysqld); 
		  			echo "名字为空"; 		  			
		  			return;
		  		}
		  		
		  		/*****************************系统是否存在网址************************************************/
				$sql="select count(*) as num from addr where addr='".$addr."'";				
				if(!isExists($sql)){
					 $sql="insert into addr(addr,name,updatetime) values('".$addr."','".$name."',now())";
					 $res=mysqli_query($mysqld,$sql);	
					// echo $sql."<br>";				 
				}
				
				$sql="select id   from addr where addr='".$addr."'";	
				//echo $sql;			
				$res=mysqli_query($mysqld,$sql);
				if($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC))			 			
       				$addr=$newArray["id"];
       		 
       		session_start();
				$usr=$_SESSION["_currentUsr"];
				/************************用户是否已添加**************************************/
       		$sql="select count(*) as num from usrAddr where addr='".$addr."' and uname='".$usr."'";				
				if(isExists($sql)){
					echo "您已添加网页".$_GET["addr"]; 	
					mysqli_close($mysqld); 
		  		 	  			
		  			return;				 
				}
				 
				/**********************************添加记录*******************************************/
		  		$sql="insert into usrAddr(addr,name,info,uname,addtime) values('".$addr."','".$name."','".$info."','".$usr."',now())";
		   	 
		  		$res=mysqli_query($mysqld,$sql);
		  		if($res) echo "成功添加网页：".$name;
		  		else echo $sql;
		  } 
		  mysqli_close($mysqld);    		
	}	
	function isExists($sql){
			global $mysqld;
			$res=mysqli_query($mysqld,$sql);
				if($res){
			 		if($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC)){			 			
       				$num=$newArray["num"];       				      			 
       				if((int)$num>0){ 				 
							return true;       					
       				}
       			} 	
			 	}
			 return false;
	}
	function getAddr($addr){
		$addr=trim($addr);
		if(!strstr($addr,":/")) $addr="http://".$addr;
		$len=strlen($addr);
		$end=substr($addr,$len-1);
		//echo $end;
		if($end=="/") $addr=substr($addr,0,$len-1);
		//echo $addr;
		return $addr;
	}
	
 
?>