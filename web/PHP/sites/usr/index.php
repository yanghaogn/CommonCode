<?php 
	 session_start();
	$name=$_SESSION["_currentUsr"];
 	 if(isset($name))	;
	else header('Location: http://sky/sites/login');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
   <title>�û�</title>
   <link rel="stylesheet" type="text/css" href="http://sky/css/sites.css">
    <script type="text/javascript" src="http://sky/js/sites.js"></script>	 
    <script language="javascript" src="./main.js"></script>
   <script language="Javascript">
		var _iS,_ajaxOut,_ajaxUpdateSite,_ajaxUsrInfo,ajaxUsr,ajaxSite;
		var usr,sex,email,pass;
		
	 
		function _click(_type){
			 if(_type=="��ҳ")location.href="http://sky/sites/usr";
			 if(_type=="����"){
			 		
			 	 	_ajaxUsrInfo=createAjax();
					if(!_ajaxUsrInfo){
						alert('ʹ�ò�����XMLHttpRequest�������');
						return 0;
					}
					$send="usrInfo.php?type=usrInfo";
					_ajaxUsrInfo.onreadystatechange=onUsrInfo;
					_ajaxUsrInfo.open("GET",$send,true);	
					_ajaxUsrInfo.send();
			 }
			 if(_type=="�û�"){
			 	document.getElementById("maincontent").innerHTML="���ڼ��أ����Եȣ���������";
			 	ajaxUsr=createAjax();
					if(!ajaxUsr){
						alert('ʹ�ò�����XMLHttpRequest�������');
						return 0;
					}
					$send="searchUsr.php";
					ajaxUsr.onreadystatechange=onUsr;
					ajaxUsr.open("GET",$send,true);	
					ajaxUsr.send();
			 }
			 if(_type=="��ַ"){
			 	document.getElementById("maincontent").innerHTML="���ڼ��أ����Եȣ���������";
			 	//alert('ʹ�ò�����XMLHttpRequest�������');
			 	ajaxSite=createAjax();
					if(!ajaxSite){
						alert('ʹ�ò�����XMLHttpRequest�������');
						return 0;
					}
					//alert('ʹ�ò�����XMLHttpRequest�������');
					$send="searchSite.php";
					ajaxSite.onreadystatechange=onSite;
					ajaxSite.open("GET",$send,true);	
					ajaxSite.send();
			 }
			 if(_type=="�˳�"){
			 		 _ajaxOut=createAjax();
					if(!_ajaxOut){
						alert('ʹ�ò�����XMLHttpRequest�������');
						return 0;
					}
					$send="main.php?type=out";
					_ajaxOut.onreadystatechange=onOut;
					_ajaxOut.open("GET",$send,true);	
					_ajaxOut.send();	
			 	
			 }
		}
		function onSite(){
			if(ajaxSite.readyState==4){
				if(ajaxSite.status==200){
					// alert('ʹ�ò�����XMLHttpRequest�������');
					 document.getElementById('maincontent').innerHTML=ajaxSite.responseText;
					 document.getElementById('_srchSiteText').focus();
					 srchSite();
			 
					 
				}else{
					//document.getElementById('_gShow').innerHTML="��Ӵ���������";
				}
			 }	
		}
		function onUsr(){
			if(ajaxUsr.readyState==4){
				if(ajaxUsr.status==200){
					 
					 document.getElementById('maincontent').innerHTML=ajaxUsr.responseText;
					 document.getElementById('_srchUsrText').focus();
					 srchUsr();
			 
					 
				}else{
					//document.getElementById('_gShow').innerHTML="��Ӵ���������";
				}
			 }	
		}
		function onUsrInfo(){
			if(_ajaxUsrInfo.readyState==4){
				if(_ajaxUsrInfo.status==200){
					 
					 document.getElementById('maincontent').innerHTML=_ajaxUsrInfo.responseText;
				
					 document.getElementById('_usrName').value=usr;
					 document.getElementById('_usrEmail').value=email;
					 if(sex=="��") document.getElementById("_usrMan").checked=true;
					 else document.getElementById("_usrWoman").checked=true;
					 document.getElementById("_usrEmail").focus();
					 
				}else{
					document.getElementById('_gShow').innerHTML="��Ӵ���������";
				}
			 }	
		}
		function onOut(){
			if(_ajaxOut.readyState==4){
				if(_ajaxOut.status==200){
					 location.href="http://sky/sites/login";
				}else{
					document.getElementById('_gShow').innerHTML="��Ӵ���������";
				}
			 }	
		}
		function clkUsrSite($type){
			 //alert($type);
			document.getElementById("_changeAddr").value=document.getElementById("_"+$type).value;
			document.getElementById("_changeName").value=$type;
			document.getElementById("_changeInfo").value=document.getElementById($type).title;
			document.getElementById('_manageSite').innerHTML="������ҳ";
		}
		 function  updateSite(){
			$addr=document.getElementById("_changeAddr").value;
			$name=encodeURIComponent(document.getElementById('_changeName').value);
			$info=encodeURIComponent(document.getElementById('_changeInfo').value);
			if($name=="") return;
			if($addr=="") return;
			 _ajaxUpdateSite=createAjax();
			if(!_ajaxUpdateSite){
				alert('ʹ�ò�����XMLHttpRequest�������');
				return 0;
			}
			
			$send="main.php?type=updateUsrSite&addr="+$addr+"&name="+$name+"&info="+$info;	
	 	 
			_ajaxUpdateSite.onreadystatechange=onUpdateSite;
			_ajaxUpdateSite.open("GET",$send,true);	
			_ajaxUpdateSite.send();	
		}
		function onUpdateSite(){
			if(_ajaxUpdateSite.readyState==4){
				if(_ajaxUpdateSite.status==200){
					 
					document.getElementById('_manageSite').innerHTML="�޸ĳɹ�";
			 		 
					displaySites();
					
				}else{
					document.getElementById('_sG').innerHTML="�޷���ʾҳ��";
				}
			}
		}
		function onLoad(){
			document.getElementById("usrKeyWord").focus();
			displaySites();
	 
			tick();
 			getUsr();
			getSex();
 			getEmail();
 			getPass();
 			 
		}
 	
		
  		
		</script>
