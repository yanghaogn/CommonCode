<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	 
</head>
<body   >
   <fieldset >
	  	<legend  id="_showUsrInfo" align="center">�û���Ϣ </legend>
 
	  	<table align="center">
	  	<tr>
			<td>�û���:</td><td><input type="text" id="_usrName" disabled="true" autocomplete="off"  ></input></td><td></td>
		</tr>
		<tr>
			<td>�Ա�:</td><td><input type="radio" id="_usrMan" name="_usrSex"  checked="true" >��</input><input type="radio" id="_usrWoman" name="_usrSex" >Ů</input></td>
		</tr>
		<tr>
			<td>����</td><td><input type="text" id="_usrEmail"    autocomplete="off" onkeypress="javascript:if(event.keyCode==13) updateUsr();"></input></td><td><p id="_usrEmailNotify"></p></td>
		</tr>
		<tr>
			<td></td><td><input type="button" id="_updateUsr"  value="����" onclick="updateUsr()"> </input></td> 
		</tr>
	 	</table>
  </fieldset>
   <fieldset align="center">
	  	<legend  id="_showUsrPass" align="center">�޸����� </legend>
 
	  	<table align="center">
	 	 	<tr>
			<td>���룺</td><td><input type="password" id="_usrPass"  autocomplete="off" onkeypress="javascript:if(event.keyCode==13) varifyPass('pass');"></input></td><td><input type="button" id="_varifyPass"  value="��֤" onclick="varifyPass('pass')" ></input></td>
		</tr>
	 
		
 
	 	<tr  id="_showPass1" style="display:none">
			<td>������:</td><td><input     type="password" id="_usrPass1" onkeyup="varifyPass('pass1')" onkeypress="javascript:if(event.keyCode==13) enterPass();"></input></td><td><p id="_pass1Notify"></p></td>
		</tr>
		<tr  id="_showPass2"  style="display:none" >
			<td>ȷ������:</td><td><input  type="password"  id="_usrPass2" onkeyup="varifyPass('pass2')" onkeypress="javascript:if(event.keyCode==13) enterPass();"></input></td><td><p id="_pass2Notify"></p></td> 
		</tr>
		<tr id="_showPass3" style="display:none"  >
			<td></td><td><input type="button" id="_updateUsrPass"   value="ȷ��" onclick="updatePass()"> </input><input type="button"     value="���" onclick="clearUsrPass()" </td> 
		</tr>
		</table>
  </fieldset>
    
</body>
</html>
