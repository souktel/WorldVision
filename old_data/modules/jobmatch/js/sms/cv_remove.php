<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("B24", null);
}
else
{
    $reference = strtoupper($command_array[1]);
    mysql_query("BEGIN");
    if(mysql_query("DELETE FROM tbl_js_mini_cv WHERE lower(reference_code) = lower('$reference') AND sys_id = $sms_sys_id AND user_id = $sms_user_user_id",$sms_dbid))
    {
        if(mysql_affected_rows($sms_dbid) == 1)
        {
            mysql_query("COMMIT");
            reply("B25", array("@#reference"=>$reference));
        }
        else
        {
            mysql_query("ROLLBACK");
            reply("B26", null);
        }
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("B27", null);
    }
}

?>