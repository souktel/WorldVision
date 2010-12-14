<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$is_login = mysql_query("DELETE FROM tbl_user_current_system WHERE mobile = '$sms_user_mobile' AND sys_id = $sms_sys_id", $sms_dbid);
if(mysql_affected_rows($sms_dbid) >= 1)
{
    reply("B97", null);
}
else
{
    reply("B98", null);
}
?>
