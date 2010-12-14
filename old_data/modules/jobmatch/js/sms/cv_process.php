<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{    
    if($sms_process == 1700)
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        if(!mysql_query("UPDATE tbl_js_mini_cv SET education_level = $req_msg WHERE cv_id = $sms_process_value1", $sms_dbid))
        {
            reply("B14", null);
        }
        else
        {
            $nextp = get_next_process();
            if($nextp != 1701 )
            {
                reply_process($nextp,"2)");
            }
            else
            {
                reply_static("2)".get_majors(1));
            }
        }
    }
    else if($sms_process == 1701)
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        if(!mysql_query("UPDATE tbl_js_mini_cv SET major = $req_msg WHERE cv_id = $sms_process_value1", $sms_dbid))
        {
            reply("B15", null);
        }
        else
        {
            reply_process(get_next_process(),"3)");
        }
    }
    else if($sms_process == 1702)
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
                reply("B16", null);
            }
            else
            {
                reply_process(get_next_process(),"4)");
            }
        }
        else
        {
            reply("B17", null);
        }
    }
    else if($sms_process == 1703)
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
                reply("B18", null);
            }
            else
            {
                mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                reply("B19", array("@#sms_process_value2"=>$sms_process_value2, "@#sms_process_value2"=>$sms_process_value2));
            }
        }
        else
        {
            reply("B20", null);
        }
    }
}  
?>
