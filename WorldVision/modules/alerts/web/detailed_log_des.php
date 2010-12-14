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

function printStatus($status)
{
    if($status == "004" || $status == "003" || $status == "008" || $status == "8" || $status == "1") return "Delivered";
    else if($status == "002" || $status == "011" || $status == "4") return "Queued";
    else if($status == "010") return "Expired";
    else if($status == "001" || $status == "05" || $status == "006" || $status == "007" || 
        $status == "009" || $status == "012" || $status == "2" || $status == "16") return "Failed";
    else return "Message Sent";
}

$printable = string_wslashes($_GET['printable']);

if($printable == "1" || $printable == 1) $printable = true; else $printable = false;

$reference = string_wslashes($_GET['reference']);
$sender = string_wslashes($_GET['sender']);
$recipient = string_wslashes($_GET['recipient']);
$message_date = string_wslashes($_GET['message_date']);
$message_text = string_wslashes($_GET['message_text']);
$status = string_wslashes($_GET['status']);

if($reference != "") $reference_st = " AND g.reference_code = '$reference' ";
if($sender != "") $sender_st = " AND s.sendby1 LIKE '%$sender%' ";
if($recipient != "") $recipient_st = " AND sr.mobile LIKE '%$recipient%' ";
if($message_date != "") $message_date_st = " AND s.time_stamp LIKE '%$message_date%' ";
if($status != "") $status_st = " AND sr.status IN('004','003','008','8', '1') ";

if($message_text != "")
{
    $message_text = trim($message_text);
    $message_text_ar = split(" ", $message_text);
    for($i = 0; $i < sizeof($message_text_ar); $i++)
    {
        $or_loop .= ($i==0?"":"OR")." s.sms_body LIKE '%".($message_text_ar[$i])."%' ";
    }
    $or_loop = trim($or_loop);
    $message_text_st = " AND (".$or_loop.") ";
}


$query = "
SELECT DISTINCT s.sendby1, sr.mobile, s.sms_body, ifnull(sr.status,'9999'), s.time_stamp, s.sendby3, s.sendby2, ifnull(sr.status_time,''), g.reference_code
FROM tbl_sms s, tbl_sms_receivers sr, tbl_alerts_group g, tbl_sys_user su
WHERE su.user_id = g.owner_id
AND g.sys_id = $param_session_sys_id
AND g.owner_id = $param_session_user_user_id
AND ((lower(g.reference_code) = lower(s.sendby2) AND sr.group_reference = '') OR (lower(sr.group_reference) = lower(g.reference_code)))
AND s.sms_id = sr.sms_id
AND su.status >= 1
AND g.status >= 1 $reference_st $sender_st $recipient_st $message_date_st $message_text_st $status_st 
ORDER BY s.time_stamp DESC, sr.status ASC
";

?>

