<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$sys_prefix_1 = "WOG";
$sys_id_1 = "";
if($regc_rs = mysql_query("SELECT sys_id FROM tbl_sys WHERE lower(prefix) = lower('$sys_prefix_1')", $sms_dbid))
{
    if($regc_row = mysql_fetch_array($regc_rs))
    {
        $sys_id_1 = $regc_row['sys_id'];
    }
}

$is_activated = mysql_query("UPDATE tbl_sys_user SET registered = 1 WHERE mobile = '$sms_user_mobile' AND sys_id = $sys_id_1 AND registered = 8", $sms_dbid);
if(mysql_affected_rows($sms_dbid) >= 1)
{
    reply("Z01", null);
}
else
{
    reply("Z02", null);
}
?>
