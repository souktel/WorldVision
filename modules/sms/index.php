<?php
header('Content-type: text/html; charset=utf-8');
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../../";

$tw = '&tw=1';

//Database Parameters
require_once($apath."config/parameters/params_db.php");
//Database Connection
require_once($apath."config/database/db_mysql.php");

//Functions
require_once($apath."config/functions/validation.php");
require_once($apath."config/functions/util_func.php");
require_once($apath."config/functions/val_func.php");
require_once($apath."config/functions/oth_func.php");
require_once($apath."config/functions/sms_func.php");
require_once($apath."config/functions/send_func.php");

//Default Values
$sms_api_id = '30002';
$sms_api_key = 'A3FF5RSNED';

//Mobile, Msg, Shortcode
$req_mobile = trim($_GET['from']);
$req_msg = trim($_GET['text']);

$req_psx = trim($_GET['sc']);
$req_intlx = trim($_GET['to']);

if($req_psx != "") {
    $req_ps = $req_psx;
    $req_senderx = $req_ps;
} else if($req_intlx != "") {
    $req_intl = $req_intlx;
    $req_senderx = $req_intl;
}

$req_msg = convertArabic2English($req_msg);

//Global
$sms_user_mobile = $req_mobile;

$log2way_request_msg = $req_msg;
$log2way_request_time = date('Y-m-d H:i:s');

if($req_msg != "")
{
    //Connect to Database
    $sms_dbid = db_connect();

    //Command Prefix
    $command_array = split(" ", $req_msg);

    require_once("../surveys/sms/survey_asnwering.php");

    $current_system_rs = mysql_query("SELECT * FROM tbl_sys s, tbl_user_current_system cs WHERE s.sys_id = cs.sys_id AND cs.mobile = '$sms_user_mobile' ORDER BY last_activity DESC", $sms_dbid);
    if($regc_row = mysql_fetch_array($current_system_rs))
    {
        $sms_sys_id = $regc_row['sys_id'];
        $sms_prefix = $regc_row['prefix'];
        $sms_reference_code = $regc_row['reference_code'];
        $sms_name = $regc_row['name'];
        $sms_default_language = $regc_row['default_language'];
        $sms_country = $regc_row['country'];
        $sms_status = $regc_row['status'];
        $sms_sms_status = $regc_row['sms_status'];
        $sms_timeout = $regc_row['user_session_timeout'];
        $sms_user_language = $regc_row['user_language'];
        $sms_api_id = $regc_row['api_id'];
        $sms_api_key = $regc_row['api_key'];

        $user_rs = mysql_query("SELECT * FROM tbl_sys_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
        if($user_row = mysql_fetch_array($user_rs))
        {
            $sms_user_registered = $user_row['registered'];
            $sms_user_user_id = $user_row['user_id'];
            $sms_user_user_type = $user_row['user_type'];
            $sms_user_status = $user_row['status'];
            $sms_user_country = $user_row['country'];
            $sms_user_city = $user_row['city'];

            //Processes
            if(endCMD($req_msg))
            {
                $is_ended = mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                if(mysql_affected_rows($sms_dbid) >= 1)
                {
                    reply("C37", null);
                }
                else
                {
                    reply("C38", null);
                }
            }

            //Registration Processes
            require_once("cmds/reg_process.php");

            if(authenticated())
            {
                //Job Offerer Registration
                require_once("../jobmatch/jo/sms/jv_process.php");

                //Job Seeker Registration
                require_once("../jobmatch/js/sms/cv_process.php");

                //Job Vacancy Update
                require_once("../jobmatch/jo/sms/jvu_process.php");

                //CV Update
                require_once("../jobmatch/js/sms/cvu_process.php");

                //Match My CV
                require_once("../jobmatch/js/sms/jvm_process.php");

                //Match My JV
                require_once("../jobmatch/jo/sms/cvm_process.php");

                if($sms_user_user_type == 1)
                {
                    require_once("../jobmatch/js/sms/jv_search.php");
                }
                else
                {
                    require_once("../jobmatch/jo/sms/cv_search.php");
                }
            }
        }
    }
    else
    {
        $sms_current = false;
    }

    require_once("smasking.php");

    require_once(chooseCMD($req_msg));

}
else
{
    require_once("others/invalid.php");
}
?>
