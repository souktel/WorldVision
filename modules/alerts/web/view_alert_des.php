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

$message_id = string_wslashes($_GET['aid']);
if(!is_numeric($message_id)) exit;

$dbid = db_connect();

$rs = mysql_query("SELECT * FROM tbl_alerts_message WHERE message_id = $message_id AND user_id = $param_session_user_user_id", $dbid);
if($rs) {
    if($row = mysql_fetch_array($rs)) {
        $alert_title = stripslashes($row['title']);
        $alert_text = stripslashes($row['body']);
        $date_created = stripslashes($row['creation_date']);
        $scheduled = stripslashes($row['is_scheduled']);
        if($scheduled=="1") {
            $schedule_date = stripslashes($row['schedule_date']);
            $schedule_time = stripslashes($row['schedule_time']);
            $repeat = stripslashes($row['is_repeat']);
        }
        else {
            $schedule_date = "";
            $schedule_time = "";
        }
        $status = stripslashes($row['status']);

    }
    else {
        exit;
    }
}
else {
    exit;
}

?>
<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><font face="Trebuchet MS" size="2"><?php echo $alert_title;?></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2"><b>Alert/Message Text</b></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td colspan="2">
            <textarea style="width: 655px;" rows="6" id="alert_text" name="alert_text" cols="60" readonly="true"><?php echo $alert_text;?></textarea>
        </td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td colspan="2" align="justify">
            <font face="Trebuchet MS" style="font-size:8pt;">
                <b>[<?php echo strlen($alert_text)?>&nbsp;Char Length]</b>&nbsp;English SMS messages allow for 160 characters. Arabic SMS messages allow for 70 characters. Please Note: Additional content will be sent in a second SMS and will be subject to additional charges.
            </font>
        </td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2"><b>Date Created</b></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><font face="Trebuchet MS" size="2"><?php echo $date_created;?></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td colspan="2">
            <font face="Trebuchet MS" size="2"><b>Alert Groups</b>
                <ul>
                    <?php
                    $rs_groups = mysql_query("SELECT g.name, g.reference_code FROM tbl_alerts_message msg, tbl_alerts_message_groups mg, tbl_alerts_group g WHERE msg.message_id = mg.message_id AND mg.group_id = g.group_id AND msg.user_id = $param_session_user_user_id AND msg.message_id = $message_id", $dbid);
                    while($row_groups = mysql_fetch_array($rs_groups)) {?>
                    <li><?php echo stripslashes($row_groups['name'])." [".$row_groups['reference_code']."]";?></li>
                    <?php }?>
                </ul>
            </font>
        </td>
    </tr>
    <?php if($scheduled=="1") {?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2"><b>Scheduled Alerts</b></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td colspan="2">
                <?php
                $st_id = 1;
                for($hi = 0; $hi <= 23; $hi++) {
                    $hour = $hi<=9?"0".$hi:$hi;
                    for($mi = 0; $mi <= 45; $mi+=15) {
                        $minute = $mi<=9?"0".$mi:$mi;
                        if($schedule_time==$st_id) {
                            $schedule_time = "$hour:$minute";
                            break;
                        }
                        $st_id++;
                    }
                }
                if($repeat==0||$repeat=="0") $repeat = "No Repeat";
                else if($repeat==1||$repeat=="1") $repeat = "Daily";
                    else if($repeat==2||$repeat=="2") $repeat = "Weekly";
                        else if($repeat==3||$repeat=="3") $repeat = "Monthly";
                            else if($repeat==4||$repeat=="4") $repeat = "Yearly";
                                else $repeat = "Once";
                ?>
            <font face="Trebuchet MS" size="2"><?php echo $schedule_date?> <?php echo $schedule_time?>/<?php echo $repeat?></font>
        </td>
    </tr>
    <?php }?>
</table>
<?php
db_close($dbid);  

$referrer = $_SERVER['HTTP_REFERER'];

?>