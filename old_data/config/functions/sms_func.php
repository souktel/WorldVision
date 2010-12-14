<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$sms_current = false;

$sms_sys_id = "";
$sms_prefix = "";
$sms_reference_code = "";
$sms_name = "";
$sms_default_language = "";
$sms_country = "";
$sms_status = "";
$sms_sms_status = "";
$sms_timeout = "";

$sms_user_user_id = "";
$sms_user_user_type = "";
$sms_user_mobile = "";
$sms_user_registered = ""; //0 Registration Process, 1 Registered, 2 Asking for registration
$sms_user_status = "";
$sms_user_country = "";
$sms_user_city = "";
$sms_user_language = 1;

$sms_api_id = "";
$sms_api_key = "";
$sms_default_prefix = "";

$log2way_request_msg = "";
$log2way_request_time = "";

$sms_dbid = ""; //Database Identifier
$sms_process = "";
$sms_process_value1 = "";
$sms_process_value2 = "";

$skip_command = "SKIP";
$more_command = "MORE";
$ok_command = "OK";

$req_msg = "";
$req_ps = "SMS";
$req_intl = "SMS";
$req_sender_id = "";
$req_senderx = "";
$command_array = array();

function endCMD($user_command) {
    $commands = array();
    $commands[] = "end";
    $commands[] = "stop";
    $commands[] = "انهاء";//enha2

    for($i=0; $i < sizeof($commands); $i++) {
        if(strtolower($user_command)==strtolower($commands[$i])) {
            return true;
        }
    }

    return false;
}

function overCMD($user_command) {
    $commands = array();
    $commands[] = "over";
    $commands[] = "اكثر"; //akthar
    $commands[] = "أكثر"; //akthar

    for($i=0; $i < sizeof($commands); $i++) {
        if(strtolower($user_command)==strtolower($commands[$i])) {
            return true;
        }
    }

    return false;
}

function moreCMD($user_command) {
    $commands = array();
    $commands[] = "more";
    $commands[] = "مزيد"; //mazeed

    for($i=0; $i < sizeof($commands); $i++) {
        if(strtolower($user_command)==strtolower($commands[$i])) {
            return true;
        }
    }

    return false;
}

function skipCMD($user_command) {
    $commands = array();
    $commands[] = "skip";
    $commands[] = "#";

    for($i=0; $i < sizeof($commands); $i++) {
        if(strtolower($user_command)==strtolower($commands[$i])) {
            return true;
        }
    }

    return false;
}

function okCMD($user_command) {
    $commands = array();
    $commands[] = "ok";
    $commands[] = "موافق";//mowafeq

    for($i=0; $i < sizeof($commands); $i++) {
        if(strtolower($user_command)==strtolower($commands[$i])) {
            return true;
        }
    }

    return false;
}

function updatelng() {
    global $sms_dbid,$sms_user_language,$sms_user_mobile, $sms_sys_id;
    mysql_query("UPDATE tbl_user_current_system SET user_language = $sms_user_language WHERE lower(mobile) = lower('$sms_user_mobile')", $sms_dbid);
}

function endprocess() {
    global $sms_sys_id, $sms_user_mobile, $sms_dbid;
    mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
}

