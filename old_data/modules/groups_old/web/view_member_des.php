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

<?php
$error_found = false;

$group_id = string_wslashes($_GET['gid']);
if(!is_numeric($group_id)) exit;

$member_mobile = string_wslashes($_GET['mob']);
if(trim($member_mobile)=='') exit;

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

if($rs1 = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id AND mobile = '$member_mobile'", $dbid)) {
    if($row1 = mysql_fetch_array($rs1)) {
	$rs_mobile = stripslashes($row1['mobile']);
	$rs_name = stripslashes($row1['name']);
	$rs_location = stripslashes($row1['location']);
	$rs_info1 = stripslashes($row1['other_info1']);
	$rs_info2 = stripslashes($row1['other_info2']);
    }
}
?>
<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
	<td width="3%">&nbsp;</td>
	<td colspan="2"><font face="Trebuchet MS" size="2">Mobile</font></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td colspan="2"><input name="mobile" size="35" value="<?php echo $rs_mobile;?>" readonly="true"/></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td width="48%"><font face="Trebuchet MS" size="2">Name</font></td>
	<td width="49%"><font face="Trebuchet MS" size="2">Location</font></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td width="48%"><input name="name" size="35" value="<?php echo $rs_name;?>" readonly="true"/></td>
	<td width="49%"><input name="location" size="35" value="<?php echo $rs_location;?>" readonly="true"/></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td width="48%"><font face="Trebuchet MS" size="2"><?php echo $param_session_sys_other_info1;?></font></td>
	<td width="49%"><font face="Trebuchet MS" size="2"><?php echo $param_session_sys_other_info2;?></font></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td width="48%"><input name="info1" size="35" value="<?php echo $rs_info1;?>" readonly="true"/></td>
	<td width="49%"><input name="info2" size="35" value="<?php echo $rs_info2;?>" readonly="true"/></td>
    </tr>
    <tr>
	<td width="3%">&nbsp;</td>
	<td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>"><<&nbsp;Return to previous!</a></font></b></td>
    </tr>
</table>
<?php
db_close($dbid);
?>