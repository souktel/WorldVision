<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

//Check whether this mobile number already registered within the requested system or not

if(sizeof($command_array) <= 1)
{
    reply("C19", null);
}
else if(sizeof($command_array) >= 3)
{
    if($command_array[2] == 1 || $command_array[2] == "1" || $command_array[2] == 2 || $command_array[2] = "2")
    {
        $sys_prefix = strtolower($command_array[1]);
        $sms_user_user_type = $command_array[2];
    }
    else
    {
        reply("C20", null);
    }
}
else if(sizeof($command_array) == 2)
{
    if($command_array[1] == 1 || $command_array[1] == "1" || $command_array[1] == 2 || $command_array[1] = "2")
    {
        $sys_prefix = "WOG";
        $sms_user_user_type = $command_array[1];
    }
    else
    {
        reply("C21", null);
    }
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
        if($regc_rs = mysql_query("SELECT user_id FROM tbl_sys_user WHERE sys_id = $sms_sys_id AND registered = 1 AND mobile = '$sms_user_mobile'", $sms_dbid))
        {
            if($regc_row = mysql_fetch_array($regc_rs))
            {
                $mobile_registered = true;
            }
        }

        if($mobile_registered == false)
        {
            //Delete all rows for this mobile within this system
            mysql_query("DELETE FROM tbl_sys_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
            mysql_query("DELETE FROM tbl_user_current_system WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
            mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);

            //Start Registration
            $error_found = false;

            $pin = gen_random(4);
            $password = $pin;

            $query = "INSERT INTO tbl_sys_user VALUES(user_id, $sms_sys_id, '$sms_user_mobile', '$pin', '$sms_user_mobile', SHA1('$password'), $sms_user_user_type ,0 ,0, CURRENT_TIMESTAMP, '', $sms_country, 1, '',0)";

            mysql_query("BEGIN");

            if($sms_user_user_type == "1" || $sms_user_user_type == 1)
            {
                if(mysql_query($query,$sms_dbid))
                {
                    $current_id = mysql_insert_id($sms_dbid);
                    $query_insert = "INSERT INTO tbl_sys_user_ind VALUES($current_id, 2000, 1, 1, 0)";
                    if(!mysql_query($query_insert,$sms_dbid))
                    {
                        $error_found = true;
                        mysql_query("ROLLBACK");
                        reply("C22", null);
                    }
                    else
                    {
                        if(!mysql_query("INSERT INTO tbl_sys_user_lastlogin VALUES($current_id, CURRENT_TIMESTAMP)",$sms_dbid))
                        {
                            $error_found = true;
                            mysql_query("ROLLBACK");
                            reply("C23", null);
                        }
                        else
                        {
                            if(!mysql_query("INSERT INTO tbl_user_current_system VALUES('$sms_user_mobile',$sms_sys_id,CURRENT_TIMESTAMP,$sms_user_language)",$sms_dbid))
                            {
                                $error_found = true;
                                mysql_query("ROLLBACK");
                                reply("C24", null);
                            }
                            else
                            {
                                $rs2 = mysql_query("SELECT dm.module_id FROM tbl_sys_default_usertype_module dm, tbl_sys_module sm WHERE sm.sys_id = dm.sys_id AND sm.module_id = dm.module_id AND dm.type_id = $sms_user_user_type AND sm.sys_id = $sms_sys_id", $sms_dbid);
                                while ($row2 = mysql_fetch_array($rs2))
                                {
                                    $available_4user = $row2[0];
                                    $query_insert = "INSERT INTO tbl_sys_user_module VALUES($current_id,$available_4user)";
                                    if(!mysql_query($query_insert,$sms_dbid))
                                    {
                                        $error_found = true;
                                        mysql_query("ROLLBACK");
                                        reply("C25", null);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $error_found = true;
                    mysql_query("ROLLBACK");
                    reply("C26", null);
                }

            }
            else if($sms_user_user_type == "2" || $sms_user_user_type == 2)
            {
                if(mysql_query($query,$sms_dbid))
                {
                    $current_id = mysql_insert_id($sms_dbid);
                    $query_insert = "INSERT INTO tbl_sys_user_nind VALUES($current_id, '', '', '', '', '')";
                    if(!mysql_query($query_insert,$sms_dbid))
                    {
                        $error_found = true;
                        mysql_query("ROLLBACK");
                        reply("C27", null);
                    }
                    else
                    {
                        if(!mysql_query("INSERT INTO tbl_sys_user_lastlogin VALUES($current_id, CURRENT_TIMESTAMP)",$sms_dbid))
                        {
                            $error_found = true;
                            mysql_query("ROLLBACK");
                            reply("C28", null);
                        }
                        else
                        {
                            if(!mysql_query("INSERT INTO tbl_user_current_system VALUES('$sms_user_mobile', $sms_sys_id, CURRENT_TIMESTAMP,$sms_user_language)",$sms_dbid))
                            {
                                $error_found = true;
                                mysql_query("ROLLBACK");
                                reply("C29", null);
                            }
                            else
                            {
                                $rs2 = mysql_query("SELECT dm.module_id FROM tbl_sys_default_usertype_module dm, tbl_sys_module sm WHERE sm.sys_id = dm.sys_id AND sm.module_id = dm.module_id AND dm.type_id = $sms_user_user_type AND sm.sys_id = $sms_sys_id", $sms_dbid);
                                while ($row2 = mysql_fetch_array($rs2))
                                {
                                    $available_4user = $row2[0];
                                    $query_insert = "INSERT INTO tbl_sys_user_module VALUES($current_id,$available_4user)";
                                    if(!mysql_query($query_insert,$sms_dbid))
                                    {
                                        $error_found = true;
                                        mysql_query("ROLLBACK");
                                        reply("C30", null);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $error_found = true;
                    mysql_query("ROLLBACK");
                    reply("C31", null);
                }
            }
            else
            {
                $error_found = true;
                reply("C32", null);
            }

            if(!$error_found) {

                $user_cur_process = 0;
                if($sms_user_user_type == 1) $user_cur_process = 1000;
                else if($sms_user_user_type == 2) $user_cur_process = 1500;

                if(!mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', $user_cur_process, '', '')",$sms_dbid))
                {
                    mysql_query("ROLLBACK");
                    reply("C33", null);
                }
                else
                {
                    mysql_query("COMMIT");
                    reply_process($user_cur_process, "");
                }

            }

        }
        else
        {
            reply("C34", null);
        }

    }

}



?>