<?php
//Pages
$pageNum = 1;
$group_id = 1;
if(isset($_GET['page']))
{
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = 150;//$param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>

<html dir="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel</title>

        <style type="text/css">
            a {
              color: #000000;
            }

            a:link {
              text-decoration: none;
            }
            a:visited {
              text-decoration: none;
            }
            a:hover {
              text-decoration: underline;
            }
            a:active {
              text-decoration: none;
            }
        </style>

    </head>
    <body>
        <table border="0" width="100%" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background_w.gif">
            <tr>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left_w.gif">&nbsp;</td>
                <td height="20" background="<?php echo $param_abs_path_si;?>body-upper_w.gif">&nbsp;</td>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td><span lang="en-us"><font size="3" face="Trebuchet MS">Detailed SMS Log</font></span></td>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td><hr size="0" noshade></td>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td>

                    <!--design header table -->



<?php
if(!$printable)
{
    $user_groups = array();

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

    if($rs_my_groups)
    {
        while($row_my_groups = mysql_fetch_array($rs_my_groups))
        {
            $user_groups[$group_count][0] = $row_my_groups[0];
            $user_groups[$group_count][1] = $row_my_groups[1];
            $user_groups[$group_count][2] = $row_my_groups[2];
            $group_count++;
        }
    }
    else
    {
        exit;
    }
}
?>
<?php if(!$printable) {?>
                    <form name="skform" method="GET" action="detailed_log.php">
                        <input type="hidden" name="act" value="1">
                        <table border="0" width="550" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                            <tr>
                                <td width="96%" colspan="3">
                                    <font face="Trebuchet MS" style="font-size: 10pt">
                                <span lang="en-us">Please fill out the following form to filter sent sms messages.</span></font></td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%"><b><font face="Trebuchet MS" size="2">Choose Group</font></b></td>
                                <td width="49%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%" colspan="2">
                                    <select name="reference" size="1" style="width:450px;">
                                        <option value="">All Groups</option>
                                        <?php
                                        for($gri = 0; $gri < $group_count; $gri++)
                                        echo "<option value=\"".$user_groups[$gri][2]."\" ".($user_groups[$gri][2]==$reference?"selected":"").">".stripslashes($user_groups[$gri][1])." (".$user_groups[$gri][2].")"."</option>"
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%"><font face="Trebuchet MS" size="2"><b>Sender</b></font></td>
                                <td width="49%"><font face="Trebuchet MS" size="2"><b>Recipient</b></font></td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%"><input type="text" name="sender" size="30" value="<?php echo stripslashes($sender);?>"></td>
                                <td width="49%"><input type="text" name="recipient" size="30" value="<?php echo stripslashes($recipient);?>"></td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%"><font face="Trebuchet MS" size="2"><b>Message Date</b></font></td>
                                <td width="49%"><font face="Trebuchet MS" size="2"><b>Message Text</b></font></td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="48%"><input type="text" name="message_date" size="30" value="<?php echo stripslashes($message_date);?>"></td>
                                <td width="49%"><input type="text" name="message_text" size="30" value="<?php echo stripslashes($message_text);?>"></td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;</td>
                                <td width="49%"><font face="Trebuchet MS" size="2"><b><input type="checkbox" name="status" value="1" <?php echo $status!=""?"checked":""; ?>>&nbsp;Delivered Only&nbsp;<input type="checkbox" name="printable" value="1">&nbsp;Printable View</b></font></td>
                            </tr>
                            <tr>
                                <td width="48%" colspan="3"><font face="Trebuchet MS" style="font-size: 9pt">
                                        <span style="font-size: 9pt"><font face="Trebuchet MS">
                                <input type="submit" value="Filter Sent Messages" name="submit"/></font></span></font></td>
                            </tr>
                        </table>
                    </form>
                    <?php }?>





                    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                        <?php if(!$printable) {?>
                        <tr>
                            <td colspan="7"><font size="3" face="Trebuchet MS">Filter Results</font></td>
                        </tr>
                        <tr>
                            <td colspan="7"><hr size="0" noshade></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td width="100"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
                            <td width="120"><font face="Trebuchet MS" size="2"><b>Sender</b></font></td>
                            <td width="120"><font face="Trebuchet MS" size="2"><b>Recipient</b></font></td>
                            <td width="150"><font face="Trebuchet MS" size="2"><b>Message Date</b></font></td>
                            <td width="100"><font face="Trebuchet MS" size="2"><b>Status</b></font></td>
                            <td width="150"><font face="Trebuchet MS" size="2"><b>Delivery Date</b></font></td>
                            <td><font face="Trebuchet MS" size="2"><b>Message Text</b></font></td>
                        </tr>
                        <?php

                        while($row = mysql_fetch_array($rs))
                        {
                            $rs_sender = stripslashes($row[0]);
                            $rs_recipient = stripslashes($row[1]);
                            $rs_message_text = stripslashes($row[2]);
                            $rs_status = stripslashes($row[3]);
                            $rs_time_stamp = stripslashes($row[4]);
                            $rs_message_id = stripslashes($row[5]);
                            $rs_group_ref = stripslashes(strtoupper($row[6]));
                            $rs_status_time = stripslashes($row[7]);
			    $rs_g_ref = stripslashes($row[8]);
                            ?>
                        <!--design tr,td table -->
                        <tr>
                            <td width="100"><font face="Trebuchet MS" size="2"><?php echo $rs_g_ref;?></font></td>
                            <td width="120"><font face="Trebuchet MS" size="2"><?php echo $rs_sender;?></font></td>
                            <td width="120"><font face="Trebuchet MS" size="2"><?php echo $rs_recipient;?></font></td>
                            <td width="150"><font face="Trebuchet MS" size="2"><?php echo $rs_time_stamp;?></font></td>
                            <td width="100"><font face="Trebuchet MS" size="2"><?php echo printStatus($rs_status);//trim($rs_status)=="004"?"Delivered":"Message Sent";?></font></td>
                            <td width="150"><font face="Trebuchet MS" size="2"><?php echo $rs_status_time==""?"Waiting":$rs_status_time;?></font></td>
                            <td><font face="Trebuchet MS" size="2"><?php echo $rs_message_text;?></font></td>
                        </tr>
                        <?php
                    }
                    ?>
                        <tr>
                            <td colspan="7"><hr size="0" noshade></td>
                        </tr>
                    </table>
                    <?php
                    require_once($apath."config/functions/show_pages_func.php");
                    db_close($dbid);
                    ?>
                </td>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-left_w.gif">&nbsp;</td>
                <td height="20" background="<?php echo $param_abs_path_si;?>body-lower_w.gif">&nbsp;</td>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-right_w.gif">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>