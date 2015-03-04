 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
   <title>用户注册</title>
    <link rel="stylesheet" type="text/css" href="http://sky/css/sites.css">
 	 <script type="text/javascript" src="http://sky/js/sites.js"></script>	 
   <script language="Javascript" type="text/javascript">
		var _ajaxV,_ajaxI,_type;
	 
		function _showVarify(){
		if(_ajaxV.readyState==4){
				if(_ajaxV.status==200){
				 

					if(_type=="name")
						document.getElementById('_nameNotify').innerHTML=_ajaxV.responseText;
				if(_type=="email")
						document.getElementById('_emailNotify').innerHTML=_ajaxV.responseText;
				if(_type=="pass")
						document.getElementById('_pass1Notify').innerHTML=_ajaxV.responseText;
					 
				}else{
				 
				}
		}	 
		}
		function _showRegister(){
		if(_ajaxI.readyState==4){
				if(_ajaxI.status==200){
 
					 location.href="http://sky/sites/usr";
					 document.getElementById('_show').innerHTML=_ajaxI.responseText;
					 
				}else{
				 
				}
		}	 
		}
 
 
		function _varify(_var){
			_type=_var;
			if(_type=="pass2"){
				if(!_varifyPass()) 
					document.getElementById('_pass2Notify').innerHTML="两次的密码不一样";
				else {
					var _notify=document.getElementById('_pass1Notify').innerHTML;
					if(_notify.search("可用")==0)
						document.getElementById('_pass2Notify').innerHTML="可用";
				}
				return;
			}
			if(_type=="pass1") _type="pass";
			$send="varify.php?";
			if(_type=="name") {
				$value=encodeURIComponent(document.getElementById('_name').value);
				$send+="type=name&value="+$value;
			}
			if(_type=="email") {
				$value=encodeURIComponent(document.getElementById('_email').value);
				$send+="type=email&value="+$value;
			}
			if(_type=="pass") {
				$value=encodeURIComponent(document.getElementById('_pass1').value);
				$send+="type=pass&value="+$value;
			}
		 	_ajaxV=createAjax();
			if(!_ajaxV){
				alert('使用不兼容的浏览器，请使用最新版本的浏览器');
				return 0;
			}
			 	 
			_ajaxV.onreadystatechange=_showVarify;
			_ajaxV.open("GET",$send,true);	
			_ajaxV.send();	
			
		}
		function _varifyPass(){
			$p1=document.getElementById('_pass1').value;
			$p2=document.getElementById('_pass2').value;
			if($p1!=$p2) return false;
			return true;
		}
		function _clear(){
			document.getElementById('_name').value="";
			document.getElementById('_email').value="";
			document.getElementById('_pass1').value="";
			document.getElementById('_pass2').value="";
			
			document.getElementById('_nameNotify').innerHTML="";
			document.getElementById('_emailNotify').innerHTML="";
			document.getElementById('_pass1Notify').innerHTML="";
			document.getElementById('_pass2Notify').innerHTML="";
		}
		function _register(){
		// document.getElementById('_nameNotify').innerHTML="12";
			
			_varify("name");
			var _name=document.getElementById('_nameNotify').innerHTML;
			var _email=document.getElementById('_emailNotify').innerHTML;
			var _pass1=document.getElementById('_pass1Notify').innerHTML;
			var _pass2=document.getElementById('_pass2Notify').innerHTML;			
			 
			if(_name.search("可用")==0)
				if(_email.search("可用")==0)
					if(_pass1.search("可用")==0)
						if(_pass2.search("可用")==0){
			 	$name=encodeURIComponent(document.getElementById('_name').value);
		  		if(document.getElementById('_man').checked)	$sex=encodeURIComponent("男");
				else $sex=encodeURIComponent("女");
				//alert($sex);
				$email=encodeURIComponent(document.getElementById('_email').value);
				$pass=encodeURIComponent(document.getElementById('_pass1').value);
				$send="register.php?name="+$name+"&sex="+$sex+"&email="+$email+"&pass="+$pass;
				_ajaxI=createAjax();
				if(!_ajaxI){
					alert('??????????XMLHttpRequest???????÷');
					return 0;
				}
			 	// alert('??????????XMLHttpRequest???????÷');
				_ajaxI.onreadystatechange=_showRegister;
				_ajaxI.open("GET",$send,true);	
				_ajaxI.send();	
			 }
		}function  _Enter(){
			$name= (document.getElementById('_name').value);
			$email= (document.getElementById('_email').value);
			$pass1= (document.getElementById('_pass1').value);
			$pass2= (document.getElementById('_pass2').value);
			if($name=="") document.getElementById("_name").focus();
			else if($email=="")  document.getElementById("_email").focus();
			else if($pass1=="") document.getElementById("_pass1").focus();
			else if($pass2=="") document.getElementById("_pass2").focus();
			else {
				_register();
			}
		}
		function _click(_type){
			 if(_type=="首页")location.href="http://sky/sites/usr";
		}
		function onLoad(){
			document.getElementById("_name").focus();
			
			}
		</script>
</head>
<body  onload="load()">
   
<div id="wrapper"> 
	<div id="header">
		  <ul id="menu">
			 <li id="h"><h1 size='500'  style="cursor: pointer" onclick="_click('首页')">首页</h1></li> 
		</ul>
		 
	</div>
	<div id="navfirst" align="right"></div>
	<div id="navsecond">广告</div>
	<div id="maincontent" >	 
		 <fieldset >
	  	<legend  id="_show" align="center">注册 </legend>
 
	  	<table align="center">
	  	<tr>
			<td>用户名:</td><td><input type="text" id="_name" onkeypress="javascript:if(event.keyCode==13) _Enter();" onkeyup="_varify('name')" autocomplete="off"></input></td><td><p id="_nameNotify"></p></td>
		</tr>
		<tr>
			<td>性别:</td><td><input type="radio" id="_man" name="_sex"  checked="true" >男</input><input type="radio" id="_woman" name="_sex" >女</input></td>
		</tr>
		<tr>
			<td>邮箱</td><td><input type="text" id="_email" onkeypress="javascript:if(event.keyCode==13) _Enter();" onkeyup="_varify('email')" autocomplete="off"></input></td><td><p id="_emailNotify"></p></td>
		</tr>
		<tr>
			<td>密码:</td><td><input type="password" id="_pass1" onkeypress="javascript:if(event.keyCode==13) _Enter();" onkeyup="_varify('pass1')" ></input></td><td><p id="_pass1Notify"></p></td>
		</tr>
		<tr>
			<td>确认密码:</td><td><input type="password" id="_pass2" onkeypress="javascript:if(event.keyCode==13) _Enter();"  onkeyup="_varify('pass2')"></input></td><td><p id="_pass2Notify"></p></td> 
		</tr>
		<tr>
			<td></td><td><input type="button" id="_register"  value="注册" onclick="_register()"> </input><input type="button" id="_clear"  value="清空" onclick="_clear()"> </input></td> 
		</tr>
	 	</table>
  </fieldset>
	 </div>

<div id="sidebar"></div>
 
<div id="footer" align="center">版权所有：杨浩，电话：15828540155，邮箱：<a href="mailto:15828540155@139.com">15828540155@139.com</a></div>
</body>
</html>
