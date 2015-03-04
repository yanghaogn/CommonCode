<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	 
</head>
<body   >
   <fieldset >
	  	<legend  id="_showUsrInfo" align="center">用户信息 </legend>
 
	  	<table align="center">
	  	<tr>
			<td>用户名:</td><td><input type="text" id="_usrName" disabled="true" autocomplete="off"  ></input></td><td></td>
		</tr>
		<tr>
			<td>性别:</td><td><input type="radio" id="_usrMan" name="_usrSex"  checked="true" >男</input><input type="radio" id="_usrWoman" name="_usrSex" >女</input></td>
		</tr>
		<tr>
			<td>邮箱</td><td><input type="text" id="_usrEmail"    autocomplete="off" onkeypress="javascript:if(event.keyCode==13) updateUsr();"></input></td><td><p id="_usrEmailNotify"></p></td>
		</tr>
		<tr>
			<td></td><td><input type="button" id="_updateUsr"  value="更新" onclick="updateUsr()"> </input></td> 
		</tr>
	 	</table>
  </fieldset>
   <fieldset align="center">
	  	<legend  id="_showUsrPass" align="center">修改密码 </legend>
 
	  	<table align="center">
	 	 	<tr>
			<td>密码：</td><td><input type="password" id="_usrPass"  autocomplete="off" onkeypress="javascript:if(event.keyCode==13) varifyPass('pass');"></input></td><td><input type="button" id="_varifyPass"  value="验证" onclick="varifyPass('pass')" ></input></td>
		</tr>
	 
		
 
	 	<tr  id="_showPass1" style="display:none">
			<td>新密码:</td><td><input     type="password" id="_usrPass1" onkeyup="varifyPass('pass1')" onkeypress="javascript:if(event.keyCode==13) enterPass();"></input></td><td><p id="_pass1Notify"></p></td>
		</tr>
		<tr  id="_showPass2"  style="display:none" >
			<td>确认密码:</td><td><input  type="password"  id="_usrPass2" onkeyup="varifyPass('pass2')" onkeypress="javascript:if(event.keyCode==13) enterPass();"></input></td><td><p id="_pass2Notify"></p></td> 
		</tr>
		<tr id="_showPass3" style="display:none"  >
			<td></td><td><input type="button" id="_updateUsrPass"   value="确定" onclick="updatePass()"> </input><input type="button"     value="清空" onclick="clearUsrPass()" </td> 
		</tr>
		</table>
  </fieldset>
    
</body>
</html>
