<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

//Check whether this mobile number already registered within the requested system or not

$pin_code = "";

if(sizeof($command_array) <= 1)
{
    reply("B88", null);
}
else if(sizeof($command_array) == 3)
{
    $sys_prefix = strtolower($command_array[1]);
    $pin_code = $command_array[2];
}
else if(sizeof($command_array) == 2)
{
    $sys_prefix = "SK";
    $pin_code = $command_array[1];
}

$prefix_error = false; //No error at first

if($sys_prefix != "")
{
    //Check if the system prefix is valid
    if($regc_rs = mysql_query("SELECT * FROM tbl_sys WHERE lower(prefix) = lower('$sys_prefix')", $sms_dbid))
    {
        if($regc_row = mysql_fetch_array($regc_rs))
        {
            $sms_sys_id = $regc_row['sys_id'];
            $sms_prefix = $regc_row['prefix'];
            $sms_reference_code = $regc_row['reference_code'];
            $sms_name = $regc_row['name'];
            $sms_default_language = $regc_row['default_language'];
            $sms_country = $regc_row['country'];
            $sms_status = $regc_row['status'];
            $sms_sms_status = $regc_row['sms_status'];
            $sms_timeout = $regc_row['user_session_timeout'];
            if($sms_status <= 0 || $sms_status == '0') reply("C35", null);
        }
        else
        {
            $prefix_error = true;
        }
    }
    else
    {
        $prefix_error = true;
    }

    //Check if the mobile number already registered for this mobile number

    $mobile_registered = false;//At first, mobile number not registered

    if($prefix_error == false)
    {
        if($regc_rs = mysql_query("SELECT user_id, user_type, status, pin FROM tbl_sys_user WHERE sys_id = $sms_sys_id AND registered = 1 AND mobile = '$sms_user_mobile'", $sms_dbid))
        {
            if($regc_row = mysql_fetch_array($regc_rs))
            {
                $mobile_registered = true;
                $sms_user_user_id = $regc_row[0];
                $sms_user_user_type = $regc_row[1];
                $sms_user_status = $regc_row[2];
                $user_pin = $regc_row[3];
            }
        }

        if($mobile_registered == true)
        {
            if(strtolower($user_pin) == strtolower($pin_code))
            {
                if($sms_user_status == 1)
                {
                    mysql_query("BEGIN");

                    //Delete user current system
                    if(mysql_query("DELETE FROM tbl_user_current_system WHERE mobile = '$sms_user_mobile' AND sys_id = $sms_sys_id", $sms_dbid)) {
                        if(mysql_query("INSERT INTO tbl_user_current_system VALUES('$sms_user_mobile', $sms_sys_id, CURRENT_TIMESTAMP,1)", $sms_dbid)) {
                            if(mysql_query("UPDATE tbl_sys_user_lastlogin SET last_login = CURRENT_TIMESTAMP WHERE user_id = $sms_user_user_id", $sms_dbid)) {
                                mysql_query("COMMIT");
                                reply("B89", null);
                            }
                            else
                            {
                                mysql_query("ROLLBACK");
                                reply("B90", null);
                            }
                        }
                        else
                        {
                            mysql_query("ROLLBACK");
                            reply("B91", null);
                        }
                    }
                    else
                    {
                        mysql_query("ROLLBACK");
                        reply("B92", null);
                    }
                }
                else
                {
                    reply("B93", null);
                }
            }
            else
            {
                reply("B94", null);
            }
        }
        else
        {
            reply("B95", null);
        }

    }
    else
    {
        reply("C70", null);
    }

}



?>