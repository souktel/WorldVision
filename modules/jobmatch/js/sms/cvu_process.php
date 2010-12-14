<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{   
    if($sms_process == 1950)
    {
        if(okCMD($req_msg))
        {
            $nextp = get_next_process();
            if($nextp != 1900 )
            {
                reply_process($nextp,"");
            }
            else
            {
                reply_static(get_levels(1));
            }
        }
        else
        {
            reply("B40", array("@#ok_command"=>$ok_command));
        }
    }
    else if($sms_process == 1900)
    {
        if(skipCMD($req_msg))
        {
            $nextp = get_next_process();
            if($nextp != 1901 )
            {
                reply_process($nextp,"");
            }
            else
            {
                reply_static(get_majors(1));
            }
        }
        else
        {
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if(!mysql_query("UPDATE tbl_js_mini_cv SET education_level = $req_msg WHERE cv_id = $sms_process_value1", $sms_dbid))
            {
                reply("B41", null);
            }
            else
            {
                $nextp = get_next_process();
                if($nextp != 1901 )
                {
                    reply_process($nextp,"");
                }
                else
                {
                    reply_static(get_majors(1));
                }
            }
        }
    }
    else if($sms_process == 1901)
    {
        if(skipCMD($req_msg))
        {
            reply_process(get_next_process(),"");
        }
        else
        {
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if(!mysql_query("UPDATE tbl_js_mini_cv SET major = $req_msg WHERE cv_id = $sms_process_value1", $sms_dbid))
            {
                reply("B42", null);
            }
            else
            {
                reply_process(get_next_process(),"");
            }
        }
    }
    else if($sms_process == 1902)
    {
        if(skipCMD($req_msg))
        {
            reply_process(get_next_process(),"");
        }
        else
        {
            $invalid_imput = true;
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if($req_msg == "1" || $req_msg == 1 || $req_msg == "2" || $req_msg == 2
                || $req_msg == "3" || $req_msg == 3 || $req_msg == "4" || $req_msg == 4)
            {
                $invalid_imput = false;
            }
            if($invalid_imput == false)
            {
                if(!mysql_query("UPDATE tbl_js_mini_cv SET hours_range = $req_msg WHERE cv_id = $sms_process_value1", $sms_dbid))
                {
                    reply("B43", null);
                }
                else
                {
                    reply_process(get_next_process(),"");
                }
            }
            else
            {
                reply("B44", null);
            }
        }
    }
    else if($sms_process == 1903)
    {
        if(skipCMD($req_msg))
        {
            mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
            reply("C53", array("@#sms_process_value2"=>$sms_process_value2));
        }
        else
        {
            $invalid_imput = true;

            if(is_numeric(convertStr2Nbr($req_msg)) && is_numeric(convertStr2Nbr($req_msg)) && convertStr2Nbr($req_msg) >=0)
            {
                $req_experience = convertStr2Nbr($req_msg);
                $invalid_imput = false;
            }

            if($invalid_imput == false)
            {
                if(!mysql_query("UPDATE tbl_js_mini_cv SET experience = $req_experience, status = 1 WHERE cv_id = $sms_process_value1", $sms_dbid))
                {
                    reply("B45", null);
                }
                else
                {
                    mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                    reply("B46", array("@#sms_process_value2"=>$sms_process_value2));
                }
            }
            else
            {
                reply("B47", null);
            }
        }
    }
}  
?>
