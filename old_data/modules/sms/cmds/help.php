<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($sms_user_user_type == 1)
{
    reply("B84", null);
} else if($sms_user_user_type == 2)
{
    reply("B85", null);
} else
{
    reply("B86", null);
}
?>
