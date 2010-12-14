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

$sys_id = string_wslashes($_GET['sid']);
if(!is_numeric($sys_id)) exit;
if($sys_id == 1 || $sys_id == "1") exit;

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

</script>

<?php
$dbid = db_connect();

$rs_system = mysql_query("SELECT sys_id, prefix, name, default_language, country, status, sms_status, other_info1, other_info2 FROM tbl_sys WHERE sys_id = $sys_id", $dbid);

while($row_system = mysql_fetch_array($rs_system)) {
    $rs_sys_id = $row_system[0];
    $rs_prefix = $row_system[1];
    $rs_name = $row_system[2];
    $rs_language = $row_system[3];
    $rs_country = $row_system[4];
    $rs_status = $row_system[5];
    $rs_sms_status = $row_system[6];
    $rs_other_info1 = stripslashes($row_system[7]);
    $rs_other_info2 = stripslashes($row_system[8]);
}

db_close($dbid);
?>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="sys_id" value="<?php echo $rs_sys_id;?>">
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
			    <input name="name" size="35" value="<?php echo $rs_name;?>"/></font></span></font></td>
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
			    <input name="prefix" size="35" type="text" value="<?php echo $rs_prefix;?>"/></font></span></font></td>
            <td width="49%">&nbsp;</td>
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
			echo "<option value=\"$row_id\"".($row_id==$rs_country?" SELECTED":"").">$row_name</option>";
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
			echo "<option value=\"$row_id\"".($row_id==$rs_language?" SELECTED":"").">$row_name</option>";
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
                    <option value="1"<?php echo (1==$rs_status?" SELECTED":"");?>>On</option>
                    <option value="0"<?php echo (0==$rs_status?" SELECTED":"");?>>Off</option>
                </select>
            </td>
            <td width="49%">
                <select size="1" name="sms_status" style="width:245px;">
                    <option value="1"<?php echo (1==$rs_sms_status?" SELECTED":"");?>>Enable Sending</option>
                    <option value="0"<?php echo (0==$rs_sms_status?" SELECTED":"");?>>Disable Sending</option>
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
            <td width="48%"><input name="other_info1" size="35" value="<?php echo $rs_other_info1;?>" /></td>
            <td width="49%"><input name="other_info2" size="35" value="<?php echo $rs_other_info2;?>" /></td>
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
//Select System Modules
$my_modules = array();
		    $rs_sysyem_modules = mysql_query("SELECT module_id FROM tbl_sys_module WHERE sys_id = $sys_id", $dbid);
		    while($row_system_modules = mysql_fetch_array($rs_sysyem_modules)) {
			$my_modules[$row_system_modules[0]] = $row_system_modules[0];
		    }
		    //==

		    $rs_module = mysql_query("SELECT m.module_id, mt.name FROM tbl_ref_module m, tbl_ref_module_title mt WHERE m.module_id = mt.module_id AND mt.language_id = $param_session_sys_language AND m.module_id <> 1", $dbid);
		    while($row_module = mysql_fetch_array($rs_module)) {
			?>
                    <input type="checkbox" name="module[]" value="<?php echo $row_module[0];?>" <?php echo $my_modules[$row_module[0]]==$row_module[0]?"CHECKED":""?>>&nbsp;<?php echo $row_module[1];?><br>
		    <?php
		    }
		    db_close($dbid);
		    ?>
		</font></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Edit System" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo 'index.php';?>')">
	    </td>
        </tr>
    </table>
</form>