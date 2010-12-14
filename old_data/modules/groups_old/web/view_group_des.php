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
$error_found = false;

$group_id = string_wslashes($_GET['gid']);
if(!is_numeric($group_id)) exit;

$dbid = db_connect();

if($rs = mysql_query("SELECT g.name, g.group_desc, g.status, g.reference_code, g.addition_date, (SELECT COUNT(1) FROM tbl_alerts_group_members gm WHERE gm.group_id = g.group_id) AS members FROM tbl_alerts_group g WHERE g.group_id = $group_id AND g.sys_id = $param_session_sys_id AND g.owner_id = $param_session_user_user_id", $dbid))
{
    if($row = mysql_fetch_array($rs))
    {
        $rs_name = $row[0];
        $rs_desc = $row[1];
        $rs_status = $row[2];
        $rs_reference = $row[3];
        $rs_addition_date = $row[4];
        $rs_members = $row[5];
        $rs_senders = array();
        $rs_senders_n = array();

        if($rs1 = mysql_query("SELECT su.mobile, su.name FROM tbl_alerts_group_senders gs, tbl_sys_user su WHERE gs.group_id = $group_id AND su.user_id = gs.sender_id", $dbid))
        {
            while($row1 = mysql_fetch_array($rs1))
            {
                $rs_senders[] = $row1[0];
                $rs_senders_n[] = $row1[1];
            }
        }

    }
}
else
{
    exit;
}

db_close($dbid);  

$referrer = $_SERVER['HTTP_REFERER'];

?>

<form>
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Group Name</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Reference</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="name" size="35" readonly="true" value="<?php echo $rs_name;?>"/></td>
            <td width="49%"><input name="status" size="35" readonly="true" value="<?php echo $rs_reference;?>"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Creation Date</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Group Status</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="name" size="35" readonly="true" value="<?php echo $rs_addition_date;?>"/></td>
            <td width="49%"><input name="status" size="35" readonly="true" value="<?php echo $rs_status ==1?"ON":"OFF";?>"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
            <textarea rows="8" name="description" readonly="true" cols="60"><?php echo $rs_desc;?></textarea></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Group Members</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="name" size="35" readonly="true" value="<?php echo $rs_members." Member(s).";?>"/></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Permission to Mobile numbers</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <?php
        $is = 0;
        for(; $is < sizeof($rs_senders); $is++)
        {
            $sender = $rs_senders[$is];
            $sender_n = $rs_senders_n[$is];
            ?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">&nbsp;<?php echo $sender;?>&nbsp;[<?php echo $sender_n;?>]</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <?php
    }
    if($is == 0)
    {
        ?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><font face="Trebuchet MS" size="2">Only you have access to this group via mobile phone.</font></td>
        </tr>
        <?php
    }
    ?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2">Tools</font></b></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <table border="0" width="130" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                    <tr>
                        <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."edit_group_s.png";?>" width="16" height="16"></td>
                        <td><font face="Trebuchet MS" size="2"><a href="edit_group.php?gid=<?php echo $group_id;?>&ru=<?php echo $referrer;?>">Edit</a></font></td>
                        <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."delete_group_s.png";?>" width="16" height="16"></td>
                        <td><font face="Trebuchet MS" size="2"><a href="delete_group.php?gid=<?php echo $group_id;?>&ru=<?php echo $referrer;?>">Delete</a></font></td>
                        <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."members_s.png";?>" width="16" height="16"></td>
                        <td><font face="Trebuchet MS" size="2"><a href="editm_group.php?gid=<?php echo $group_id;?>&ru=<?php echo $referrer;?>">Members</a></font></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>"><<&nbsp;Return to previous!</a></font></b></td>
        </tr>
    </table>
</form>