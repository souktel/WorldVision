<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("A20", null);
}
else
{
    $group_name = "";
    for($gn = 1; $gn < sizeof($command_array); $gn++) $group_name .= $command_array[$gn]." ";
    $group_name = trim($group_name);
    if($group_name != "")
    {
        mysql_query("BEGIN");
        if(mysql_query("INSERT INTO tbl_alerts_group VALUES(group_id, $sms_sys_id, $sms_user_user_id, '', '$group_name', '', CURRENT_TIMESTAMP, 1, 0)",$sms_dbid))
        {
            $current_id = mysql_insert_id($sms_dbid);
            $reference = "G".($current_id+1030);
            if(mysql_query("UPDATE tbl_alerts_group SET reference_code = '$reference' WHERE group_id = $current_id",$sms_dbid))
            {
                mysql_query("COMMIT");
                reply("A21", array("@#reference"=>$reference));
            }
            else
            {
                mysql_query("ROLLBACK");
                reply("A22", null);
            }
        }
        else
        {
            mysql_query("ROLLBACK");
            reply("A23", null);
        }
    }
    else
    {
        reply("A24", null);
    }
}

?>