<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$error_found = false; //No Error at filrst

if(mysql_query("INSERT INTO tbl_jo_job_vacancy VALUES(job_id, $sms_sys_id, $sms_user_user_id, '', 3, 1, 1, 0, $sms_user_country, $sms_user_city, '', 0, '',0,CURRENT_TIMESTAMP)", $sms_dbid))
{
    $current_id = mysql_insert_id($sms_dbid);
    $reference = "JV".($current_id+101);
    mysql_query("BEGIN");
    if(mysql_query("UPDATE tbl_jo_job_vacancy SET reference_code = '$reference' WHERE job_id = $current_id", $sms_dbid))
    {
        $user_cur_process = 1600;
        if(!mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', $user_cur_process, '$current_id', '$reference')",$sms_dbid))
        {
            mysql_query("ROLLBACK");
            reply("A84", null);
        }
        else
        {
            mysql_query("COMMIT");
            reply_process($user_cur_process, "");
        }
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("A85", null);
    }
}
else
{
    reply("A86", null);
}


?>