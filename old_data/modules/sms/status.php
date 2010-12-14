<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$cliMsgId = trim($_GET['msgid']);
$to = trim($_GET['to']);
$status = trim($_GET['status']);

if($cliMsgId != "" && $to != "" && $status != "")
{
    $apath = "../../";

    //Database Parameters
    require_once($apath."config/parameters/params_db.php");
    //Database Connection
    require_once($apath."config/database/db_mysql.php");

    $dbid = db_connect();

    $rs_select = mysql_query("SELECT sms_id FROM tbl_sms WHERE sendby3 = '$cliMsgId'", $dbid);
    if($rs_row = mysql_fetch_array($rs_select))
    {
        $sms_id = $rs_row[0];
        mysql_query("UPDATE tbl_sms_receivers SET status = '$status', status_time = CURRENT_TIMESTAMP WHERE sms_id = '$sms_id' AND mobile = '$to'", $dbid);
    }

    //mysql_query("UPDATE tbl_sent SET status = '$status', status_time = CURRENT_TIMESTAMP WHERE msgid = '$cliMsgId' AND reciever = '$to'", $dbid);

    db_close($dbid);
}

?>
