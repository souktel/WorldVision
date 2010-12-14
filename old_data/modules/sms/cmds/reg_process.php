<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($sms_user_user_type == 1)
{
    if(get_process() != "")
    {
        if($sms_process == 1000)
        {
            if(!mysql_query("UPDATE tbl_sys_user SET name = '$req_msg' WHERE sys_id = $sms_sys_id AND user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C02", null);
            }
            else
            {
                $nextp = get_next_process();
                if($nextp != 1001 )
                {
                    reply_process($nextp,"2)");
                }
                else
                {
                    reply_static("2)".get_cities("MSG04"));
                }
            }
        }
        else if($sms_process == 1001)
        {
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if(!mysql_query("UPDATE tbl_sys_user SET city = $req_msg WHERE sys_id = $sms_sys_id AND user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C03", null);
            }
            else
            {
                reply_process(get_next_process(),"3)");
            }
        }
        else if($sms_process == 1002)
        {
            $dob_ymd = str_split($req_msg,2);
            if(sizeof($dob_ymd) < 3) {
                reply("C04", null);
            }
            else
            {
                $dob_y = convertStr2Nbr($dob_ymd[0]); $dob_m = convertStr2Nbr($dob_ymd[1]); $dob_d = convertStr2Nbr($dob_ymd[2]);
                if(is_numeric($dob_y) && $dob_y >=0 && $dob_y <=99)
                {
                    $dob_y = 1900 + $dob_y;
                    $dob_error = !is_valid_date($dob_m,$dob_d,$dob_y,false);
                    if($dob_error || !mysql_query("UPDATE tbl_sys_user_ind SET dob_y = $dob_y, dob_m = $dob_m, dob_d = $dob_d WHERE user_id = $sms_user_user_id", $sms_dbid))
                    {
                        reply("C05", null);
                    }
                    else
                    {
                        reply_process(get_next_process(),"4)");
                    }
                }
                else
                {
                    reply("C05", null);
                }
            }
        }
        else if($sms_process == 1003)
        {
            $gender = 3;
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if($req_msg == 1 || $req_msg == "1" || strtolower($req_msg) == strtolower("m")) $gender = 0;
            else if($req_msg == 2 || $req_msg == "2" || strtolower($req_msg) == strtolower("f")) $gender = 1;

            if($gender == 3) {
                reply("C06", null);
            }
            else
            {
                if(!mysql_query("UPDATE tbl_sys_user_ind SET gender = $gender WHERE user_id = $sms_user_user_id", $sms_dbid))
                {
                    reply("C07", null);
                }
                else
                {
                    $currentp = $sms_process;
                    $nextp = get_next_process();
                    if($currentp == $nextp)
                    {
                        //Set Registered = 1, to be valid user
                        if(!mysql_query("UPDATE tbl_sys_user SET registered = 1, status = 1 WHERE user_id = $sms_user_user_id", $sms_dbid))
                        {
                            reply("C08", null);
                        }
                        else
                        {
                            //Send the PIN code to the user
                            $return_pin_rs = mysql_query("SELECT pin FROM tbl_sys_user WHERE user_id = $sms_user_user_id", $sms_dbid);
                            if($return_pin_row = mysql_fetch_array($return_pin_rs))
                            {
                                //Delete current system, and current process
                                mysql_query("DELETE FROM tbl_user_current_system WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                                mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                                //Reply thanks message
                                $return_pin = $return_pin_row[0];
                                reply("C09", array("@#return_pin"=>$return_pin, "@#sms_prefix"=>$sms_prefix, "@#return_pin"=>$return_pin));
                            }
                            else
                            {
                                reply("C10", null);
                            }
                        }
                    }
                }
            }
        }
    }
}
else if($sms_user_user_type == 2)
{
    if(get_process() != "")
    {
        if($sms_process == 1500)
        {
            if(!mysql_query("UPDATE tbl_sys_user SET name = '$req_msg' WHERE sys_id = $sms_sys_id AND user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C11", null);
            }
            else
            {
                $nextp = get_next_process();
                if($nextp != 1501 )
                {
                    reply_process($nextp,"2)");
                }
                else
                {
                    reply_static("2)".get_cities("MSG04B"));
                }
            }
        }
        else if($sms_process == 1501)
        {
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if(!mysql_query("UPDATE tbl_sys_user SET city = $req_msg WHERE sys_id = $sms_sys_id AND user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C12", null);
            }
            else
            {
                reply_process(get_next_process(),"3)");
            }
        }
        else if($sms_process == 1502)
        {
            if(!mysql_query("UPDATE tbl_sys_user_nind SET phone = '$req_msg' WHERE user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C13", null);
            }
            else
            {
                reply_process(get_next_process(),"4)");
            }
        }
        else if($sms_process == 1503)
        {
            if(!mysql_query("UPDATE tbl_sys_user_nind SET business_field = '$req_msg' WHERE user_id = $sms_user_user_id", $sms_dbid))
            {
                reply("C14", null);
            }
            else
            {
                $currentp = $sms_process;
                $nextp = get_next_process();
                if($currentp == $nextp)
                {
                    //Set Registered = 1, to be valid user
                    if(!mysql_query("UPDATE tbl_sys_user SET registered = 1, status = 1 WHERE user_id = $sms_user_user_id", $sms_dbid))
                    {
                        reply("C15", null);
                    }
                    else
                    {
                        //Send the PIN code to the user
                        $return_pin_rs = mysql_query("SELECT pin FROM tbl_sys_user WHERE user_id = $sms_user_user_id", $sms_dbid);
                        if($return_pin_row = mysql_fetch_array($return_pin_rs))
                        {
                            //Delete current system, and current process
                            mysql_query("DELETE FROM tbl_user_current_system WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                            mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                            //Reply thanks message
                            $return_pin = $return_pin_row[0];
                            reply("C16", array("@#return_pin"=>$return_pin, "@#sms_prefix"=>$sms_prefix, "@#return_pin"=>$return_pin));
                        }
                        else
                        {
                            reply("C17", null);
                        }
                    }
                }
            }
        }
    }
}else
{
    reply("C18", null);
}
?>
