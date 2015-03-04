<?php
	 session_start();
  	 $name=$_SESSION["_currentUsr"];
 	 if(isset($name))	header('Location:usr');
 	 else header('Location:login');
		
?>

 