<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($sms_user_user_type == 1)
{
    mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', 2000, '', '')",$sms_dbid);
    reply_process(2000, "");
}
else
{
    mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', 5000, '', '')",$sms_dbid);
    reply_process(5000, "");
}
?>
