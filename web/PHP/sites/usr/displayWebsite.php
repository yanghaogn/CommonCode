<?php
 	$mysqld=mysqli_connect("localhost","sun","778951","demoDB");
 	
	if(mysqli_connect_errno()){
		printf("连接失败:%s\n",mysqli_connect_error());		
        exit();
	}else{
		
		   $type=$_GET["type"];
		  
		  if($type=="usr"){
		 		session_start();	
		  		$usr=$_SESSION["_currentUsr"];
		  		$key=trim($_GET["key"]);
		  		$sql=getSQL($type,$key,0);
     			$res=mysqli_query($mysqld,$sql);
       	   if($res){    	
       	   	$num=(int)$_GET["num"];
		   		if($num<1) 	$num=5;	
		   		$n=0;
		   		$i=0;
		   		$w="90%";		   		 
       			while($record=mysqli_fetch_array($res,MYSQLI_ASSOC)){
       				$addr=trim($record["addr"]);
       				$name=trim($record["name"]);
       				$info=trim($record["info"]); 
       				if($info=="") $info=$name;    
       				
       				$sum++;
       				$i++;       				
       		 		if($sum==1) echo "<table width=".$w." cellspacing=5  >";       				      				
       		 		if($i==1) echo "<tr>";
       			 	$nameDis=substr($name,0,8);
       			 //echo $nameDis;
       				echo   "<td align=left width=80px><input type='radio' value=".$addr." id='_".$name."' name='usrSite' onclick=clkUsrSite('".$name."')><a href=".$addr."  target='_blank' title=".$info." id=".$name." value=".$addr."><em  >".$name."</em></a></input></td>";
       				       				
       				if($i==$num){ 
       					echo "</tr>";
       					$i=0;
       				}
       			}
       			if(!($n==$num))echo "</tr>";
       			if($sum>=1) echo "</table>";
       			else echo "没有所要查询的记录，请换一下关键字再搜索";
       	   }
		  }  
		  if($type=="all"){
		  	 $key=trim($_GET["key"]);
		  	 $token=strtok($key," ");
		  
		 	$condition=1;
		 	while ($token !== false)
  			{
  				$condition.=" and (addr.addr like '%".$token."%' or info like '%".$token."%' or usrAddr.name like '%".$token."%')"; 
 			 	$token = strtok(" ");
 			}
		 	   $sql="select count(distinct(usrAddr.addr)) as sum from addr,usrAddr where addr.id=usrAddr.addr and ".$condition ;
		 	 //  echo $sql;
		 	   $res=mysqli_query($mysqld,$sql);
		 	   $record=mysqli_fetch_array($res,MYSQLI_ASSOC);
		 	   $sum=(int)$record["sum"];
		 	   echo "<p align='center'>总匹配个数：".$sum."</p>";
		 	   
		 	   $n1=(int)$_GET["n1"];
		 	   $n2=(int)$_GET["n2"];
		 	  $key=trim($_GET["key"]);
		  		$sql=getSQL($type,$key,$n1,$n2);
		  		
     			$res=mysqli_query($mysqld,$sql);
       	   if($res){         	     		 
       			while($record=mysqli_fetch_array($res,MYSQLI_ASSOC)){
       				$addr=trim($record["addr"]);
       				$name=trim($record["name"]);
       				$num=trim($record["sum"]);       			 						
       				echo   "<ul><li align=left ><a href=".$addr." target='_blank' title=总数：".$num.">".$name."</a></li>
       							<br/><a href=".$addr." target='_blank' title=总数：".$num.">".$addr."</a></ul>";
       		 
       			}
       			echo "<p align='center'>";
       			if($n1>0) {
       				$n11=$n1-10;
       				$n21=$n2-10;
       				echo "<a style='cursor: pointer' onclick=displayHots('".$n11."','".$n21."')>上一页</a>";
       			}
       			if($n2<$sum) {
       				$n11=$n1+10;
       				$n21=$n2+10;
       				echo "<a style='cursor: pointer' onclick=displayHots('".$n11."','".$n21."')>下一页</a>";
       			}
       			echo "</p>";
       		 
       	   }
		  }  
		  mysqli_close($mysqld);	
	}
	function getSQL($type,$key,$n1,$n2){
		if($type=="usr"){
			session_start();	
		  	$usr=$_SESSION["_currentUsr"];
	 	 	$token=strtok($key," ");
		 
		 	$condition=1;
		 	while ($token !== false)
  			{
  				$condition.=" and (addr.addr like '%".$token."%' or info like '%".$token."%' or usrAddr.name like '%".$token."%')"; 
 			 	$token = strtok(" ");
 			}
		 
			$sql="SELECT addr.addr AS addr, usrAddr.name AS name, info FROM addr, usrAddr ";
		  	$sql.="WHERE addr.id = usrAddr.addr and usrAddr.uname='".$usr."' and ".$condition." order by addtime desc ";
	 	   return $sql;
		}
		if($type=="all"){
			$token=strtok($key," ");
		  
		 	$condition=1;
		 	while ($token !== false)
  			{
  				$condition.=" and (addr.addr like '%".$token."%' or info like '%".$token."%' or usrAddr.name like '%".$token."%')"; 
 			 	$token = strtok(" ");
 			}
		 
				$sql="select addr.addr as addr,addr.name as name,count(usrAddr.addr) as sum from addr,usrAddr where addr.id=usrAddr.addr and ".$condition."  group by usrAddr.addr order by count(usrAddr.addr) desc limit ".$n1.",".$n2;
				return $sql;	
		}
		return "";
	}
		
?>

 