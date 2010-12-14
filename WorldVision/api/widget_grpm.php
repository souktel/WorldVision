<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../";

require_once($apath."config/parameters/params_db.php");
require_once($apath."config/database/db_mysql.php");
require_once($apath."config/functions/sms_func.php");
require_once($apath."config/functions/send_func.php");

$mob = mysql_escape_string(trim($_POST['f1']));
$nam = mysql_escape_string(trim($_POST['f2']));
$loc = mysql_escape_string(trim($_POST['f3']));
$ot1 = mysql_escape_string(trim($_POST['f4']));
$ot2 = mysql_escape_string(trim($_POST['f5']));
$grp = strtoupper(mysql_escape_string(trim($_POST['c1'])));
$api_id = mysql_escape_string(trim($_POST['api_id']));
$api_key = mysql_escape_string(trim($_POST['api_key']));
$sys_id = mysql_escape_string(trim($_POST['sys_id']));

$db_group_id = null;

$reply_msg = 'EZERO';

$dbid = db_connect();

$rs_validate = mysql_query(
    "SELECT g.group_id FROM tbl_sys s, tbl_alerts_group g WHERE g.sys_id = s.sys_id AND s.public_group = 1 AND g.public_group = 1 AND g.reference_code = '$grp' AND s.api_id = '$api_id' AND s.api_key = '$api_key' AND s.sys_id = $sys_id"
    , $dbid);

if(!$rs_validate) {
    $reply_msg = 'E10';
} else {
    if($row = mysql_fetch_array($rs_validate)) {
        $db_group_id = $row[0];
    } else {
        $reply_msg = 'E11';
    }
    if($reply_msg == 'EZERO') {
        if(!mysql_query("INSERT INTO tbl_alerts_group_members VALUES($db_group_id, '$mob', '$nam', '$loc', '$ot1', '$ot2')",$dbid))
            $reply_msg = 'E12'; //Duplicate mobile number
    }
}

db_close($dbid);

echo $reply_msg;
?>
