<?php 
	$mysqld=mysqli_connect("localhost","sun","778951","demoDB"); 	
	if(mysqli_connect_errno()){
		printf("连接失败:%s\n",mysqli_connect_error());		
      exit();        
	}
	$type=$_GET["type"];
	if($type=="out"){
	 	session_start();
		unset($_SESSION["_currentUsr"]);
		  mysqli_close($mysqld);	
 	}
 	if($type=="delUsrSite"){
 		session_start();
			$usr=$_SESSION["_currentUsr"];
		   $addr=$_GET["addr"];
		   $sql="select id from addr where addr='".$addr."'";
		 // echo $sql;
		   $res=mysqli_query($mysqld,$sql);
		   $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		   $addr=$record["id"]; 
		  //echo "addr:".$addr."*";
		  $sql="delete from usrAddr where uname='".$usr."' and addr='".$addr."'";
		  $res=mysqli_query($mysqld,$sql);
		//  echo $sql;
		  mysqli_close($mysqld);	
 	}
 	if($type=="updateUsrSite"){
 
 			session_start();
			$usr=$_SESSION["_currentUsr"];
		   $addr=trim($_GET["addr"]);
		   $name=trim($_GET["name"]);
		   $info=trim($_GET["info"]);
		   $sql="select id from addr where addr='".$addr."'";
		  //  echo $sql;
	 	   $res=mysqli_query($mysqld,$sql);
		   $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		   $addr=$record["id"]; 
		   $sql="update  usrAddr set name='".$name."',info='".$info."' where uname='".$usr."' and addr='".$addr."'";
		  $res=mysqli_query($mysqld,$sql);
 		  mysqli_close($mysqld);
	}
	 if($type=="updateUsr"){
 		 
 			session_start();
			$usr=$_SESSION["_currentUsr"];
		   $sex=trim($_GET["sex"]);
		   $email=trim($_GET["email"]);
		   if(_varify("email",$email)==false) exit();
		 //  $info=trim($_GET["info"]);
		   $sql="select count(*) as num from usr where email='".$email."'";
		 //  echo $sql;
	 	   $res=mysqli_query($mysqld,$sql);
		   $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		   $num=$record["num"]; 
		 	if($num==1){
		 		 mysqli_close($mysqld);
		 		echo "存在";
		 		exit();
		 		}
		  $sql="update  usr set sex='".$sex."',email='".$email."' where name='".$usr."'";
		  $res=mysqli_query($mysqld,$sql);
		  if($res) echo "成功";
 		  mysqli_close($mysqld);
	}
	if($type=="getUsr"){
  		session_start();
		echo $_SESSION["_currentUsr"];
 	}
 	if($type=="getEmail"){
 		session_start();
		$usr=$_SESSION["_currentUsr"];
		$sql="select email from usr where name='".$usr."'";
		 $res=mysqli_query($mysqld,$sql);
		 $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		 echo $record["email"];
		 mysqli_close($mysqld);
 		
 	}
 	if($type=="getPass"){
 		session_start();
		$usr=$_SESSION["_currentUsr"];
		$sql="select pass from usr where name='".$usr."'";
		 $res=mysqli_query($mysqld,$sql);
		 $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		 echo $record["pass"];
		 mysqli_close($mysqld);
 		
 	}
 	if($type=="getSex"){
 		session_start();
		$usr=$_SESSION["_currentUsr"];
		$sql="select sex from usr where name='".$usr."'";
		 $res=mysqli_query($mysqld,$sql);
		 $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		 echo $record["sex"];
		 mysqli_close($mysqld);
 		
 	}
 	if($type=="updatePass"){
 		session_start();
		$usr=$_SESSION["_currentUsr"];
		$pass=$_GET["pass"];
		$sql="update usr set pass='".$pass."' where name='".$usr."'";
		 $res=mysqli_query($mysqld,$sql);
		 if($res) echo "成功".$sql;
	 
		 mysqli_close($mysqld);
 		
 		}
 	if($type=="srchUsr"){
 		//echo "14";
 		$key=trim($_GET["key"]);
 		$sql=getSrchUsrSQL($key);
 		echo "<table align='center' cellspacing='5' ><tr align='center'><td></td><td>用户名</td><td>网址数</td><td>邮箱</td><td>注册时间</td><tr/>";
 		if($key!="") echo "<caption>满足搜索条件:".$key."的用户如下</caption>";
		$res=mysqli_query($mysqld,$sql);
		$numUsr=0;
		$numAddr=0;
 		while($record=mysqli_fetch_array($res,MYSQLI_ASSOC)){
 			 $numUsr++;
 			 $numAddr+=(int)$record["num"];
 			 echo "<tr align='center'><td>".$numUsr."</td><td>".$record["name"]."</td><td>".$record["num"]."</td><td>".$record["email"]."</td><td>".$record["regTime"]."</td><tr/>";
 			 
 		 }
 		 echo  "<tr align='center'><td>合计:</td><td>".$numUsr."</td><td>".$numAddr."</td><td>".$numUsr."</td><td>".$numUsr."</td><tr/>";
 	
 		echo "</table>";
 		
 	}
 	if($type=="srchSite"){
 		 
 		$key=trim($_GET["key"]);
 		$sql=getSrchSiteSQL($key);
 		echo "<table align='center' cellspacing='5' ><tr align='center'><td></td><td >网名</td><td width='40'>数目</td><td>网址</td><tr/>";
 		if($key!="")echo "<caption>满足搜索条件:".$key."的用户如下</caption>";
		$res=mysqli_query($mysqld,$sql);
		$numSite=0;
		$numAddr=0;
 		while($record=mysqli_fetch_array($res,MYSQLI_ASSOC)){
 			 $numSite++;
 			 $numAddr+=(int)$record["num"];
 			 echo "<tr align='center'><td>".$numUsr."</td><td>".$record["name"]."</td><td>".$record["num"]."</td><td>".$record["addr"]."</td><tr/>";
 			 
 		 }
 		 echo  "<tr align='center'><td width='40'>合计:</td><td>".$numSite."</td><td>".$numAddr."</td><td>".$numSite."</td><tr/>";
 	
 		echo "</table>";
 		
 	}
 	function getSrchUsrSQL($key){
 		$token=strtok($key," "); 
		$condition=1;
		while ($token !== false)
  		{
  				$condition.=" and (usr.name like '%".$token."%' or sort like '%".$token."%' or sex like '%".$token."%' or regTime like'%".$token."%')"; 
 			 	$token = strtok(" ");
 		}
 		$sql="select usr.name as name,count(addr) as num,email,regTime from usr left join usrAddr on usr.name=usrAddr.uname where ".$condition." group by usr.name";
 		$sql.=" order by count(addr) desc";
 		return $sql;
 	}
 	function getSrchSiteSQL($key){
 		 $token=strtok($key," ");
		  
		 	$condition=1;
		 	while ($token !== false)
  			{
  				$condition.=" and (addr.addr like '%".$token."%' or info like '%".$token."%' or usrAddr.name like '%".$token."%')"; 
 			 	$token = strtok(" ");
 			}
		
			$sql="select addr.addr as addr,addr.name as name,count(usrAddr.addr) as num from addr,usrAddr where addr.id=usrAddr.addr and ".$condition."  group by usrAddr.addr order by count(usrAddr.addr) desc ";
 //echo $sql;			
			return $sql;	
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