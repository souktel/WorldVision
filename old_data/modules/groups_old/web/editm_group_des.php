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
    function checkAllBoxes()
    {
	if(document.skform.allselected.checked==true)
	{
	    alert('You select all the members of this group, not just in this page, Copy, Move and Delete operations will affect all members of this group.');
	}
    }
</script>

<?php
$error_found = false;

$group_id = string_wslashes($_GET['gid']);
if(!is_numeric($group_id)) exit;

$referrer = $_SERVER['HTTP_REFERER'];

$pageNum = 1;

if(isset($_GET['page'])) {
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$param_db_rows_per_page = 50;

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;

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

<form id="skform" name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
	<?php if($_GET['msg']!="") {?>
        <tr>
            <td width="20">&nbsp;</td>
            <td colspan="5"><font face="Trebuchet MS" size="2" color="#FF0000"><?php echo $_GET['msg'];?></font></td>
        </tr>
	<?php }?>
        <tr>
            <td width="20"><b><font face="Trebuchet MS" size="2"><input type="checkbox" name="allselected" value="yes_all_selected" onclick="javascript:checkAllBoxes();" title="Select all members on this group, not just this page."></font></b></td>
            <td width="120"><b><font face="Trebuchet MS" size="2">Mobile</font></b></td>
            <td width="100"><b><font face="Trebuchet MS" size="2">Name</font></b></td>
	    <td width="120"><b><font face="Trebuchet MS" size="2">Location</font></b></td>
	    <td width="120"><b><font face="Trebuchet MS" size="2"><?php echo $param_session_sys_other_info1;?></font></b></td>
	    <td>&nbsp;</td>
        </tr>
	<?php
	$bool_no_members = true;

	$query = "SELECT mobile, name, location, other_info1 FROM tbl_alerts_group_members WHERE group_id = $group_id";

	$numrows = mysql_num_rows(mysql_query($query,$dbid));

	if($rs1 = mysql_query($query." LIMIT $offset,$rowsPerPage", $dbid)) {
	    while($row1 = mysql_fetch_array($rs1)) {
		$bool_no_members = false;
		?>
        <tr>
            <td width="20" valign="middle"><font face="Trebuchet MS" size="2"><input type="checkbox" name="memberstodel[]" id="gid[]" value="<?php echo $row1[0];?>"></font></td>
            <td width="120">
		<font face="Trebuchet MS" size="2"><?php echo $row1[0];?></font>
	    </td>
            <td width="100"><font face="Trebuchet MS" size="2"><?php echo stripcslashes($row1[1]);?></font></td>
	    <td width=120"><font face="Trebuchet MS" size="2"><?php echo stripcslashes($row1[2]);?></font></td>
	    <td width=120"><font face="Trebuchet MS" size="2"><?php echo stripcslashes($row1[3]);?></font></td>
	    <td align="right"><font face="Trebuchet MS" size="1">
		    <a href="view_member.php?gid=<?php echo $group_id;?>&mob=<?php echo $row1[0];?>" title="View Member <?php echo $row1[0];?>">View</a>&nbsp|&nbsp;
		    <a href="edit_member.php?gid=<?php echo $group_id;?>&mob=<?php echo $row1[0];?>" title="Edit Member <?php echo $row1[0];?>">Edit</a>&nbsp|&nbsp;
		    <a href="delete_member.php?gid=<?php echo $group_id;?>&mob=<?php echo $row1[0];?>" title="Delete Member <?php echo $row1[0];?>">Delete</a>
		</font>
	    </td>
        </tr>
	    <?php
	    }
	}
	if($bool_no_members) {
	    ?>
        <tr>
            <td width="20"><b><font face="Trebuchet MS" size="2">&nbsp;</font></b></td>
            <td colspan="5"><b><font face="Trebuchet MS" size="2">No members currently in the group.</font></b></td>
        </tr>
	<?php }?>
        <tr>
            <td colspan="6"><div id="myDiv1"></div></td>
        </tr>
        <tr>
            <td colspan="6"><hr size="0" noshade></td>
        </tr>
	<?php
	$rs_my_groups = mysql_query("
            SELECT DISTINCT ag.group_id, ag.name, ag.reference_code
            FROM tbl_sys_user su, tbl_alerts_group ag
            WHERE su.sys_id = $param_session_sys_id
            AND su.user_id = $param_session_user_user_id
            AND ag.owner_id = su.user_id
            AND ag.status > 0
            AND ag.group_id <> $group_id
            ORDER BY ag.addition_date DESC"
	    ,$dbid);

	$group_count = 0;

	if($rs_my_groups) {
	    while($row_my_groups = mysql_fetch_array($rs_my_groups)) {
		$user_groups[$group_count][0] = $row_my_groups[0];
		$user_groups[$group_count][1] = $row_my_groups[1];
		$user_groups[$group_count][2] = $row_my_groups[2];
		$group_count++;
	    }
	}
	else {
	    exit;
	}
	?>
        <tr>
            <td colspan="6">
                <b>
                    <font face="Trebuchet MS" size="2">
			<input type="button" value="Add Member" onclick="javascript:gogo('<?php echo "add_member.php?gid=$group_id";?>')">
			<?php if(!$bool_no_members) {?>
			<input type="submit" value="Delete" name="todo_sub" title="Submit New Records/Delete Selected Members"/>&nbsp;
			<?php } if($group_count!=0 && !$bool_no_members) {?>
                        |&nbsp;
			<select name="cm_group_id" size="1" style="width: 220px;">
				<?php
				for($gri = 0; $gri < $group_count; $gri++) echo "<option value=\"".$user_groups[$gri][0]."\">".$user_groups[$gri][1]." (".$user_groups[$gri][2].")"."</option>"
				    ?>
                        </select>&nbsp;
                        <input type="submit" value="Move + Save" name="todo_sub" title="Copy Selected Members To Other Group"/>&nbsp;
                        <input type="submit" value="Move + Delete" name="todo_sub" title="Move Selected Members To Other Group"/>
			<?php }?>
                    </font>
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="6"><hr size="0" noshade></td>
        </tr>
        <tr>
            <td colspan="6"><font face="Trebuchet MS" size="2"><?php require_once($apath."config/functions/show_pages_func.php");?></font></td>
        </tr>
        <tr>
            <td colspan="6"><font face="Trebuchet MS" size="2">&nbsp;</font></td>
        </tr>
    </table>
</form>

<?php
db_close($dbid);
?>