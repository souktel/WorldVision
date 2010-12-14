<?php

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
$price = 0.05;


$other_where = '';
$fdate_from = '2007-01-01';
$fdate_to = date("Y-m-d");

if(isset($_POST['submit'])&& ($_POST['submit']=="Get Report")) {
//    echo "hi";exit;
    $fclient = mysql_escape_string($_POST['client']);
    $fdate_from = mysql_escape_string($_POST['date_from']);
    $fdate_to = mysql_escape_string($_POST['date_to']);
    if($fclient != "all") $other_where = ' where sys.sys_id = '.$fclient;
}

$sql_message_summary = "
 SELECT
 sys.sys_id,
 upper(sys.reference_code),
 sys.`name`,
 ifnull((select count(0) from tbl_sys_user where sys_id = sys.sys_id),0) NO_USERS,
 (
 SELECT IFNULL(SUM(IFNULL(IF(LENGTH(sms.sms_body)=CHAR_LENGTH(sms.sms_body), IF(CHAR_LENGTH(sms.sms_body)<=160,1,CEILING(CHAR_LENGTH(sms.sms_body)/153)), IF(CHAR_LENGTH(sms.sms_body)<=70,1,CEILING(CHAR_LENGTH(sms.sms_body)/67))) ,0) * IFNULL((SELECT COUNT(0) FROM tbl_sms_receivers WHERE sms_id = sms.sms_id AND (UPPER(mobile) LIKE '97259%' OR UPPER(mobile) LIKE '97059%' OR UPPER(mobile) LIKE '059%')),0)),0)
 FROM tbl_sms sms
 WHERE sms.sys_id = sys.sys_id
 AND upper(sms.sendby2) LIKE 'G%'
 AND DATE_FORMAT(sms.time_stamp,'%Y-%m-%d') >= DATE_FORMAT('$fdate_from','%Y-%m-%d')
 AND DATE_FORMAT(sms.time_stamp,'%Y-%m-%d') <= DATE_FORMAT('$fdate_to','%Y-%m-%d')
 ) JAWWAL
 ,
 (
 SELECT IFNULL( SUM( IFNULL( IF( LENGTH(sms.sms_body)=CHAR_LENGTH(sms.sms_body), CEILING(CHAR_LENGTH(sms.sms_body)/160), CEILING(CHAR_LENGTH(sms.sms_body)/70) ) * IFNULL((SELECT COUNT(0) FROM tbl_sms_receivers WHERE sms_id = sms.sms_id AND (UPPER(mobile) NOT LIKE '97259%' AND UPPER(mobile) NOT LIKE '97059%' And UPPER(mobile) NOT LIKE '059%')),0) ,0) ) ,0)
 FROM tbl_sms sms
 WHERE sms.sys_id = sys.sys_id
 AND upper(sms.sendby2) LIKE 'G%'
 AND DATE_FORMAT(sms.time_stamp,'%Y-%m-%d') >= DATE_FORMAT('$fdate_from','%Y-%m-%d')
 AND DATE_FORMAT(sms.time_stamp,'%Y-%m-%d') <= DATE_FORMAT('$fdate_to','%Y-%m-%d')
 ) NONJAWWAL
 FROM tbl_sys sys
        $other_where
 ORDER BY upper(sys.name)
        ";

//echo $sql_message_summary;

//SELECT IFNULL( SUM( IFNULL( IF( LENGTH(sms.sms_body)=CHAR_LENGTH(sms.sms_body), CEILING(CHAR_LENGTH(sms.sms_body)/160), CEILING(CHAR_LENGTH(sms.sms_body)/70) ) * IFNULL((SELECT COUNT(0) FROM tbl_sms_receivers WHERE sms_id = sms.sms_id AND (UPPER(mobile) LIKE '97259%' OR UPPER(mobile) LIKE '97059%' OR UPPER(mobile) LIKE '059%')),0) ,0) ) ,0)

$rs_message_summary = mysql_query($sql_message_summary, $dbid);
?>
<div align="left">
    <form id="skform" name="skform" method="POST" action="">

        <table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
            <tr>
                <td width="200">Choose Client Name</td>
                <td width="200">&nbsp;</td>
                <td>message price =<?=$price?>$</td>
            </tr>
            <tr>
                <td width="225" colspan="3">
                    <select name="client" style="width:435px;">
                        <option value="all">All Clients</option>
<?php
$query_client = "SELECT sys_id, prefix, name FROM tbl_sys ORDER BY sys_id DESC";
                        $rs_client = mysql_query($query_client,$dbid);
                        ?>
                        <?php while($row_client = mysql_fetch_array($rs_client)) {?>
                            <?php
                            $rs_client_id = $row_client[0];
                            $rs_client_prefix = $row_client[1];
                            $rs_client_name = $row_client[2];
                            echo "<option value=\"$rs_client_id\" ".($fclient==$rs_client_id?"selected":"").">$rs_client_name [$rs_client_prefix]</option>";
                            ?>
                            <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="225">Date From</td>
                <td width="225">Date To</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="225"><input type="text" value="<?php echo $fdate_from;?>" name="date_from" maxlength="10" style="width:200px;"><br><font size="2" color="RED">e.g. 2009-03-25</font></td>
                <td width="225"><input type="text" value="<?php echo $fdate_to;?>" name="date_to"  maxlength="10" style="width:200px;"><br><font size="2" color="RED">e.g. 2009-03-25</font></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3"><input name="submit" type="submit" value="Get Report"></td>
            </tr>
            <tr>
                <td colspan="3"><hr size="0" noshade></td>
            </tr>
        </table>
    </form>
    <table width="680" cellspacing="3" cellpadding="3">
        <tr>
            <td width="80"><u><b>Prefix</b></u></td>
            <td width="350"><u><b>Client Name</b></u></td>
            <td width="80" align="center"><u><b>Users</b></u></td>
            <td width="80" align="center"><u><b># Message</b></u></td>
            <td width="80" align="center"><u><b>Cost</b></u></td>
        </tr>
<?php while($row_message_summary = mysql_fetch_array($rs_message_summary)) {?>
    <?php
            $sys_id = $row_message_summary[0];
            $sys_prefix = strtoupper($row_message_summary[1]);
            $sys_name = strtoupper($row_message_summary[2]);
            $sys_users = $row_message_summary[3];
            $sys_counter = $row_message_summary[4];
            ?>
        <tr>
            <td width="80" valign="top"><?php echo $sys_prefix;?></td>
            <td width="400" valign="top"><?php echo $sys_name;?></td>
            <td align="center" valign="top"><?php echo $sys_users;?></td>
            <td align="center" valign="top"><?php echo $sys_counter;?></td>
            <td align="center" valign="top"><?php echo ($sys_counter * $price);?>$</td>
        </tr>
    <?php }?>
    </table>
</div>