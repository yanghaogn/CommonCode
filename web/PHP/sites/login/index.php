<?php 
	 session_start();
  	 $name=$_SESSION["_currentUsr"];
 	 if(isset($name))	{
 	 	if($name=="admin") header('Location:http://sky/sites/admin');
 	 	else 	 	header('Location:http://sky/sites/usr');
 	 }
 	  
?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
   
    
      <title>�û���¼ </title>
 <link rel="stylesheet" type="text/css" href="http://sky/css/sites.css">
  <script type="text/javascript" src="http://sky/js/sites.js"></script>	 
 
   <script language="Javascript" type="text/javascript">
		var _ajaxL;
	
 
		function _showLogin(){
			if(_ajaxL.readyState==4){
				if(_ajaxL.status==200){
					 
					 var _res=_ajaxL.responseText;
					 if(_res.search("����")==0)		{
					 		 var usr=document.getElementById("_name").value;
					 		  	  location.href="http://sky/sites/usr";
					 	 	if(document.getElementById("_auto").checked){ 
					 			$name=document.getElementById("_name").value;
						 		$pass=document.getElementById("_pass").value;
						  			
						 		setCookie("_pass",$pass);
					 			setCookie("_name",$name);
					 			setCookie("_auto","true");
					 	 	}else {
					 	 		setCookie("_auto","false");
					 	 		setCookie("_pass","");
					 			setCookie("_name","");
					 	 	}
				 		 }
					 if(_res.search("�û�")==0)  document.getElementById("_nameNotify").innerHTML="�û�������";
					 if(_res.search("����")==0)  document.getElementById("_passNotify").innerHTML="�������";
			 		   
					 
				}else{
		 		}
		}	 
		}
 	 
 
		function _register(){
			location.href="http://sky/sites/register";			
		}
		function _login(){	 
	 		 	$name=encodeURIComponent(document.getElementById('_name').value);
			 	$pass=encodeURIComponent(document.getElementById('_pass').value);
				$send="login.php?name="+$name+"&pass="+$pass;
			 	_ajaxL=createAjax();
			 	if(!_ajaxL){
					alert('����������汾���ͣ���ʹ�����°汾�������');
					return 0;
				}
		 		_ajaxL.onreadystatechange=_showLogin;
				_ajaxL.open("GET",$send,true);	
				_ajaxL.send();	
		}
		function onLoad(){
			
			
			 document.getElementById("_name").focus();
			 var _au=getCookie("_auto");
			 if(_au=="true"){
				$name=getCookie("_name");
				$pass=getCookie("_pass");
				document.getElementById("_pass").value=$pass;
				document.getElementById("_name").value=$name;
				document.getElementById("_auto").checked=true;
			}
		}
		function  _Enter(){
			$name=encodeURIComponent(document.getElementById('_name').value);
			$pass=encodeURIComponent(document.getElementById('_pass').value);
			if($name=="") document.getElementById("_name").focus();
			else if($pass=="")  document.getElementById("_pass").focus();
			else _login();
		}
		function _click(_type){
			 if(_type=="��ҳ")location.href="http://sky/sites/usr";
		}
		</script>
</head>
<body onload="load()">
   
<div id="wrapper"> 
	<div id="header">
		 <ul id="menu">
			 <li id="h"><h1 size='500'  style="cursor: pointer" onclick="_click('��ҳ')">��ҳ</h1></li> 
		</ul>
		 
		 
	</div>
	<div id="navfirst" align="right"></div>
	<div id="navsecond">���</div>
	<div id="maincontent" >	 
		<fieldset >
	  	<legend  id="_show" align="center">��¼</legend>
 
	  	<table align="center">
	  	<tr>
			<td>�û���:</td><td><input type="text" id="_name"  onkeypress="javascript:if(event.keyCode==13) _Enter();"></input></td><td><p id="_nameNotify"></p></td>
		</tr>
		<tr>
			<td>����:</td><td><input type="password" id="_pass" onkeypress="javascript:if(event.keyCode==13) _Enter();" ></input></td><td><p id="_passNotify"></p></td>
		</tr>
		<tr>
			<td></td><td><input type="checkbox" id="_auto" value="��ס����" >��ס����</input><a href="http://sky/sites/findPass">�һ�����</a></td><td></td>
		</tr>
		 <tr>
			<td></td><td><input type="button"    value="��¼" onclick="_login()"> </input><input type="button" id="_clear"  value="ע��" onclick="_register()"> </input></td> 
		</tr>
	 	</table>
  </fieldset>
	 </div>

<div id="sidebar"></div>
 
<div id="footer" align="center">��Ȩ���У���ƣ��绰��15828540155�����䣺<a href="mailto:15828540155@139.com">15828540155@139.com</a></div>
</body>
</html>
