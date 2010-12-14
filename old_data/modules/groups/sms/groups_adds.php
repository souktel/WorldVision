<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

mysql_query("BEGIN");

if($group_rs = mysql_query("SELECT group_id FROM tbl_alerts_group WHERE sys_id = $sms_sys_id AND owner_id = $sms_user_user_id AND upper(reference_code) = upper('$group_reference')", $sms_dbid))
{
    if($row_group = mysql_fetch_array($group_rs))
    {
        $group_id = $row_group[0];
        $selected_users = trim(join(",",$users_to_add),",");

        if($sender_rs = mysql_query("SELECT user_id FROM tbl_sys_user WHERE sys_id = $sms_sys_id AND mobile IN ($selected_users)", $sms_dbid))
        {
            $co = 0;
            while($row_sender = mysql_fetch_array($sender_rs))
            {
                $sender_id = $row_sender[0];
                if(mysql_query("INSERT INTO tbl_alerts_group_senders VALUES($group_id, $sender_id)",$sms_dbid))
                {
                    $co++;
                }
            }
            mysql_query("COMMIT");
            reply("A16", array("@#co"=>$co, "@#group_reference"=>$group_reference));
        }
        else
        {
            mysql_query("ROLLBACK");
            reply("A17", null);
        }
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("A18", null);
    }
}
else
{
    mysql_query("ROLLBACK");
    reply("A19", null);
}
?>
