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
//Pages
$pageNum = 1;

if(isset($_GET['page'])) {
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "SELECT message_id, title, body, creation_date FROM tbl_alerts_message msg WHERE user_id = $param_session_user_user_id AND status IN(0,9) AND is_scheduled = 1 ORDER BY creation_date DESC";
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
        <td colspan="6">
	    <font face="Trebuchet MS" size="2">
                    Please Note: Schedule alerts based on date, time and repetition.
            </font>
	</td>
    </tr>
    <tr>
        <td width="160"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
        <td width="160"><font face="Trebuchet MS" size="2"><b>Date Created</b></font></td>
        <td width="240"><font face="Trebuchet MS" size="2"><b>Message</b></font></td>
        <td>&nbsp;</td>
    </tr>
    <?php

    while($row = mysql_fetch_array($rs)) {
        $rs_message_id = stripslashes($row['message_id']);
        $rs_title = stripslashes($row['title']);
        $rs_body = stripslashes($row['body']);
        $rs_date_created = stripslashes($row['creation_date']);
        $rs_status = stripslashes($row['status']);
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="160"><font face="Trebuchet MS" size="2"><a href="edit_alert.php?aid=<?php echo $rs_message_id;?>"><?php echo $rs_title!=""?$rs_title:"---";?></a></font></td>
        <td width="160"><font face="Trebuchet MS" size="2"><?php echo $rs_date_created;?></font></td>
        <td width="240"><font face="Trebuchet MS" size="2"><?php echo strlimit($rs_body);?></font></td>
        <td>
            <table border="0" width="100%" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
		    <td><font face="Trebuchet MS" size="2"><a href="view_alert.php?aid=<?php echo $rs_message_id;?>"><img title="Alert Summary" border="0" src="<?php echo $param_abs_path_sib."view_alert_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="snd_alert.php?aid=<?php echo $rs_message_id;?>"><img title="Send Alert" border="0" src="<?php echo $param_abs_path_sib."send_alert_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="edit_alert.php?aid=<?php echo $rs_message_id;?>"><img title="Edit Alert" border="0" src="<?php echo $param_abs_path_sib."edit_alert_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_alert.php?aid=<?php echo $rs_message_id;?>"><img title="Delete Alert" border="0" src="<?php echo $param_abs_path_sib."delete_alert_s.png";?>" width="16" height="16"></a></font></td>
                </tr>
            </table>
        </td>
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
