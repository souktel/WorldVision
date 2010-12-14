<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$error_found = false; //No Error at filrst

if($command_array[1] != "")
{
    $reference = strtoupper($command_array[1]);
    mysql_query("BEGIN");

    if($cv_rs = mysql_query("SELECT cv_id FROM tbl_js_mini_cv WHERE lower(reference_code) = lower('$reference') AND user_id = $sms_user_user_id",$sms_dbid))
    {
        if($cv_row = mysql_fetch_array($cv_rs))
        {
            $requested_id = $cv_row[0];
            $user_cur_process = 1950;
            if(!mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', $user_cur_process, '$requested_id', '$reference')",$sms_dbid))
            {
                mysql_query("ROLLBACK");
                reply("B32", null);
            }
            else
            {
                mysql_query("COMMIT");
                reply_process($user_cur_process, "");
            }
        }
        else
        {
            reply("B33", null);
        }
    }
    else
    {
        reply("B34", null);
    }
}
else
{
    reply("B35", null);
}   
?>