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
<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,name,Required : Name.");
    rules.push("length<=100,name,Name : < 100 chars please.");

    //Prefix
    rules.push("required,prefix,Required : Prefix.");
    rules.push("letters_only,prefix,Prefix : a-Z only please.");
    rules.push("length=1-4,prefix,Prefix : 1-4 chars");

    //Mobile
    rules.push("digits_only,mobile,Mobile : Digits only please.");
    rules.push("required,mobile,Required : Mobile.");
    rules.push("length<=20,mobile,Mobile : < 20 digits please.");

    //Confirm Mobile
    rules.push("same_as,confirm,mobile,Mobile is not equal to Confirmation Mobile");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    <span lang="en-us">Please fill out the following form to create a new
			system.</span></font></td>
        </tr>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">*
		    Required<span lang="en-us"> field.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">General Information</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">System Name<font color="#FF0000">
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
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Prefix<font color="#FF0000">
			*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS">
                    <span style="font-size: 11pt">
                        <font face="Verdana" style="font-size: 11pt">
			    <input name="prefix" size="35" type="text"/></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Administrator Mobile<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Confirm<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="mobile" size="35" /></td>
            <td width="49%"><input name="confirm" size="35" /></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">System Country<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Default Language<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><select size="1" name="country" style="width:245px;">
<?php
		    $dbid = db_connect();
		    $rs = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language", $dbid);
		    if($row = mysql_fetch_array($rs)) {
			$row_id = $row[0];
			$row_name = $row[1];
			echo "<option value=\"$row_id\">$row_name</option>";
		    }
		    ?>
		</select></td>
            <td width="49%">
                <select size="1" name="language" style="width:245px;">
<?php
$rs1 = mysql_query("SELECT language_id, name FROM tbl_ref_language ORDER BY language_id", $dbid);
		    while($row1 = mysql_fetch_array($rs1)) {
			$row_id = $row1[0];
			$row_name = $row1[1];
			echo "<option value=\"$row_id\">$row_name</option>";
		    }
		    db_close($dbid);
		    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">System Status<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">SMS Sending<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="system_status" style="width:245px;">
                    <option value="1">On</option>
                    <option value="0">Off</option>
                </select>
            </td>
            <td width="49%">
                <select size="1" name="sms_status" style="width:245px;">
                    <option value="1">Enable Sending</option>
                    <option value="0">Disable Sending</option>
                </select>
            </td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Other Info #1 Label<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Other Info #2 Label<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="other_info1" size="35" /></td>
            <td width="49%"><input name="other_info2" size="35" /></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">System Modules</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">
<?php
$dbid = db_connect();
$rs_module = mysql_query("SELECT m.module_id, mt.name FROM tbl_ref_module m, tbl_ref_module_title mt WHERE m.module_id = mt.module_id AND mt.language_id = $param_session_sys_language AND m.module_id <> 1", $dbid);
		    while($row_module = mysql_fetch_array($rs_module)) {
			?>
                    <input type="checkbox" name="module[]" value="<?php echo $row_module[0];?>">&nbsp;<?php echo $row_module[1];?><br>
		    <?php
		    }
		    db_close($dbid);
?>
		</font></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Create System" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo 'index.php';?>')">
	    </td>
        </tr>
    </table>
</form>