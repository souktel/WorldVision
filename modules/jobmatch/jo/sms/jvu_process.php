<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{    
    if($sms_process == 1850)
    {
        if(okCMD($req_msg))
        {
            reply_process(get_next_process(),"");
        }
        else
        {
            reply("B04", array("@#ok_command"=>$ok_command));
        }
    }
    else if($sms_process == 1800)
    {
        if(skipCMD($req_msg))
        {
            $nextp = get_next_process();
            if($nextp != 1801 )
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
            if(!mysql_query("UPDATE tbl_jo_job_vacancy SET vacancy_title = '$req_msg' WHERE job_id = $sms_process_value1", $sms_dbid))
            {
                reply("B05", null);
            }
            else
            {
                $nextp = get_next_process();
                if($nextp != 1801 )
                {
                    reply_process($nextp,"");
                }
                else
                {
                    reply_static(get_levels(1));
                }
            }
        }
    }
    else if($sms_process == 1801)
    {
        if(skipCMD($req_msg))
        {
            $nextp = get_next_process();
            if($nextp != 1802 )
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
            if(!mysql_query("UPDATE tbl_jo_job_vacancy SET education_level = $req_msg WHERE job_id = $sms_process_value1", $sms_dbid))
            {
                reply("B06", null);
            }
            else
            {
                $nextp = get_next_process();
                if($nextp != 1802 )
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
    else if($sms_process == 1802)
    {
        if(skipCMD($req_msg))
        {
            reply_process(get_next_process(),"");
        }
        else
        {
            $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
            if(!mysql_query("UPDATE tbl_jo_job_vacancy SET major = $req_msg WHERE job_id = $sms_process_value1", $sms_dbid))
            {
                reply("B07", null);
            }
            else
            {
                reply_process(get_next_process(),"");
            }
        }
    }
    else if($sms_process == 1803)
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
                if(!mysql_query("UPDATE tbl_jo_job_vacancy SET hours_range = $req_msg WHERE job_id = $sms_process_value1", $sms_dbid))
                {
                    reply("B08", null);
                }
                else
                {
                    reply_process(get_next_process(),"");
                }
            }
            else
            {
                reply("B09", null);
            }
        }
    }
    else if($sms_process == 1804)
    {
        if(skipCMD($req_msg))
        {
            mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
            reply("B10", array("@#sms_process_value2"=>$sms_process_value2));
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
                if(!mysql_query("UPDATE tbl_jo_job_vacancy SET experience = $req_experience, status = 1 WHERE job_id = $sms_process_value1", $sms_dbid))
                {
                    reply("B11", null);
                }
                else
                {
                    mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                    reply("B12", array("@#sms_process_value2"=>$sms_process_value2));
                }
            }
            else
            {
                reply("B13", null);
            }
        }
    }
}  
?>