</head>
<body  onload="load()">
   
<div id="wrapper"> 
	<div id="header">
		<ul id="menu">
			<li id="h"><h1 size='500'  style="cursor: pointer" onclick="_click('��ҳ')">��ҳ</h1></li>
			<li id="x"><h1 size='500'  style="cursor: pointer" onclick="_click('����')">����</h1></li>
			<li id="b"><h1 size='500'  style="cursor: pointer;display:none" onclick="_click('�û�')" id="mainUsr">�û�</h1></li>
			<li id="s"><h1 size='500'  style="cursor: pointer;display:none" onclick="_click('��ַ')" id="mainSite">��ַ</h1></li>
			<li id="w"><h1 size='500'  style="cursor: pointer" onclick="_click('�˳�')">�˳�</h1></li>
		</ul>
		 
	</div>
	<div id="navfirst" align="right"></div>
	<div id="navsecond">���</div>
	<div id="maincontent" >
			<p align="center">
				<input type="button" value="�Լ�" onclick="clickSearchUsr()"></input>
				<input type="button" value="ȫ��" onclick="clickSearchAll()"></input>
			
			 	<br/>
				<input type="text" id="usrKeyWord" onkeypress="javascript:if(event.keyCode==13) search();"></input>
				<input type="button" value="����" onclick="search()"></input>
			</p>
	<div id="_usrSearchAll" style="display:none"></div>
	<div id="_usrSearchDiv">
		<fieldset   align="center">
			<legend align="center" >�û�����ӵ���ҳ</legend>
		
			<p id="_showUsr" align="center" width="90%">�û���û�������ҳ</p>	 
		 	<p align="right"><a align="right" id="_addHiteSite" onclick="addHideSite()" style="cursor: pointer">���v</a></p>
		 </fieldset>
	 
		 <div id="_addUsrSite" style="display: none">
	 	 <p id="_addNotify" align="center"></p> 
	  	 <table>	 
	  		<tr>
				<td>��ҳ:</td><td><input type="text" size="70" id="_addAddr" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input></td> 
			</tr>
			<tr>
				<td>����:</td><td><input type="text" size="40" id="_addName" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input></td> 
			</tr>
			<tr>
				<td>����:</td><td><input type="text"  size="70" id="_addInfo" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input> </td>
			</tr>
		 
			<tr>
				<td></td><td> <input type="button" id="_addOK" value="���"  onclick="addSite()"></input>
								<input type="button" id="_addClear" value="���"  onclick="addClear()"></input></td> 
			</tr>
	 	</table>
	 	</div>
	 
	 
		 <fieldset   align="center">
			<legend align="center" id="_manageSite">������ҳ</legend>
			 <table align="center">	 
		  	<tr>
				<td>��ҳ:</td><td><input type="text" id="_changeAddr" disabled="true" ></input></td> 
			</tr>
			<tr>
				<td>����:</td><td><input type="text" id="_changeName"  ></input></td> 
			</tr>
			<tr>
				<td>����:</td><td><input type="text" id="_changeInfo" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input> </td>
			</tr>
		 
			<tr>
				<td></td><td> <input type="button" id="_updateOK" value="�޸�"  onclick="updateSite()"></input>
								<input type="button" id="_deleteOK" value="ɾ��"  onclick="delSite()"></input></td> 
			</tr>
	 		</table>
	 
	 	</fieldset>
	 </div>
	 </div>

<div id="sidebar"> 
	 
</div>
 
<div id="footer" align="center">��Ȩ���У���ƣ��绰��15828540155�����䣺<a href="mailto:15828540155@139.com">15828540155@139.com</a></div>
</body>
</html>
