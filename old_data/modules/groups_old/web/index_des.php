<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}  
?>

<?php
//Pages
$pageNum = 1;

if(isset($_GET['page']))
{
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "SELECT ag.group_id, ag.reference_code, ag.name, ag.status, ag.addition_date, (SELECT count(1) FROM tbl_alerts_group_members WHERE group_id = ag.group_id) AS members FROM tbl_sys_user su, tbl_alerts_group ag WHERE su.sys_id = $param_session_sys_id AND su.user_id = $param_session_user_user_id AND ag.owner_id = su.user_id ORDER BY ag.addition_date DESC";
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <?php if($_GET['msg'] != "") {?>
    <tr>
        <td colspan="6"><font face="Trebuchet MS" size="2" color="RED">
                <?php echo $_GET['msg'];?>
        </font></td>
    </tr>
    <?php }?>
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><b>Name</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b>Members</b></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><b>Creation Date</b></font></td>
        <td>&nbsp;</td>
    </tr>
    <?php

    while($row = mysql_fetch_array($rs))
    {
        $rs_group_id = $row['group_id'];
        $rs_name = $row['name'];
        $rs_reference = $row['reference_code'];
        $rs_members = $row['members'];
        $rs_status = $row['status'];
        $rs_addition_date = $row['addition_date'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_si;?>group.png"></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><a href="editm_group.php?gid=<?php echo $rs_group_id;?>"><?php echo $rs_name;?></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><font face="Trebuchet MS" size="2"><a title="Group Members" href="editm_group.php?gid=<?php echo $rs_group_id;?>"><?php echo $rs_members;?></font></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
        <td><table border="0" width="100" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td><font face="Trebuchet MS" size="2"><img border="0" src="<?php echo $param_abs_path_sib.($rs_status=="1"?"on.png":"off.png");?>" width="16" height="16"></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="edit_group.php?gid=<?php echo $rs_group_id;?>"><img title="Edit Group" border="0" src="<?php echo $param_abs_path_sib."edit_group.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_group.php?gid=<?php echo $rs_group_id;?>"><img title="Delete Group" border="0" src="<?php echo $param_abs_path_sib."delete_group_s.png";?>" width="16" height="16"></a></font></td>
		    <td><font face="Trebuchet MS" size="2"><font face="Trebuchet MS" size="2"><a title="Group Members" href="editm_group.php?gid=<?php echo $rs_group_id;?>"><img src="<?php echo $param_abs_path_sib;?>members_s.png" width="16" height="16" border="0"></a></font></font></td>
                </tr>
        </table></td>
    </tr>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php

require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>
