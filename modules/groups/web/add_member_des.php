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

<script language="JavaScript" type="text/javascript">
    var rules = [];

    rules.push("digits_only,mobile,Mobile : Digits only please.");
    rules.push("required,mobile,Required : Mobile.");
    rules.push("length<=20,mobile,Mobile : < 20 digits please.");

    rules.push("length<=160,name,Name : < 160 chars please.");
    rules.push("length<=200,location,Location : < 200 chars please.");
    rules.push("length<=200,info1,Info #1 : < 200 chars please.");
    rules.push("length<=200,info2,Info #2 : < 200 chars please.");
</script>

<?php
$error_found = false;

$group_id = string_wslashes($_GET['gid']);
if(!is_numeric($group_id)) exit;

$referrer = $_SERVER['HTTP_REFERER'];

$dbid = db_connect();

if($rs = mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid)) {
    if(!$row = mysql_fetch_array($rs)) {
	exit;
    }
}
else {
    exit;
}
?>
<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
	<?php if($_GET['msg']!="") {?>
        <tr>
            <td width="20"><font face="Trebuchet MS" size="2">&nbsp;</font></td>
            <td colspan="5"><font face="Trebuchet MS" size="2" color="#FF0000"><?php echo $_GET['msg'];?></font></td>
        </tr>
	<?php }?>
	<tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <span lang="en-us">
			Please fill out the following form to add new group member.
		    </span>
		</font>
	    </td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">Mobile<font color="#FF0000">*</font><font style="font-size:7pt;"><br>Please note: enter mobile numbers with country code, area code and the number. Do not use spaces or symbols.</font></font></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><input name="mobile" size="35"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Name</font></td>
	    <td width="49%"><font face="Trebuchet MS" size="2">Location</font></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="name" size="35"/></td>
            <td width="48%"><input name="location" size="35"/></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><?php echo $param_session_sys_other_info1;?></font></td>
	    <td width="49%"><font face="Trebuchet MS" size="2"><?php echo $param_session_sys_other_info2;?></font></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td width="49%"><select size="1" name="info1" style="width:245px;">
                    <option selected value="1">Male</option>
                    <option value="2">Female</option>
            </select></td>
	    <td width="49%"><input name="info2" size="35"/></td>
        </tr>
	<tr>
            <td colspan="3">
		<input type="submit" value="Add Member" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo "editm_group.php?gid=$group_id";?>')">
	    </td>
        </tr>
    </table>
</form>
<?php
db_close($dbid);
?>