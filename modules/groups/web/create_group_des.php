<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}
?>

<input type="hidden" value="0" id="theValue1" />
<script type="text/javascript">

    function addSender()
    {
        var ni = document.getElementById('myDiv1');
        var numi = document.getElementById('theValue1');
        var num = (document.getElementById("theValue1").value -1)+ 2;
        numi.value = num;
        var divIdName = "my"+num+"Div1";
        var newdiv = document.createElement('div');
        newdiv.setAttribute("id",divIdName);
        newdiv.innerHTML = "<font face=\"Trebuchet MS\" size=\"2\">Mobile:&nbsp;<input type=\"text\" name=\"senders[]\" size=\"15\">&nbsp;<a href=\"javascript:;\" onclick=\"javascipt:addSender();\">ADD</a>&nbsp;|&nbsp;<a href=\"javascript:;\" onclick=\"removeSender(\'"+divIdName+"\')\">DELETE</a><br><br></font>";
        ni.appendChild(newdiv);
    }

    function removeSender(divNum)
    {
        var d = document.getElementById('myDiv1');
        var olddiv = document.getElementById(divNum);
        d.removeChild(olddiv);
    }

</script>

<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,name,Required : Name.");
    rules.push("length<=100,name,Name : < 100 chars please.");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    Fill in the Group Name and Description. This information will be used internally to identify the group, but does not appear publicly.
		</font></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Group Name<font color="#FF0000">
			*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input name="name" size="35" /></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <?php if($param_session_sys_public == 1 || $param_session_sys_public == '1') {?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Public Group</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <select name="pgrp" style="width:245px;">
                    <option value="0">False</option>
                    <option value="1">True</option>
                </select>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
		<textarea rows="4" name="description" cols="60"></textarea></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
		<font face="Trebuchet MS" size="2">
		    <b>Permission to Mobile numbers</b>
		    <br>Authorize Users to send messages to this group from their mobile phone (optional). Enter a mobile number and click on ADD.
		</font>
	    </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
		<div id="myDiv1">
		<font face="Trebuchet MS" size="2"><font style="font-size:7pt;">Please note: enter mobile numbers with country code, area code and the number. Do not use spaces or symbols.<br></font>Mobile:&nbsp;<input type="text" name="senders[]" size="15">&nbsp;<a href="javascript:;" onclick="javascipt:addSender();">ADD</a><br><br></font>
		</div>
	    </td>
        </tr>
        <tr>
            <td width="48%" colspan="3"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input type="submit" value="Create Group" name="submit"/></font></span></font></td>
        </tr>
    </table>
</form>