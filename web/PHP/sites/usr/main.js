var  _ajaxAdd,ajaxDel,ajaxUsr,ajaxEmail,ajaxSex,ajaxPass,ajaxUpdateUsr,ajaxPass,ajaxUpdatePass,_ajaxHot,_dS,ajaxSrchUsr,ajaxSrchSite;
/**************************用户信息*******************************************/
function getUsr(){ 
			ajaxUsr=createAjax();
			if(!ajaxUsr){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=getUsr";
			ajaxUsr.onreadystatechange=onGetUsr;
			//alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxUsr.open("GET",$send,true);	
			ajaxUsr.send();	
								
		}
function onGetUsr(){
			if(ajaxUsr.readyState==4){
				if(ajaxUsr.status==200){
			 		usr=ajaxUsr.responseText;
				 if(usr=="admin"){
 						document.getElementById("mainUsr").style.display="inherit";
 						document.getElementById("mainSite").style.display="inherit";
 				}
  
				}else{
					usr="";
				}
			}			 
}
function getEmail(){ 
			ajaxEmail=createAjax();
			if(!ajaxUsr){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=getEmail";
			ajaxEmail.onreadystatechange=onGetEmail;
			//alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxEmail.open("GET",$send,true);	
			ajaxEmail.send();	
								
		}
function onGetEmail(){
			if(ajaxEmail.readyState==4){
				if(ajaxEmail.status==200){
			 		email=ajaxEmail.responseText;
				 //alert(email);
  
				}else{
					email="";
				}
			}			 
}
function getSex(){ 
			ajaxSex=createAjax();
			if(!ajaxSex){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=getSex";
			ajaxSex.onreadystatechange=onGetSex;
			//alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxSex.open("GET",$send,true);	
			ajaxSex.send();	
								
		}
function onGetSex(){
			if(ajaxSex.readyState==4){
				if(ajaxSex.status==200){
			 		sex=ajaxSex.responseText;
			//	 alert(sex);
  
				}else{
					sex="";
				}
			}			 
}	
function getPass(){ 
			ajaxPass=createAjax();
			if(!ajaxPass){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=getPass";
			ajaxPass.onreadystatechange=onGetPass;
	 		ajaxPass.open("GET",$send,true);	
			ajaxPass.send();	
								
		}
function onGetPass(){
			if(ajaxPass.readyState==4){
				if(ajaxPass.status==200){
			 		pass=ajaxPass.responseText;
			//	 alert(pass);
  
				}else{
					pass="";
				}
			}			 
}
/************************添加网页**************************************/

function addClear(){
		document.getElementById("_addAddr").value="";  		
		document.getElementById("_addName").value="";
		document.getElementById("_addInfo").value="";  
		document.getElementById("_addNotify").innerHTML=""; 
 
		document.getElementById("_addAddr").focus();
		
  	}
  	function _addEnter(){
		$addr=document.getElementById("_addAddr").value;  		
		$name=document.getElementById("_addName").value;
		$info=document.getElementById("_addInfo").value;  
		if($addr=="")		document.getElementById("_addAddr").focus();	
		else if($name=="") document.getElementById("_addName").focus();
		else if($info=="") {
			document.getElementById("_addInfo").value=document.getElementById("_addName").value;
			document.getElementById("_addInfo").focus();
		}
		else	addSite();
  	}
  	function addSite(){ 
			$addr=encodeURIComponent(document.getElementById('_addAddr').value);
			$name=encodeURIComponent(document.getElementById('_addName').value);
			$info=encodeURIComponent(document.getElementById('_addInfo').value);
		  	if($addr=="") {
		 		document.getElementById('_addNotify').innerHTML="请输入网页";
		 		return;
		 	}
		 	if($name=="") {
		 		document.getElementById('_addNotify').innerHTML="请输入网页名";
		 		return;
		 	}
			_ajaxAdd=createAjax();
			if(!_ajaxAdd){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="addSite.php?type=addr&name="+$name+"&addr="+$addr+"&info="+$info;
			_ajaxAdd.onreadystatechange=onAddSite;
			//alert('使用不兼容XMLHttpRequest的浏览器');
			_ajaxAdd.open("GET",$send,true);	
			_ajaxAdd.send();	
								
		}
  	function onAddSite(){
			if(_ajaxAdd.readyState==4){
				if(_ajaxAdd.status==200){
				// 	alert(_ajaxAdd.responseText);
					var res=_ajaxAdd.responseText;
					if(res.search("成功")==0) addClear();
					document.getElementById('_addNotify').innerHTML=_ajaxAdd.responseText;
					displaySites();
  
				}else{
					document.getElementById('_addNotify').innerHTML="添加错误，请重试";
				}
			}			 
		}
  	/*********************时钟**********************************/
function tick() {
   			var hours, minutes, seconds;
   			var today, theday;
   			today = new Date();
   			function initArray(){
   				this.length=initArray.arguments.length
   				for(var i=0;i<this.length;i++)
   				this[i+1]=initArray.arguments[i] 
   			}
   			var d=new initArray(
   				" 星期日",
   				" 星期一",
   				" 星期二",
   				" 星期三",
   				" 星期四",
   				" 星期五",
   				" 星期六");
   			theday = today.getFullYear()+"年" + [today.getMonth()+1]+"月" +today.getDate()+"日" + d[today.getDay()+1];
   			hours = today.getHours();
   			minutes = today.getMinutes();
   			if(minutes<10) minutes="0"+minutes;
   			seconds = today.getSeconds();
   
 			  	timeString = theday+" "+hours+":"+minutes+":"+seconds;
    			document.getElementById('navfirst').innerHTML=timeString;
   			window.setTimeout("tick();", 100);
   }
  /***************************搜索网页*************************************/
  function search(){
  		$current=document.getElementById('_usrSearchAll').style.display;
  	 //alert($current);
		 if($current=="none") displaySites();
		 else displayHots(0,10);
  	}
  	function clickSearchUsr(){
  		//alert("");
  			document.getElementById("usrKeyWord").value="";
 			document.getElementById("_usrSearchDiv").style.display="block";
 			document.getElementById("_usrSearchAll").style.display="none";
 			displaySites();
 		}
 		function clickSearchAll(){
 			//displaySites();
 			document.getElementById("usrKeyWord").value="";
 			document.getElementById("_usrSearchDiv").style.display="none";
 			document.getElementById("_usrSearchAll").style.display="block";
 			displayHots(0,10);
 		}
  	function displaySites(){
			 _dS=createAjax();
			 $key=encodeURIComponent(document.getElementById('usrKeyWord').value);
			if(!_dS){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="displayWebsite.php?type=usr&num=5&key="+$key;
			_dS.onreadystatechange=onDisplaySites;
			_dS.open("GET",$send,true);	
			_dS.send();						
		}
  function onDisplaySites(){
			if(_dS.readyState==4){
				if(_dS.status==200){
					document.getElementById('_showUsr').innerHTML=_dS.responseText;
				}else{
					document.getElementById('_sG').innerHTML="无法显示页面";
				}
			}
			 
		}
	
 
 
	
		function displayHots($n1,$n2){
			 _ajaxHot=createAjax();
			if(!_ajaxHot){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			 $key=encodeURIComponent(document.getElementById('usrKeyWord').value);
			$send="displayWebsite.php?type=all&n1="+$n1+"&n2="+$n2+"&key="+$key;
			_ajaxHot.onreadystatechange=onDisplayHots;
			_ajaxHot.open("GET",$send,true);	
			_ajaxHot.send();						
		}
		function onDisplayHots(){
			if(_ajaxHot.readyState==4){
				if(_ajaxHot.status==200){
					document.getElementById('_usrSearchAll').innerHTML=_ajaxHot.responseText;
				}else{
					document.getElementById('_usrSearchAll').innerHTML="请换一个关键字，再进行搜索";
				}
			}
			 
		}
 /**************************删除网页**********************************/
 function  delSite(){
			$addr=document.getElementById("_changeAddr").value;
			if($addr=="") return;
			 _ajaxDel=createAjax();
			if(!_ajaxDel){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
		 
			$send="main.php?type=delUsrSite&addr="+$addr;
		 
			_ajaxDel.onreadystatechange=onDelSite;
			_ajaxDel.open("GET",$send,true);	
			_ajaxDel.send();	
		}
		function onDelSite(){
			if(_ajaxDel.readyState==4){
				if(_ajaxDel.status==200){					 
					document.getElementById('_manageSite').innerHTML="删除成功";
					document.getElementById("_changeAddr").value="";
					document.getElementById("_changeName").value="";
					document.getElementById("_changeInfo").value="";					 
					displaySites();
					
				}else{
					document.getElementById('_sG').innerHTML="无法显示页面";
				}
			}
		}
/***************************修改用户信息**************************************/
function updateUsr(){ 
			$email=document.getElementById('_usrEmail').value;
			if(document.getElementById('_usrMan').checked)	$sex="男";
			else $sex="女";
			if($email==email)
				if($sex==sex) return;
			$email=encodeURIComponent($email);
			$sex=encodeURIComponent($sex);
			if($email=="") return;
		 
			_ajaxUpdateUsr=createAjax();
			if(!_ajaxUpdateUsr){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=updateUsr&sex="+$sex+"&email="+$email;
			_ajaxUpdateUsr.onreadystatechange=onUpdateUsr;
		 	_ajaxUpdateUsr.open("GET",$send,true);	
			_ajaxUpdateUsr.send();	
								
		}
  	function onUpdateUsr(){
			if(_ajaxUpdateUsr.readyState==4){
				if(_ajaxUpdateUsr.status==200){
			 			var res=_ajaxUpdateUsr.responseText;
						//alert(res);
					if(res.search("成功")==0) {
						document.getElementById("_showUsrInfo").innerHTML="修改成功";
						email=document.getElementById("_usrEmail").value;
						if(document.getElementById('_usrMan').checked)	sex="男";
								else sex="女";
							 
						
					}
					else if(res.search("存在")==0) document.getElementById("_usrEmailNotify").innerHTML="邮箱已被注册";
					else document.getElementById("_usrEmailNotify").innerHTML="邮箱不可用";
			 
  
				}else{
					//document.getElementById('_addNotify').innerHTML="添加错误，请重试";
				}
			}			 
		}
/**************************pass**********************************/
 
function varifyPass($type){
	if($type=="pass"){
		$pass=document.getElementById("_usrPass").value; 
		if($pass==pass){
			document.getElementById("_showPass1").style.display="table-row";
			document.getElementById("_showPass2").style.display="table-row";
			document.getElementById("_showPass3").style.display="table-row";
			document.getElementById("_usrPass").disabled=true;
			document.getElementById("_varifyPass").style.display="none";
			document.getElementById("_usrPass1").focus();
		}
	}
	if($type=="pass1"){
		var pass1=document.getElementById("_usrPass1").value; 
		if(pass1=="") {
			document.getElementById("_pass1Notify").innerHTML="";
			document.getElementById("_pass2Notify").innerHTML="";
		}
		else if(pass1.length<4) {
			document.getElementById("_pass1Notify").innerHTML="密码过短";
			document.getElementById("_pass2Notify").innerHTML="";
		}
		else if(pass1.length>15) {
			document.getElementById("_pass1Notify").innerHTML="密码过长";
			document.getElementById("_pass2Notify").innerHTML="";
		}
		else document.getElementById("_pass1Notify").innerHTML="可用";
	}
	if($type=="pass2"){
		//alert();
		$pass1=document.getElementById("_usrPass1").value; 
		$pass2=document.getElementById("_usrPass2").value; 
		var pass1Notify=document.getElementById("_pass1Notify").innerHTML;
		if(pass1Notify.search("可用")==0){ 
			if($pass2=="") document.getElementById("_pass2Notify").innerHTML="";
			else if($pass2==$pass1) document.getElementById("_pass2Notify").innerHTML="可用";
			else  document.getElementById("_pass2Notify").innerHTML="两次密码不一样";
		}		 
	}	
}
function enterPass(){
	$pass1=document.getElementById("_usrPass1").value; 
	$pass2=document.getElementById("_usrPass2").value;
	if($pass1=="")  document.getElementById("_usrPass1").focus();
	else if($pass2=="") document.getElementById("_usrPass2").focus();
	else updatePass();	
}
function updatePass(){
	//alert("改写成过哦你");
	var pass1Notify=document.getElementById("_pass1Notify").innerHTML; 
	var pass2Notify=document.getElementById("_pass2Notify").innerHTML;
	if(pass1Notify.search("可用")==0)
		if(pass2Notify.search("可用")==0){
			$pass=document.getElementById("_usrPass2").value;
			ajaxUpdatePass=createAjax();
			if(!ajaxUpdatePass){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="main.php?type=updatePass&pass="+$pass;
			ajaxUpdatePass.onreadystatechange=onUpdatePass;
		 	ajaxUpdatePass.open("GET",$send,true);	
			ajaxUpdatePass.send();
			
	}
	
}
function onUpdatePass(){
			if(ajaxUpdatePass.readyState==4){
				if(ajaxUpdatePass.status==200){
			 			var res=ajaxUpdatePass.responseText;
			 			if(res.search("成功")==0){			 	
			 				pass=document.getElementById("_usrPass2").value;			 				
			 				document.getElementById("_usrPass").value=pass;		
			 				clearUsrPass();		
			 				document.getElementById("_showUsrPass").innerHTML="更改成功";
			 			}			  
				}else{
				 
				}
			}			 
}
function clearUsrPass(){
	document.getElementById("_usrPass1").value="";
	document.getElementById("_usrPass2").value="";
	document.getElementById("_pass1Notify").innerHTML="";
	document.getElementById("_pass2Notify").innerHTML="";
	document.getElementById("_showUsrPass").innerHTML="修改密码";
	document.getElementById("_usrPass1").focus();
}

/****************************添加网页****************************/
function addHideSite( ) {
				// window.open('addsite.html','添加网页','width=400,height=200,top=110,left=100,location=no');
	 $current=document.getElementById('_addUsrSite').style.display;
	 if($current=="none") {
	 	document.getElementById('_addUsrSite').style.display="block";
	 	document.getElementById('_addHiteSite').innerHTML="收起^";
	 }
	 else{ 
	 	document.getElementById('_addUsrSite').style.display="none";
	 	document.getElementById('_addHiteSite').innerHTML="添加v";
	 	
	 }
}
/****************************搜索用户*****************************/
function srchUsr(){ 
			ajaxSrchUsr=createAjax();
			if(!ajaxSrchUsr){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$key=encodeURIComponent(document.getElementById('_srchUsrText').value);
		 
 
			$send="main.php?type=srchUsr&key="+$key;
			ajaxSrchUsr.onreadystatechange=onSrchUsr;
			// alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxSrchUsr.open("GET",$send,true);	
			ajaxSrchUsr.send();	
								
		}
function onSrchUsr(){
			if(ajaxSrchUsr.readyState==4){
				if(ajaxSrchUsr.status==200){
				 
			 		var res=ajaxSrchUsr.responseText;
			 		document.getElementById("_srchUsrDisplay").innerHTML=res;
				 
  
				}else{
					 
				}
			}			 
}
/**********************搜索网址***************************************/
function srchSite(){ 
			ajaxSrchSite=createAjax();
			if(!ajaxSrchSite){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$key=encodeURIComponent(document.getElementById('_srchSiteText').value);
		// alert('使用不兼容XMLHttpRequest的浏览器');
 
			$send="main.php?type=srchSite&key="+$key;
			ajaxSrchSite.onreadystatechange=onSrchSite;
			// alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxSrchSite.open("GET",$send,true);	
			ajaxSrchSite.send();	
								
		}
function onSrchSite(){
			if(ajaxSrchSite.readyState==4){
				if(ajaxSrchSite.status==200){
				 
			 		var res=ajaxSrchSite.responseText;
			 		document.getElementById("_srchSiteDisplay").innerHTML=res;
				 
  
				}else{
					 
				}
			}			 
}
/************************************打印******************************************/
function printSite(){
		//$key=encodeURIComponent(document.getElementById('_srchSiteText').value);
		// alert('使用不兼容XMLHttpRequest的浏览器');
 
			//$send="main.php?type=srchSite&key="+$key;
		//	window.open($send);
			//document.all.WebBrowser.ExecWB(4,1);
			$print=document.getElementById("_srchSiteDisplay").innerHTML;
			$old=document.body.innerHTML;
			document.body.innerHTML=$print;
			
			window.print();
			document.body.innerHTML=$old;
 
 
	}
	function printUsr(){
		//$key=encodeURIComponent(document.getElementById('_srchSiteText').value);
		// alert('使用不兼容XMLHttpRequest的浏览器');
 
			//$send="main.php?type=srchSite&key="+$key;
		//	window.open($send);
			//document.all.WebBrowser.ExecWB(4,1);
			$print=document.getElementById("_srchUsrDisplay").innerHTML;
			$old=document.body.innerHTML;
			document.body.innerHTML=$print;
			
			window.print();
			document.body.innerHTML=$old;
 
 
	}