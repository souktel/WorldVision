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

$user_groups = array();

$dbid = db_connect();

//Groups the user owns
$rs_my_groups = mysql_query("
SELECT DISTINCT ag.group_id, ag.name, ag.reference_code 
FROM tbl_sys_user su, tbl_alerts_group ag
WHERE su.sys_id = $param_session_sys_id 
AND su.user_id = $param_session_user_user_id 
AND ag.owner_id = su.user_id 
AND ag.status > 0 
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

$referrer = $_SERVER['HTTP_REFERER'];

//$rs_my_groups = mysql_query("
//SELECT DISTINCT ag.group_id, ag.name
//FROM tbl_sys_user su, tbl_alerts_group ag, tbl_alerts_group_senders ags
//WHERE su.sys_id = $param_session_sys_id
//AND ags.sender_id = $param_session_user_user_id
//AND ag.owner_id = su.user_id
//AND ag.group_id = ags.group_id
//AND ag.status > 0
//ORDER BY ag.addition_date DESC"
//    ,$dbid);
//
//if($rs_my_groups)
//{
//    while($row_my_groups = mysql_fetch_array($rs_my_groups))
//    {
//        $user_groups[$group_count][0] = $row_my_groups[0];
//        $user_groups[$group_count][1] = $row_my_groups[1];
//        $group_count++;
//    }
//}
//else
//{
//    exit;
//}

db_close($dbid);

?>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" enctype="multipart/form-data">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
<?php if($group_count >0) {?>
    <?php if($_GET['msg'] != "") {?>
        }
        <tr>
            <td colspan="3"><font face="Trebuchet MS" size="2" color="RED">
		<?php echo $_GET['msg'];?>
		</font></td>
        </tr>
    <?php }?>
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <span lang="en-us">Please fill out the following form to import or export group members.</span></font></td>
        </tr>
	<tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <p>Please Note: To import members data you need to create a excel CSV file. To create a CSV file:</p>
		    <ol>
			<li>Open new Excel document.</li>
			<li>Add the numbers to the first column (do not use a title for the column), names to the second column.</li>
			<li>Highlight the first column (numbers), then go to format/cells/numbers and select the fraction option. This will help to display the numbers properly.</li>
			<li>Save as a CSV (MS-DOS) and close the document (you cannot upload the document if it is open).</li>
		    </ol>
		</font>
	    </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Step 1: Choose Group</b>&nbsp;<font color="#FF0000">*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <select name="group_id" size="1" style="width:400px;">
    <?php
    for($gri = 0; $gri < $group_count; $gri++)
	echo "<option value=\"".$user_groups[$gri][0]."\">".$user_groups[$gri][1]." (".$user_groups[$gri][2].")"."</option>"
	?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Step 2: Choose Your Action</b>&nbsp;<font color="#FF0000">*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">A) Import: Pick up your .CSV file, then click IMPORT.</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><input type="file" name="import_file" size="20">&nbsp;<input type="submit" value="Import" name="submit"/></td>
        </tr>
	<tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">B) Export: Click EXPORT, you will be asked to save the file.</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><input type="submit" value="Export" name="submit"/></td>
        </tr>
<?php } else {?>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">
                    You do not have any group to export members from or to import members to.
		</font></td>
        </tr>
<?php }?>
    </table>
</form>
