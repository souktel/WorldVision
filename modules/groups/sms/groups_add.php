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
        $co = 0;
        for($mc=0; $mc < sizeof($users_to_add); $mc++)
        {
            $member_mobile = $users_to_add[$mc];
            if(mysql_query("INSERT INTO tbl_alerts_group_members VALUES($group_id, '$member_mobile', '','','','')",$sms_dbid))
            {
                $co++;
            }
        }
        mysql_query("COMMIT");
        reply("A13", array("@#co"=>$co, "@#group_reference"=>$group_reference));
    }
    else
    {
        mysql_query("ROLLBACK");
        reply("A14", null);
    }
}
else
{
    mysql_query("ROLLBACK");
    reply("A15", null);
}
?>
