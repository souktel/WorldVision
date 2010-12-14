<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("A09", null);
}
else
{
    $reference = $command_array[1];
    mysql_query("BEGIN");
    if(mysql_query("DELETE FROM tbl_alerts_group WHERE lower(reference_code) = lower('$reference') AND sys_id = $sms_sys_id AND owner_id = $sms_user_user_id",$sms_dbid))
    {
        if(mysql_affected_rows($sms_dbid) == 1)
        {
            mysql_query("COMMIT");
            reply("A10", array("@#reference"=>$reference));
        }
        else
        {
            mysql_query("ROLLBACK");
            reply("A11", null);
        }
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("A12", null);
    }
}

?>