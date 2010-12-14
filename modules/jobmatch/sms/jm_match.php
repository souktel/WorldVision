<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($command_array[1]=="")
{
    if($sms_user_user_type == 1)
    {
        $matchrs_cv = mysql_query("
SELECT x.reference_code 
 FROM tbl_js_mini_cv x, tbl_sys_user u
 WHERE x.user_id = u.user_id
 AND u.sys_id = $sms_sys_id
 AND u.mobile = '$sms_user_mobile'
 AND x.status > 0
 ORDER BY x.addition_date DESC
 LIMIT 0, 1
", $sms_dbid);
        if($matchrow_cv = mysql_fetch_array($matchrs_cv))
        {
            $command_array[1] = $matchrow_cv[0];
        }
    }
    else if($sms_user_user_type == 2)
    {
        $matchrs_jv = mysql_query("
SELECT x.reference_code 
 FROM tbl_jo_job_vacancy x, tbl_sys_user u
 WHERE x.user_id = u.user_id
 AND u.sys_id = $sms_sys_id
 AND u.mobile = '$sms_user_mobile'
 AND x.status > 0
 ORDER BY x.addition_date DESC
 LIMIT 0, 1
", $sms_dbid);
        if($matchrow_jv = mysql_fetch_array($matchrs_jv))
        {
            $command_array[1] = $matchrow_jv[0];
        }
    }
}

$split_reference = str_split($command_array[1], 2);

if($sms_user_user_type == 1)
{
    if(strtoupper($split_reference[0]) == "CV")
    {
        require_once("../jobmatch/js/sms/jv_match.php");
    }
    else
    {
        reply("C65", null);
    }
}else if($sms_user_user_type == 2)
{
    if(strtoupper($split_reference[0]) == "JV")
    {
        require_once("../jobmatch/jo/sms/cv_match.php");
    }
    else
    {
        reply("C65", null);
    }
}

?>
