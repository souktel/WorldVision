<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../../";

require_once($apath."config/parameters/params_db.php");
require_once($apath."config/database/db_mysql.php");
require_once($apath."config/functions/sms_func.php");
require_once($apath."config/functions/send_func.php");

function getCurrentTimeInt() {
    $cur_hour = (int)date('G');
    $cur_minute = (int)date('i');
    $st_id = 1;
    for($hi = 0; $hi <= 23; $hi++) {
        for($mi = 0; $mi <= 45; $mi+=15) {
            if($cur_hour == $hi) {
                if($cur_minute>=$mi && $cur_minute<=$mi+14) {
                    return $st_id;
                }
            }
            $st_id++;
        }
    }
}

$dbid = db_connect();

$current_time = getCurrentTimeInt();

$select_msgs = "SELECT message_id, user_id, (SELECT sys_id FROM tbl_sys_user WHERE user_id = msg.user_id), (SELECT mobile FROM tbl_sys_user WHERE user_id = msg.user_id), body, (SELECT api_id FROM tbl_sys WHERE sys_id = (SELECT sys_id FROM tbl_sys_user WHERE user_id = msg.user_id)), (SELECT api_key FROM tbl_sys WHERE sys_id = (SELECT sys_id FROM tbl_sys_user WHERE user_id = msg.user_id)) FROM `tbl_alerts_message` msg WHERE is_scheduled = 1 AND status = 9 AND schedule_time = $current_time AND ";
$select_msgs .= "(";
$select_msgs .= "(is_repeat = 0 AND schedule_date = CURDATE()) OR ";
$select_msgs .= "(is_repeat = 1) OR ";
$select_msgs .= "(is_repeat = 2 AND MOD(TO_DAYS(CURDATE())-TO_DAYS(schedule_date),7)=0) OR ";
$select_msgs .= "(is_repeat = 3 AND MOD(IF((((YEAR(schedule_date) - 1) * 12 + MONTH(schedule_date)) - ((YEAR(CURDATE()) - 1) * 12 + MONTH(CURDATE()))) > 0, (((YEAR(schedule_date) - 1) * 12 + MONTH(schedule_date)) - ((YEAR(CURDATE()) - 1) * 12 + MONTH(CURDATE()))) - (MID(schedule_date, 9, 2) < MID(CURDATE(), 9, 2)), IF((((YEAR(schedule_date) - 1) * 12 + MONTH(schedule_date)) - ((YEAR(CURDATE()) - 1) * 12 + MONTH(CURDATE()))) < 0, (((YEAR(schedule_date) - 1) * 12 + MONTH(schedule_date)) - ((YEAR(CURDATE()) - 1) * 12 + MONTH(CURDATE()))) + (MID(CURDATE(), 9, 2) < MID(schedule_date, 9, 2)), (((YEAR(schedule_date) - 1) * 12 + MONTH(schedule_date)) - ((YEAR(CURDATE()) - 1) * 12 + MONTH(CURDATE()))))),1)=0) OR ";
$select_msgs .= "(is_repeat = 4 AND MOD(IF((YEAR(schedule_date) - YEAR(CURDATE())) > 0, (YEAR(schedule_date) - YEAR(CURDATE())) - (MID(schedule_date, 6, 5) < MID(CURDATE(), 6, 5)), IF((YEAR(schedule_date) - YEAR(CURDATE())) < 0, (YEAR(schedule_date) - YEAR(CURDATE())) + (MID(CURDATE(), 6, 5) < MID(schedule_date, 6, 5)), (YEAR(schedule_date) - YEAR(CURDATE())))),1)=0)";
$select_msgs .= ")";

$rs_select_msgs = mysql_query($select_msgs , $dbid);

if(mysql_num_rows($rs_select_msgs)>0) {
    while($row_select_msgs = mysql_fetch_array($rs_select_msgs)) {
        $message_mid = $row_select_msgs[0];
        $message_usr = $row_select_msgs[1];
        $message_sys = $row_select_msgs[2];
        $message_mob = string_wslashes($row_select_msgs[3]);
        $message_txt = string_wslashes($row_select_msgs[4]);
        $sms_api_id = $row_select_msgs[5];
        $sms_api_key = $row_select_msgs[6];
        $db_message_txt = mysql_escape_string($message_txt);

        //Begin Transactinon
        mysql_query("BEGIN", $dbid);

        //Log Sending
        mysql_query("INSERT INTO tbl_alerts_message_log VALUES($message_mid, 1, CURRENT_TIMESTAMP)",$dbid);

        //--Get Receivers From Groups
        $selected_groups = "SELECT group_id FROM tbl_alerts_message_groups WHERE message_id = $message_mid";
        $select_members = "SELECT DISTINCT gm.mobile MOBILE,(SELECT reference_code FROM tbl_alerts_group g, tbl_alerts_group_members gmr WHERE g.group_id = gmr.group_id AND g.group_id IN ($selected_groups) AND gmr.mobile = gm.mobile LIMIT 0,1) REFERENCE FROM tbl_alerts_group_members gm WHERE gm.group_id IN ($selected_groups)";
        if($rs_members = mysql_query($select_members, $dbid)) {
            $members_total_mob = array();
            $members_total_grp = array();
            while($row_members = mysql_fetch_array($rs_members)) {
                $members_total_mob[] = $row_members[0];
                $members_total_grp[] = $row_members[1];
            }
            $members_size = sizeof($members_total_mob);
            if($members_size > 0) {
                $msgId = generateMsgId($sms_api_id);
                $db_msg_text = string_wslashes($msg_text);
                $group_reference = join("-", $members_total_grp);
                mysql_query("INSERT INTO tbl_sms VALUES(sms_id, $message_sys, 'AlNajah', '37138', '$message_mob', 'G', '$msgId', CURRENT_TIMESTAMP, '$db_message_txt', 1, $members_size, 2, 1, 0)", $dbid);
                $sms_message_id = mysql_insert_id($dbid);
                for($no_rec = 0; $no_rec < sizeof($members_total_mob); $no_rec++) {
                    $member_mobile = trim($members_total_mob[$no_rec]);
                    $member_group = trim(strtoupper($members_total_grp[$no_rec]));
                    if($member_mobile != '') mysql_query("INSERT INTO tbl_sms_receivers VALUES($sms_message_id, '$member_mobile', '$member_group', '', NULL, '$msgId')", $dbid);
                }
                if($rs_senderid = mysql_query("SELECT sender_id FROM tbl_sys_senderid WHERE sys_id = $message_sys", $dbid)) {
                    if($req_sender_id_arr = mysql_fetch_array($rs_senderid)) {
                        $req_sender_id = $req_sender_id_arr[0];
                    }
                }
                //Sending Message
                $send_faild = sendBulkSMS($msgId, $members_total_mob, $message_txt, $dbid, $sms_api_id, $sms_api_key);

                if($send_faild == false) $success_flag = true;
                else $success_flag = false;

                if($success_flag) {
                    mysql_query("COMMIT", $dbid);
                } else {
                    mysql_query("ROLLBACK", $dbid);
                }
            }
        }
    //==Get Receivers From Groups

    }
}
db_close($dbid);
?>