function verifySingleModule($module_id) {
    global $sms_dbid, $sms_sys_id, $sms_user_mobile;
    if($rs = mysql_query("SELECT m.module_id FROM tbl_sys_user u, tbl_sys_user_module m WHERE m.user_id = u.user_id AND u.sys_id = $sms_sys_id AND u.mobile = '$sms_user_mobile' AND m.module_id = $module_id", $sms_dbid)) {
        if($row = mysql_fetch_array($rs)) {
            return true;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}

function verifyModule($module) {
    $modules = array();
    $modules = split("@#", $module);
    for($i=0; $i<sizeof($modules); $i++) {
        if(verifySingleModule($modules[$i])) {
            return true;
        }
    }
    return false;
}

function getTranslation($msg_code) {
    global $sms_dbid,$sms_user_language;
    if($row = mysql_fetch_array(mysql_query("SELECT msg FROM tbl_reply_msg WHERE id = '$msg_code' AND language_id = $sms_user_language LIMIT 0, 1", $sms_dbid))) {
        return $row[0];
    }
}

function splitCMD($command_selected)
{
    global $command_array, $req_msg;
    $req_msg1 = "CMD".substr($req_msg, strlen($command_selected));
    $req_msg1 = trim($req_msg1);
    $command_array = null;
    $command_array = split(" ", $req_msg1);
    $command_array[0] = $command_selected;
}

function chooseCMD($user_msg) {
    global $sms_dbid,$sms_user_language;

    $invalid_path = "others/invalid.php";
    $login_first_path = "others/loginfirst.php";
    $permission_path = "others/permission.php";

    $query = "SELECT * FROM tbl_command WHERE upper('$user_msg') LIKE concat(upper(command),'%') ORDER BY command DESC LIMIT 0, 1";

    $command_rs = mysql_query($query, $sms_dbid);
    if($command_row = mysql_fetch_array($command_rs)) {
        $command_selected = $command_row[0];
        $sms_user_language = $command_row[1];
        $module = $command_row[2];
        $req_auth = $command_row[3];
        $cmd_path = $command_row[4];
        updatelng();
        if($req_auth == 1 || $req_auth == "1") {
            if(authenticated()) {
                if($module != "") {
                    if(verifyModule($module)) {
                        splitCMD($command_selected);
                        return $cmd_path;
                    }
                    else {
                        return $permission_path;
                    }
                }
                else {
                    splitCMD($command_selected);
                    return $cmd_path;
                }
            }
            else {
                return $login_first_path;
            }
        }
        else {
            splitCMD($command_selected);
            return $cmd_path;
        }
    }
    else {
        return $invalid_path;
    }

}

function convertStr2Nbr($str_orig) {
    $strArr = str_split($str_orig);
    $str2return = "";
    for($xi=0; $xi < sizeof($strArr); $xi++) {
        if($strArr[$xi] == '0') $str2return .= 0;
        else if($strArr[$xi] == '1') $str2return .= 1;
            else if($strArr[$xi] == '2') $str2return .= 2;
                else if($strArr[$xi] == '3') $str2return .= 3;
                    else if($strArr[$xi] == '4') $str2return .= 4;
                        else if($strArr[$xi] == '5') $str2return .= 5;
                            else if($strArr[$xi] == '6') $str2return .= 6;
                                else if($strArr[$xi] == '7') $str2return .= 7;
                                    else if($strArr[$xi] == '8') $str2return .= 8;
                                        else if($strArr[$xi] == '9') $str2return .= 9;
    }
    return $str2return;
}

function convertArabic2English($orig_msg) {
    $orig_msg = str_replace("٠","0",$orig_msg);
    $orig_msg = str_replace("١","1",$orig_msg);
    $orig_msg = str_replace("٢","2",$orig_msg);
    $orig_msg = str_replace("٣","3",$orig_msg);
    $orig_msg = str_replace("٤","4",$orig_msg);
    $orig_msg = str_replace("٥","5",$orig_msg);
    $orig_msg = str_replace("٦","6",$orig_msg);
    $orig_msg = str_replace("٧","7",$orig_msg);
    $orig_msg = str_replace("٨","8",$orig_msg);
    $orig_msg = str_replace("٩","9",$orig_msg);
    return $orig_msg;
}

function log_2way($plog_shortcode, $plog_mobile, $plog_reply_msg) {
    global $sms_dbid, $log2way_request_msg, $log2way_request_time;
    mysql_query("INSERT INTO tbl_2way_log VALUES(id, '$plog_shortcode', '$plog_mobile', '$log2way_request_msg', '$log2way_request_time', '$plog_reply_msg', CURRENT_TIMESTAMP)", $sms_dbid);
}

function reply_static($msg_text) {
    global $sms_user_mobile, $sms_sys_id, $req_senderx;
    if(strtolower($_GET['tester_agent']) == "yes1") {
        echo $msg_text;
    }
    else {
        $recievers_a = array($sms_user_mobile);
        send_sms($req_senderx, $sms_sys_id, $recievers_a, $msg_text, 1,'');
    }
    log_2way($req_senderx, $sms_user_mobile, $msg_text);
    exit;
}

function reply($msg_code, $repl_arr) {
    global $sms_dbid, $sms_user_language, $sms_sys_id, $sms_user_mobile, $req_senderx;
    if($row = mysql_fetch_array(mysql_query("SELECT msg, id FROM tbl_reply_msg WHERE id = '$msg_code' AND language_id = $sms_user_language LIMIT 0, 1", $sms_dbid))) {
        $msg = $row[0];
        $msgid = $row[1];

        if($repl_arr != null) {
            $repl_arrk = array_keys($repl_arr);
            for($i = 0; $i < sizeof($repl_arrk); $i++) {
                $msg = str_ireplace($repl_arrk[$i], $repl_arr[$repl_arrk[$i]], $msg);
            }
        }

        $msg = $msg." ($msgid)";

        $recievers_a = array($sms_user_mobile);
        if(strtolower($_GET['tester_agent']) == "yes1") {
            echo $msg;
        }
        else {
            send_sms($req_senderx, $sms_sys_id, $recievers_a, $msg, 1,'');
        }
        log_2way($req_senderx, $sms_user_mobile, $msg);
        exit;
    }
}

//Check if the user athenticated or not
function authenticated() {
    global $sms_sys_id, $sms_user_user_id, $sms_timeout,
    $sms_user_registered, $sms_user_status, $sms_user_mobile, $sms_dbid;
    if($sms_user_registered != 1 || !($sms_user_status >= 1) || $sms_user_mobile == "") {
        return false;
    }
    else {
        if($login_rs = mysql_query("SELECT 1 FROM tbl_user_current_system WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile' AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(last_activity) <= $sms_timeout", $sms_dbid)) {
            if($login_row = mysql_fetch_array($login_rs)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}

//Current Process Id
function get_process() {
    global $sms_sys_id, $sms_user_mobile, $sms_dbid, $sms_process, $sms_process_value1, $sms_process_value2;
    if($process_rs = mysql_query("SELECT process_id, value1, value2 FROM tbl_process_user WHERE mobile = '$sms_user_mobile' AND sys_id = $sms_sys_id", $sms_dbid)) {
        if($process_row = mysql_fetch_array($process_rs)) {
            $sms_process = $process_row['process_id'];
            $sms_process_value1 = $process_row['value1'];
            $sms_process_value2 = $process_row['value2'];
            return $sms_process;
        }
        else {
            return "";
        }
    }
    else {
        return "";
    }
}

//Current Process Id
function get_next_process() {
    global $sms_sys_id, $sms_user_mobile, $sms_dbid, $sms_process, $sms_process_value1, $sms_process_value2;
    if($process_rs = mysql_query("SELECT nextp FROM tbl_process WHERE process_id = $sms_process", $sms_dbid)) {
        if($process_row = mysql_fetch_array($process_rs)) {
            $sms_process = $process_row['nextp'];
            mysql_query("UPDATE tbl_process_user SET process_id = $sms_process, value1 = '$sms_process_value1', value2 = '$sms_process_value2' WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'",$sms_dbid);
            return $sms_process;
        }
        else {
            return "";
        }
    }
    else {
        return "";
    }
}

function set_next_process($set_process) {
    global $sms_sys_id, $sms_user_mobile, $sms_dbid, $sms_process, $sms_process_value1, $sms_process_value2;
    $sms_process = $set_process;
    mysql_query("UPDATE tbl_process_user SET process_id = $sms_process, value1 = '$sms_process_value1', value2 = '$sms_process_value2' WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'",$sms_dbid);
}

//Reply the next process message
function reply_process($process_id, $order_num) {
    global $sms_dbid, $sms_user_language;
    if($process_rs = mysql_query("SELECT msg FROM tbl_process_lng WHERE process_id = $process_id AND language_id = $sms_user_language", $sms_dbid)) {
        if($process_row = mysql_fetch_array($process_rs)) {
            reply_static($order_num.$process_row['msg']);
            db_close($sms_dbid);
            exit;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }
}

function get_cities($msg_id) {
    global $sms_dbid, $sms_country, $sms_user_language;
    $cities = getTranslation($msg_id);
    if($process_rs = mysql_query("SELECT ct.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE c.city_id = ct.city_id AND c.country_id = $sms_country AND ct.language_id = $sms_user_language", $sms_dbid)) {
        while($process_row = mysql_fetch_array($process_rs)) {
            $cities .= $process_row[0].".".$process_row[1]." ";
        }
    }
    return $cities;
}

function get_levels($language_id) {
    global $sms_dbid, $sms_user_language, $sms_user_user_type;
    $levels = "";

    if($sms_user_user_type==1)$levels=getTranslation("MSG02");
    else $levels=getTranslation("MSG01");

    if($process_rs = mysql_query("SELECT level_id, name FROM tbl_ref_education_level_title WHERE language_id = $sms_user_language", $sms_dbid)) {
        while($process_row = mysql_fetch_array($process_rs)) {
            $levels .= $process_row[0].".".$process_row[1]." ";
        }
    }
    return $levels;
}

function get_majors($language_id) {
    global $sms_dbid, $sms_user_language;
    $majors = getTranslation("MSG03");
    if($process_rs = mysql_query("SELECT major_id, name FROM tbl_ref_major_title WHERE language_id = $sms_user_language", $sms_dbid)) {
        while($process_row = mysql_fetch_array($process_rs)) {
            $majors .= $process_row[0].".".$process_row[1]." ";
        }
    }
    return $majors;
}

function send_sms($sender, $sys_id, $recievers_a, $sms_body, $reason, $sendby2) {
    global $sms_dbid, $sms_provider, $sms_url, $sms_user_mobile, $sms_api_id, $sms_api_key;

    $msgId = generateMsgId($sms_api_id);

    $success_flag = true;

    $nor = sizeof($recievers_a);

    $sms_body2 = string_wslashes($sms_body);
    mysql_query("BEGIN", $sms_dbid);
    if($sys_id=='')$sys_id = 1;
    mysql_query("INSERT INTO tbl_sms VALUES(sms_id, $sys_id, '$sms_provider', '$sender', '$sms_user_mobile', '$sendby2', '$msgId', CURRENT_TIMESTAMP, '$sms_body2', 1, $nor, $reason, 1, 0)", $sms_dbid);
    $msgidpk = mysql_insert_id($sms_dbid);
    for($reci=0; $reci < $nor; $reci++) {
        $rec = $recievers_a[$reci];
        mysql_query("INSERT INTO tbl_sms_receivers VALUES($msgidpk, '$rec', '$sendby2', '', NULL, '$msgId')", $sms_dbid);
    }

    $send_faild = sendBulkSMS($msgId, $recievers_a, $sms_body, $sms_dbid, $sms_api_id, $sms_api_key);
    if($sendby2 == '') $success_flag = true;
    else if($send_faild == false) $success_flag = true;
        else $success_flag = false;

    if($success_flag) {
        mysql_query("COMMIT", $sms_dbid);
        return true;
    } else {
        mysql_query("ROLLBACK", $sms_dbid);
        return false;
    }
}

function getJVCV() {
    global $sms_dbid, $sms_user_mobile, $sms_sys_id, $sms_user_user_type;


}

//Get Next Question
function getNextQuestion($mobile, $currentSid, $currentQid) {
    global $sms_dbid;

    $delete_current_survey = false; //Delete Current Survey Flag :: If Next Que Is Null, Or is Final Message

    $ques = array();
    if($currentQid == "") {
        $question_rs = mysql_query("SELECT q.question_id, qt.title,q.qtype FROM tbl_survey_question q, tbl_survey_question_title qt WHERE q.survey_id = qt.survey_id AND q.question_id = qt.question_id AND q.survey_id = $currentSid AND q.fst = 2 AND qt.language_id = 1",$sms_dbid);
        if($question_rs) {
            if($question_row = mysql_fetch_array($question_rs)) {
                $ques[0] = $question_row[0];
                $currentQid = $ques[0];
                if($question_row[2]==0) //Essay Question ;Just Question Text
                {
                    $ques[1] = $question_row[1];
                }
                else if($question_row[2]==2) //Final Message ;Just Text; Remove Mobile From Current Survey
                    {
                        $ques[1] = $question_row[1];
                        mysql_query("DELETE FROM tbl_survey_current WHERE mobile = '$mobile'", $sms_dbid);
                    }
                    else if($question_row[2]==1) //Multiple Choice Question ;Question Text + Options
                        {
                            $ques[1] = $question_row[1];
                            $options_rs = mysql_query("SELECT o.option_id, ot.title FROM tbl_survey_option o, tbl_survey_option_title ot WHERE o.survey_id = ot.survey_id AND o.question_id = ot.question_id AND o.option_id = ot.option_id AND o.survey_id = $currentSid AND o.question_id = $currentQid AND ot.language_id = 1 ORDER BY o.option_id ASC",$sms_dbid);
                            if($options_rs) {
                                while($options_row = mysql_fetch_array($options_rs)) {
                                    $ques[1] .= " ".$options_row[0]."-".$options_row[1];
                                }
                            }
                            else {
                                return false;
                            }
                        }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    else {
        $question_rs = mysql_query("SELECT q.question_id, qt.title,q.qtype FROM tbl_survey_question q, tbl_survey_question_title qt WHERE q.survey_id = qt.survey_id AND q.question_id = qt.question_id AND q.survey_id = $currentSid AND q.question_id = $currentQid AND qt.language_id = 1",$sms_dbid);
        if($question_rs) {
            if($question_row = mysql_fetch_array($question_rs)) {
                $ques[0] = $question_row[0];
                $currentQid = $ques[0];
                if($question_row[2]==0) //Essay Question ;Just Question Text
                {
                    $ques[1] = $question_row[1];
                }
                else if($question_row[2]==2) //Final Message ;Just Text; Remove Mobile From Current Survey
                    {
                        $ques[1] = $question_row[1];
                        mysql_query("DELETE FROM tbl_survey_current WHERE mobile = '$mobile'", $sms_dbid);
                    }
                    else if($question_row[2]==1) //Multiple Choice Question ;Question Text + Options
                        {
                            $ques[1] = $question_row[1];
                            $options_rs = mysql_query("SELECT o.option_id, ot.title FROM tbl_survey_option o, tbl_survey_option_title ot WHERE o.survey_id = ot.survey_id AND o.question_id = ot.question_id AND o.option_id = ot.option_id AND o.survey_id = $currentSid AND o.question_id = $currentQid AND ot.language_id = 1 ORDER BY o.option_id ASC",$sms_dbid);
                            if($options_rs) {
                                while($options_row = mysql_fetch_array($options_rs)) {
                                    $ques[1] .= " ".$options_row[0]."-".$options_row[1];
                                }
                            }
                            else {
                                return false;
                            }
                        }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    mysql_query("UPDATE tbl_survey_current SET survey_id = $currentSid, question_id = $currentQid WHERE mobile = '$mobile'", $sms_dbid);
    return $ques;
}

?>
