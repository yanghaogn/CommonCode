 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
   <title>�һ�����</title>
    <link rel="stylesheet" type="text/css" href="http://sky/css/sites.css">
    <script language="javascript" src="./main.js"></script>
   <title>�޸����� </title>
   <script type="text/javascript" src="http://sky/js/sites.js"></script>	 
	 
   <script language="Javascript" type="text/javascript">
		var _ajaxV,_ajaxU;
		function _showVarify(){
			if(_ajaxV.readyState==4){
				if(_ajaxV.status==200){ 

					if(_type=="pass")
						document.getElementById('_pass1Notify').innerHTML=_ajaxV.responseText;
				if(_type=="usrEmail"){
						var _res=_ajaxV.responseText;
						if(_res.search("����")==0) {
							document.getElementById("_pass1").disabled=false;
							document.getElementById("_pass2").disabled=false;
							document.getElementById("_update").disabled=false;
							document.getElementById("_clear").disabled=false;
							document.getElementById("_name").disabled=true;
							document.getElementById("_email").disabled=true;
							document.getElementById("_varify").style.display="none";
							document.getElementById("_showPass1").style.display="table-row";
							document.getElementById("_showPass2").style.display="table-row";
							document.getElementById("_showPass3").style.display="table-row";
						 
							document.getElementById("_pass1").focus();
							document.getElementById("_emailNotify").innerHTML="";
						}else{
							document.getElementById("_pass1").value="";
							document.getElementById("_pass2").value="";
						 	document.getElementById("_emailNotify").innerHTML="��ƥ��";
								
						}
						 
				 }
					 
				}else{
				 alert("��������æ�����Ժ�����");
				}
		}	 
	}
	function _showUpdate(){
			if(_ajaxU.readyState==4){
				if(_ajaxU.status==200){ 
					//	document.getElementById("_emailNotify").innerHTML=
					var _res=_ajaxU.responseText;
					if(_res.search("�ɹ�")==0)
						 location.href="http://sky/sites/usr";			 
					 
				}else{
				 alert("��������æ�����Ժ�����");
				}
		}	 
	}
	
		 
 
 
		function varify($type){
 			_type=$type;
 			
			if(_type=="pass2"){
				if(!_varifyPass()) 
					document.getElementById('_pass2Notify').innerHTML="���벻һ��";
				else {
					document.getElementById('_pass2Notify').innerHTML="";
					var _notify=document.getElementById('_pass1Notify').innerHTML;
					if(_notify.search("����")==0)
						document.getElementById('_pass2Notify').innerHTML="����";
				}
				return;
			}
			if($type=="pass1") _type="pass";
			$send="varify.php?";
			
			if(_type=="usrEmail") {
				$usr=encodeURIComponent(document.getElementById('_name').value);
				$email=encodeURIComponent(document.getElementById('_email').value);
				$send+="type=usrEmail&usr="+$usr+"&email="+$email;
			}
			if(_type=="pass") {
				$value=encodeURIComponent(document.getElementById('_pass1').value);
				$send+="type=pass&value="+$value;
			}
	 	 	_ajaxV=createAjax();
			if(!_ajaxV){
				alert('ʹ�ò�����XMLHttpRequest�������');
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
		 	document.getElementById('_pass1').value="";
			document.getElementById('_pass2').value="";
	 		document.getElementById('_pass1Notify').innerHTML="";
			document.getElementById('_pass2Notify').innerHTML="";
		}
		function update(){
			varify('pass2');
	 	 	var _pass1=document.getElementById('_pass1Notify').innerHTML;
			var _pass2=document.getElementById('_pass2Notify').innerHTML;			
			 
	 		if(_pass1.search("����")==0)
						if(_pass2.search("����")==0){
			 	$name=encodeURIComponent(document.getElementById('_name').value);		  	 
			 	$pass=encodeURIComponent(document.getElementById('_pass1').value);
				$send="update.php?name="+$name+"&pass="+$pass;
				_ajaxU=createAjax();
				if(!_ajaxU){
					alert('ʹ�ò�����XMLHttpRequest�������');
					return 0;
				}
				//alert('ʹ�ò�����XMLHttpRequest�������');
		 		_ajaxU.onreadystatechange=_showUpdate;
				_ajaxU.open("GET",$send,true);	
				_ajaxU.send();	
			 }
		}
		function _Enter($type){
			if($type=="varify"){
		 		$name=encodeURIComponent(document.getElementById('_name').value);
				$email=encodeURIComponent(document.getElementById('_email').value);
				
				if($name=="") document.getElementById("_name").focus();
				else if($email=="") document.getElementById("_email").focus();
				else varify("usrEmail");
			}
			if($type="update"){
				$pass1=encodeURIComponent(document.getElementById('_pass1').value);
				$pass2=encodeURIComponent(document.getElementById('_pass2').value);
				if($pass1=="") document.getElementById("_pass1").focus();
				else if($pass2=="") document.getElementById("_pass2").focus();
				else update();
			}
							
		}
		
		function _click(_type){
			 if(_type=="��ҳ")location.href="http://sky/sites/usr";
		}
		function onLoad(){
			_Enter('varify');
		}
		</script>
</head>
<body   onload="load()">
   
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
	  	<legend  id="_show" align="center">�һ����� </legend>
 
	  	<table align="center">
	  	<tr>
			<td>�û���:</td><td><input type="text" id="_name" autocomplete="off" onkeypress="javascript:if(event.keyCode==13) _Enter('varify');"></input></td><td><p id="_nameNotify"></p></td>
		</tr>
	 	<tr>
			<td>���䣺</td><td><input type="text" id="_email"  autocomplete="off" onkeypress="javascript:if(event.keyCode==13) _Enter('varify');"></input></td><td><p id="_emailNotify"></p></td>
		</tr>
		<tr>
			<td></td><td align="center"><input type="button" id="_varify"  value="��֤" onclick="varify('usrEmail')" ></input></td>
		</tr>
		
 
	 	<tr  id="_showPass1" style="display:none">
			<td>������:</td><td><input disabled="true"   type="password" id="_pass1" onkeyup="varify('pass1')" onkeypress="javascript:if(event.keyCode==13) _Enter('update');"></input></td><td><p id="_pass1Notify"></p></td>
		</tr>
		<tr  id="_showPass2"  style="display:none">
			<td>ȷ������:</td><td><input  disabled="true" type="password"  id="_pass2" onkeyup="varify('pass2')" onkeypress="javascript:if(event.keyCode==13) _Enter('update');"></input></td><td><p id="_pass2Notify"></p></td> 
		</tr>
		<tr id="_showPass3"  style="display:none">
			<td></td><td><input type="button" id="_update" disabled="true" value="ȷ��" onclick="update()"> </input><input type="button" disabled="true" id="_clear"  value="���" onclick="_clear()" > </input></td> 
		</tr>
		</table>
  </fieldset> 
	 </div>

<div id="sidebar"></div>
 
<div id="footer" align="center">��Ȩ���У���ƣ��绰��15828540155�����䣺<a href="mailto:15828540155@139.com">15828540155@139.com</a></div>
</body>
</html>
