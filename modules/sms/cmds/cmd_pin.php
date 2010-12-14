<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$pin_sys_prefix = "";

if(sizeof($command_array) == 1)
{
    $pin_sys_prefix = "WOG";
}
else if(sizeof($command_array) == 2)
{
    $pin_sys_prefix = strtolower($command_array[1]);
}

$pin_prefix_error = false; //No error at first

if($pin_sys_prefix != "")
{
    //Check if the system prefix is valid
    if($pins_rs = mysql_query("SELECT sys_id FROM tbl_sys WHERE lower(prefix) = lower('$pin_sys_prefix')", $sms_dbid))
    {
        if($pins_row = mysql_fetch_array($pins_rs))
        {
            $pin_sms_sys_id = $pins_row['sys_id'];
        }
        else
        {
            $pin_prefix_error = true;
        }
    }
    else
    {
        $pin_prefix_error = true;
    }

    if($pin_prefix_error == false)
    {

        if($pin_rs = mysql_query("SELECT pin, mobile FROM tbl_sys_user WHERE sys_id = $pin_sms_sys_id AND lower(mobile) = lower('$sms_user_mobile') AND registered = 1", $sms_dbid))
        {
            if($pin_row = mysql_fetch_array($pin_rs))
            {
                $pin_pin = $pin_row[0];
                $pin_mobile = $pin_row[1];
                reply("C73", array("@#pin"=>$pin_pin, "@#mobile"=>$pin_mobile));
            }
            else
            {
                reply("C72", null);
            }
        }
        else
        {
            reply("C72", null);
        }
    }
    else
    {
        reply("C71", null);
    }

}
?>