<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../../../";

require_once($apath."config/parameters/params_db.php");
require_once($apath."config/database/db_mysql.php");
require_once($apath."config/parameters/params_main.php");
require_once($apath."config/parameters/params_session.php");
require_once($apath."config/parameters/params_header_menu.php");
require_once($apath."config/functions/validation.php");
require_once($apath."config/functions/util_func.php");
require_once($apath."config/functions/val_func.php");
require_once($apath."config/functions/oth_func.php");
require_once($apath."config/functions/send_func.php");
require_once($apath."auth/check_authentication.php");

if(!check_login_success()) exit;
if($param_session_check != "zZZz4332W") exit;

$dbid = db_connect();

$alert_id = addslashes($_POST['alert_id']);
$oper_type = addslashes($_POST['oper_type']);
$msg_title = addslashes($_POST['alert_title']);
$msg_text = addslashes($_POST['alert_text']);
$msg_groups = split("-",$_POST['gid']);
$alert_type = addslashes($_POST['type']);
$schedule_date = addslashes($_POST['schedule_date']);
$schedule_time = addslashes($_POST['schedule_time']);
$schedule_repeat = addslashes($_POST['schedule_repeat']);
$date_split = split('-', $schedule_date);
$schedule_date = $date_split[2].'-'.$date_split[1].'-'.$date_split[0];

if(strtoupper($oper_type) == 'EDIT') {
    $alert_id = string_wslashes($alert_id);
    if(!is_numeric($alert_id)) exit;
}

if(strtoupper($oper_type) == 'SCHEDULE_NEW' || strtoupper($oper_type) == 'SCHEDULE_SAVED') $scheduled_status = 9;
else $scheduled_status = 0;

$reply_msgs = array();

$reply_msgs[0] = "Thank You! Your message has been saved successfully.";
$reply_msgs[1] = "Unknown alert type, contact Souktel administrator for further information.";
$reply_msgs[2] = "You are not autherized to access these groups.";
$reply_msgs[3] = "Sorry! There is an error, please try again later.";
$reply_msgs[4] = "Sorry! There is an error, please make sure you entered the right date and time.";
$reply_msgs[5] = "Thank You! Your message has been scheduled successfully.";
$reply_msgs[6] = "Thank You! Your message has been sent successfully.";
$reply_msgs[7] = "Sorry! There is no members in the groups, please try again later.";
$reply_msgs[8] = "Sorry! You don't have enough credit.";

mysql_query("BEGIN", $dbid);

$is_error = 0;

