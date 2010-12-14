<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{    
    if($sms_process == 1600)
    {
        if(!mysql_query("UPDATE tbl_jo_job_vacancy SET vacancy_title = '$req_msg' WHERE job_id = $sms_process_value1", $sms_dbid))
        {
            reply("A76", null);
        }
        else
        {
            $nextp = get_next_process();
            if($nextp != 1601 )
            {
                reply_process($nextp,"2)");
            }
            else
            {
                reply_static("2)".get_levels(1));
            }
        }
    }
    else if($sms_process == 1601)
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        if(!mysql_query("UPDATE tbl_jo_job_vacancy SET education_level = $req_msg WHERE job_id = $sms_process_value1", $sms_dbid))
        {
            reply("A77", null);
        }
        else
        {
            $nextp = get_next_process();
            if($nextp != 1602 )
            {
                reply_process($nextp,"3)");
            }
            else
            {
                reply_static("3)".get_majors(1));
            }
        }
    }
    else if($sms_process == 1602)
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        if(!mysql_query("UPDATE tbl_jo_job_vacancy SET major = $req_msg WHERE job_id = $sms_process_value1", $sms_dbid))
        {
            reply("A78", null);
        }
        else
        {
            reply_process(get_next_process(),"4)");
        }
    }
    else if($sms_process == 1603)
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
                reply("A79", null);
            }
            else
            {
                reply_process(get_next_process(),"5)");
            }
        }
        else
        {
            reply("A80", null);
        }
    }
    else if($sms_process == 1604)
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
                reply("A81", null);
            }
            else
            {
                mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                reply("A82", array("@#sms_process_value2"=>$sms_process_value2, "@#sms_process_value2"=>$sms_process_value2));
            }
        }
        else
        {
            reply("A83", null);
        }
    }
}  
?>
