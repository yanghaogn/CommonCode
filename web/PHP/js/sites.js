var ajaxNavSecond;
 /**********************ajax******************************/
 	function createAjax(){
			if(window.ActiveXObject){
				try{
					return new ActiveXObject("Msxml2.XMLHTTP");
				}catch(e){
					try{
						return new ActiveXObject("Microsoft.XMLHTTP");
					}catch(e2){
						return null;
					}
				}
			}else if(window.XMLHttpRequest){
				return new XMLHttpRequest();
			}else{
				return null;
			}
}
/****************************load***************************************/
function load(){
	onLoad();
 
	document.getElementById("navsecond").innerHTML="Hot Software";
 loadNavSecond();

}
/**************************设置cookie*******************************/
function   setCookie(name,   value)   { 
      var   today   =   new   Date(); 
      var   expires   =   new   Date(); 
      expires.setTime(today.getTime()   +   1000*60*60*24*365); 
      document.cookie   =   name   +   "= "   +   escape(value)         +   ";   expires= "   +   expires.toGMTString(); 
} 
 function getCookie(Name) 
{ 
var search = Name + "=" 
if(document.cookie.length > 0) 
{ 
   offset = document.cookie.indexOf(search) 
   if(offset != -1) 
{ 
offset += search.length 
end = document.cookie.indexOf(";", offset) 
if(end == -1) end = document.cookie.length 
   return unescape(document.cookie.substring(offset, end)) 
} 
else return "" 
} 
} 
/******************************加载侧边栏*************************************/
function loadNavSecond(){ 
	//alert('使用不兼容XMLHttpRequest的浏览器');
			ajaxNavSecond=createAjax();
			if(!ajaxNavSecond){
				alert('使用不兼容XMLHttpRequest的浏览器');
				return 0;
			}
			$send="http://sky/software";
			ajaxNavSecond.onreadystatechange=onLoadNavSecond;
		 
			ajaxNavSecond.open("GET",$send,true);	
			ajaxNavSecond.send();	
								
		}
function onLoadNavSecond(){
			if(ajaxNavSecond.readyState==4){
				if(ajaxNavSecond.status==200){
			 		var res=ajaxNavSecond.responseText;
			 		document.getElementById("navsecond").innerHTML=res;
			 		//document.getElementById("sidebar").innerHTML=res;
				}else{
					 
				}
			}			 
}