//Check Groups Autherization
for($gi = 0; $gi < sizeof($msg_groups)-1; $gi++) {
    $tochk_group = $msg_groups[$gi];
    if($rs_auth_grp_own = mysql_query("SELECT 1 FROM tbl_alert_group WHERE group_id = $tochk_group AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid)) {
        $num_rows = mysql_num_rows($rs_auth_grp_own);
        if($num_rows == 0 || $num_rows == false) {
            if($rs_auth_grp_snd = mysql_query("SELECT 1 FROM tbl_alert_group_senders WHERE group_id = $tochk_group AND owner_id = $param_session_user_user_id", $dbid)) {
                $num_rows = mysql_num_rows($rs_auth_grp_snd);
                if($num_rows == 0 || $num_rows == false) {
                    $is_error = 2;
                    break;
                }
            }
        }
    }
}
//==Check Groups Autherization

if($is_error == 0) {
    if((strtoupper($oper_type) == 'SAVE' || strtoupper($oper_type) == 'SCHEDULE_NEW' || strtoupper($oper_type) == 'SEND_NEW') && $alert_id == '') {
    //Saving Alert
        if(strtoupper($alert_type)=='NORMAL') {
            if(!mysql_query("INSERT INTO tbl_alerts_message VALUES(message_id, $param_session_user_user_id, '$msg_title', '$msg_text', CURRENT_TIMESTAMP, 0, NULL, NULL, 0, 0)",$dbid)) {
                $is_error = 3;
            }
        } else if (strtoupper($alert_type)=='SCHEDULED') {
                if($schedule_date!="" && $schedule_time != "0") {
                    if(!mysql_query("INSERT INTO tbl_alerts_message VALUES(message_id, $param_session_user_user_id, '$msg_title', '$msg_text', CURRENT_TIMESTAMP, 1,'$schedule_date', $schedule_time, $schedule_repeat, $scheduled_status)",$dbid)) {
                        $is_error = 4;
                    }
                } else {
                    $is_error = 4;
                }
            } else {
                $is_error = 1;
            }
    } else if(strtoupper($oper_type) == 'EDIT' || strtoupper($oper_type) == 'SCHEDULE_SAVED' || strtoupper($oper_type) == 'SEND_SAVED' || ($alert_id != '' && is_numeric($alert_id))) {
        //Editing Alert
            if(strtoupper($alert_type)=='NORMAL') {
                if(!mysql_query("UPDATE tbl_alerts_message SET title = '$msg_title', body = '$msg_text', is_scheduled = 0, schedule_date = NULL, schedule_time = NULL, is_repeat = 0, status = 0 WHERE message_id = $alert_id AND user_id = $param_session_user_user_id",$dbid)) {
                    $is_error = 3;
                }
            } else if (strtoupper($alert_type)=='SCHEDULED') {
                    if($schedule_date!="" && $schedule_time != "0") {
                        if(!mysql_query("UPDATE tbl_alerts_message SET title = '$msg_title', body = '$msg_text', is_scheduled = 1, schedule_date = '$schedule_date', schedule_time = $schedule_time, is_repeat = $schedule_repeat, status = $scheduled_status WHERE message_id = $alert_id AND user_id = $param_session_user_user_id",$dbid)) {
                            $is_error = 4;
                        }
                    } else {
                        $is_error = 4;
                    }
                } else {
                    $is_error = 1;
                }
        }

    if($is_error==0) {
        if(strtoupper($oper_type) == 'EDIT' || strtoupper($oper_type) == 'SCHEDULE_SAVED' || strtoupper($oper_type) == 'SEND_SAVED' || ($alert_id != '' && is_numeric($alert_id))) {
            $message_id = $alert_id;
            if(!mysql_query("DELETE FROM tbl_alerts_message_groups WHERE message_id = $message_id",$dbid)) {
                $is_error = 3;
            }
        } else if((strtoupper($oper_type) == 'SAVE' || strtoupper($oper_type) == 'SCHEDULE_NEW' || strtoupper($oper_type) == 'SEND_NEW') && $alert_id == '') {
                $message_id = mysql_insert_id($dbid);
                $alert_id = $message_id;
            }
        for($i = 0; $i < sizeof($msg_groups)-1; $i++) {
            $curr_group = $msg_groups[$i];
            if(!mysql_query("INSERT INTO tbl_alerts_message_groups VALUES($message_id,$curr_group)",$dbid)) {
                $is_error = 3;
                break;
            }
        }
    }

}

if($is_error == 0) mysql_query("COMMIT", $dbid);
else mysql_query("ROLLBACK", $dbid);

if($is_error == 0 && $scheduled_status == 9) {
    $is_error = 5;
}

if($is_error == 0 && (strtoupper($oper_type) == 'SEND_SAVED' || strtoupper($oper_type) == 'SEND_NEW')) {
//##################################################################################################
    mysql_query("BEGIN", $dbid);

    //Check Groups Autherization
    for($gi = 0; $gi < sizeof($msg_groups)-1; $gi++) {
        $tochk_group = $msg_groups[$gi];
        if($rs_auth_grp_own = mysql_query("SELECT 1 FROM tbl_alert_group WHERE group_id = $tochk_group AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid)) {
            $num_rows = mysql_num_rows($rs_auth_grp_own);
            if($num_rows == 0 || $num_rows == false) {
                if($rs_auth_grp_snd = mysql_query("SELECT 1 FROM tbl_alert_group_senders WHERE group_id = $tochk_group AND owner_id = $param_session_user_user_id", $dbid)) {
                    $num_rows = mysql_num_rows($rs_auth_grp_snd);
                    if($num_rows == 0 || $num_rows == false) {
                        $is_error = 2;
                        break;
                    }
                }
            }
        }
    }
    //==Check Groups Autherization

    if($is_error == 0) {
        if($alert_id != '') {
        //Security BUG :: TO BE FIXED
            if(!mysql_query("INSERT INTO tbl_alerts_message_log VALUES($alert_id, 1, CURRENT_TIMESTAMP)",$dbid)) {
                $is_error = 3;
            }
        }
        if($is_error == 0) {
            $selected_groups = trim(join(',', $msg_groups),',');
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
                    $msgId = generateMsgId($param_session_sys_api_id);
                    $db_msg_text = string_wslashes($msg_text);
                    $group_reference = join("-", $members_total_grp);
                    if($rs_senderid = mysql_query("SELECT sender_id FROM tbl_sys_senderid WHERE sys_id = $param_session_sys_id", $dbid)) {
                        if($req_sender_id_arr = mysql_fetch_array($rs_senderid)) {
                            $req_sender_id = $req_sender_id_arr[0];
                        }
                    }
                    if(trim($req_sender_id)=='') $req_sender_id = '37190';
                    mysql_query("INSERT INTO tbl_sms VALUES(sms_id, $param_session_sys_id, 'Souktel', '37190', '$param_session_user_mobile', 'G', '$msgId', CURRENT_TIMESTAMP, '$db_msg_text', 1, $members_size, 2, 1, 0)", $dbid);
                    $sms_message_id = mysql_insert_id($dbid);
                    for($no_rec = 0; $no_rec < sizeof($members_total_mob); $no_rec++) {
                        $member_mobile = trim($members_total_mob[$no_rec]);
                        $member_group = trim(strtoupper($members_total_grp[$no_rec]));
                        if($member_mobile != '') mysql_query("INSERT INTO tbl_sms_receivers VALUES($sms_message_id, '$member_mobile', '$member_group', '', NULL,'')", $dbid);
                    }
					
                    $send_faild = sendBulkSMS($msgId, $members_total_mob, stripslashes(stripslashes(stripslashes($msg_text))), $dbid, $param_session_sys_api_id, $param_session_sys_api_key);
                    if($send_faild != false) {
                        $is_error = 8;
                    } else {
                        $is_error = 6;
                    }
                } else {
                    $is_error = 7;
                }
            }
        }
    }

    if($is_error == 0 || $is_error == 6) mysql_query("COMMIT", $dbid);
    else mysql_query("ROLLBACK", $dbid);
//##################################################################################################
}

db_close($dbid);
?>
<?php echo $alert_id."@@@".$reply_msgs[$is_error];?>