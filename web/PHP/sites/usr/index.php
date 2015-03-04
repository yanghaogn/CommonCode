<?php 
	 session_start();
	$name=$_SESSION["_currentUsr"];
 	 if(isset($name))	;
	else header('Location: http://sky/sites/login');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
   <title>用户</title>
   <link rel="stylesheet" type="text/css" href="http://sky/css/sites.css">
    <script type="text/javascript" src="http://sky/js/sites.js"></script>	 
    <script language="javascript" src="./main.js"></script>
   <script language="Javascript">
		var _iS,_ajaxOut,_ajaxUpdateSite,_ajaxUsrInfo,ajaxUsr,ajaxSite;
		var usr,sex,email,pass;
		
	 
		function _click(_type){
			 if(_type=="首页")location.href="http://sky/sites/usr";
			 if(_type=="资料"){
			 		
			 	 	_ajaxUsrInfo=createAjax();
					if(!_ajaxUsrInfo){
						alert('使用不兼容XMLHttpRequest的浏览器');
						return 0;
					}
					$send="usrInfo.php?type=usrInfo";
					_ajaxUsrInfo.onreadystatechange=onUsrInfo;
					_ajaxUsrInfo.open("GET",$send,true);	
					_ajaxUsrInfo.send();
			 }
			 if(_type=="用户"){
			 	document.getElementById("maincontent").innerHTML="正在加载，请稍等．．．．．";
			 	ajaxUsr=createAjax();
					if(!ajaxUsr){
						alert('使用不兼容XMLHttpRequest的浏览器');
						return 0;
					}
					$send="searchUsr.php";
					ajaxUsr.onreadystatechange=onUsr;
					ajaxUsr.open("GET",$send,true);	
					ajaxUsr.send();
			 }
			 if(_type=="网址"){
			 	document.getElementById("maincontent").innerHTML="正在加载，请稍等．．．．．";
			 	//alert('使用不兼容XMLHttpRequest的浏览器');
			 	ajaxSite=createAjax();
					if(!ajaxSite){
						alert('使用不兼容XMLHttpRequest的浏览器');
						return 0;
					}
					//alert('使用不兼容XMLHttpRequest的浏览器');
					$send="searchSite.php";
					ajaxSite.onreadystatechange=onSite;
					ajaxSite.open("GET",$send,true);	
					ajaxSite.send();
			 }
			 if(_type=="退出"){
			 		 _ajaxOut=createAjax();
					if(!_ajaxOut){
						alert('使用不兼容XMLHttpRequest的浏览器');
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
					// alert('使用不兼容XMLHttpRequest的浏览器');
					 document.getElementById('maincontent').innerHTML=ajaxSite.responseText;
					 document.getElementById('_srchSiteText').focus();
					 srchSite();
			 
					 
				}else{
					//document.getElementById('_gShow').innerHTML="添加错误，请重试";
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
					//document.getElementById('_gShow').innerHTML="添加错误，请重试";
				}
			 }	
		}
		function onUsrInfo(){
			if(_ajaxUsrInfo.readyState==4){
				if(_ajaxUsrInfo.status==200){
					 
					 document.getElementById('maincontent').innerHTML=_ajaxUsrInfo.responseText;
				
					 document.getElementById('_usrName').value=usr;
					 document.getElementById('_usrEmail').value=email;
					 if(sex=="男") document.getElementById("_usrMan").checked=true;
					 else document.getElementById("_usrWoman").checked=true;
					 document.getElementById("_usrEmail").focus();
					 
				}else{
					document.getElementById('_gShow').innerHTML="添加错误，请重试";
				}
			 }	
		}
		function onOut(){
			if(_ajaxOut.readyState==4){
				if(_ajaxOut.status==200){
					 location.href="http://sky/sites/login";
				}else{
					document.getElementById('_gShow').innerHTML="添加错误，请重试";
				}
			 }	
		}
		function clkUsrSite($type){
			 //alert($type);
			document.getElementById("_changeAddr").value=document.getElementById("_"+$type).value;
			document.getElementById("_changeName").value=$type;
			document.getElementById("_changeInfo").value=document.getElementById($type).title;
			document.getElementById('_manageSite').innerHTML="管理网页";
		}
		 function  updateSite(){
			$addr=document.getElementById("_changeAddr").value;
			$name=encodeURIComponent(document.getElementById('_changeName').value);
			$info=encodeURIComponent(document.getElementById('_changeInfo').value);
			if($name=="") return;
			if($addr=="") return;
			 _ajaxUpdateSite=createAjax();
			if(!_ajaxUpdateSite){
				alert('使用不兼容XMLHttpRequest的浏览器');
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
					 
					document.getElementById('_manageSite').innerHTML="修改成功";
			 		 
					displaySites();
					
				}else{
					document.getElementById('_sG').innerHTML="无法显示页面";
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
			<li id="h"><h1 size='500'  style="cursor: pointer" onclick="_click('首页')">首页</h1></li>
			<li id="x"><h1 size='500'  style="cursor: pointer" onclick="_click('资料')">资料</h1></li>
			<li id="b"><h1 size='500'  style="cursor: pointer;display:none" onclick="_click('用户')" id="mainUsr">用户</h1></li>
			<li id="s"><h1 size='500'  style="cursor: pointer;display:none" onclick="_click('网址')" id="mainSite">网址</h1></li>
			<li id="w"><h1 size='500'  style="cursor: pointer" onclick="_click('退出')">退出</h1></li>
		</ul>
		 
	</div>
	<div id="navfirst" align="right"></div>
	<div id="navsecond">广告</div>
	<div id="maincontent" >
			<p align="center">
				<input type="button" value="自己" onclick="clickSearchUsr()"></input>
				<input type="button" value="全网" onclick="clickSearchAll()"></input>
			
			 	<br/>
				<input type="text" id="usrKeyWord" onkeypress="javascript:if(event.keyCode==13) search();"></input>
				<input type="button" value="搜索" onclick="search()"></input>
			</p>
	<div id="_usrSearchAll" style="display:none"></div>
	<div id="_usrSearchDiv">
		<fieldset   align="center">
			<legend align="center" >用户已添加的网页</legend>
		
			<p id="_showUsr" align="center" width="90%">用户还没有添加网页</p>	 
		 	<p align="right"><a align="right" id="_addHiteSite" onclick="addHideSite()" style="cursor: pointer">添加v</a></p>
		 </fieldset>
	 
		 <div id="_addUsrSite" style="display: none">
	 	 <p id="_addNotify" align="center"></p> 
	  	 <table>	 
	  		<tr>
				<td>网页:</td><td><input type="text" size="70" id="_addAddr" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input></td> 
			</tr>
			<tr>
				<td>名字:</td><td><input type="text" size="40" id="_addName" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input></td> 
			</tr>
			<tr>
				<td>描述:</td><td><input type="text"  size="70" id="_addInfo" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input> </td>
			</tr>
		 
			<tr>
				<td></td><td> <input type="button" id="_addOK" value="添加"  onclick="addSite()"></input>
								<input type="button" id="_addClear" value="清空"  onclick="addClear()"></input></td> 
			</tr>
	 	</table>
	 	</div>
	 
	 
		 <fieldset   align="center">
			<legend align="center" id="_manageSite">管理网页</legend>
			 <table align="center">	 
		  	<tr>
				<td>网页:</td><td><input type="text" id="_changeAddr" disabled="true" ></input></td> 
			</tr>
			<tr>
				<td>名字:</td><td><input type="text" id="_changeName"  ></input></td> 
			</tr>
			<tr>
				<td>描述:</td><td><input type="text" id="_changeInfo" onkeypress="javascript:if(event.keyCode==13) _addEnter();"></input> </td>
			</tr>
		 
			<tr>
				<td></td><td> <input type="button" id="_updateOK" value="修改"  onclick="updateSite()"></input>
								<input type="button" id="_deleteOK" value="删除"  onclick="delSite()"></input></td> 
			</tr>
	 		</table>
	 
	 	</fieldset>
	 </div>
	 </div>

<div id="sidebar"> 
	 
</div>
 
<div id="footer" align="center">版权所有：杨浩，电话：15828540155，邮箱：<a href="mailto:15828540155@139.com">15828540155@139.com</a></div>
</body>
</html>
