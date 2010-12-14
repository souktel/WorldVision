<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("A91", null);
}
else
{
    $reference = strtoupper($command_array[1]);
    mysql_query("BEGIN");
    if(mysql_query("UPDATE tbl_jo_job_vacancy SET status = $sh_status WHERE lower(reference_code) = lower('$reference') AND sys_id = $sms_sys_id AND user_id = $sms_user_user_id",$sms_dbid))
    {
        if(mysql_affected_rows($sms_dbid) == 1)
        {
            mysql_query("COMMIT");
            $new_status = ($sh_status==1?"visible":"invisible");
            reply("A92", array("@#reference"=>$reference, "@#new_status"=>$new_status));
        }
        else
        {
            mysql_query("ROLLBACK");
            reply("A93", null);
        }
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("A94", null);
    }
}

?>