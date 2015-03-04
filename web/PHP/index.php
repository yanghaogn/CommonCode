<?php
	 session_start();
  	 $name=$_SESSION["_currentUsr"];
 	  if(isset($name))	{
 	   	 	header('Location:http://sky/sites/usr');
 	 }
 	 else header('Location:http://sky/sites/login');
		
?>

 