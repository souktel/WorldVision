<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("A99", null);
}
else
{
    $reference = strtoupper($command_array[1]);
    if($jv_rs = mysql_query("SELECT su.mobile,
(SELECT gender FROM tbl_sys_user_ind WHERE user_id = su.user_id) AS gender, 
(SELECT name FROM tbl_ref_major_title WHERE major_id = jv.major AND language_id = $sms_user_language) AS sector, 
(SELECT name FROM tbl_ref_education_level_title WHERE level_id = jv.education_level AND language_id = $sms_user_language) AS level, 
(SELECT name FROM tbl_ref_city_title WHERE city_id = jv.city AND language_id = $sms_user_language) AS location, 
jv.experience, 
jv.hours_range
FROM tbl_jo_job_vacancy jv, tbl_sys_user su WHERE lower(jv.reference_code) = lower('$reference') 
AND su.sys_id = $sms_sys_id AND su.user_id = jv.user_id AND su.status >= 1 AND jv.status >= 1",$sms_dbid))
    {
        if($jv_row = mysql_fetch_array($jv_rs))
        {
            $jv_mobile = $jv_row[0];
            $jv_gender = $jv_row[1]==0?getTranslation("MSG08"):getTranslation("MSG09");
            $jv_major = $jv_row[2];
            $jv_level = $jv_row[3];
            $jv_city = $jv_row[4];
            $jv_experience = $jv_row[5];
            if($jv_experience == 0) $jv_experience = getTranslation("MSG05");
            else if($jv_experience == 1) $jv_experience = getTranslation("MSG06");
            else $jv_experience = $jv_experience." ".getTranslation("MSG07");
            $jv_hours_range = $jv_row[6];
            switch($jv_hours_range)
            {
                case 1:
                    $jv_hours_range = getTranslation("MSG11");
                    break;
                case 2:
                    $jv_hours_range = getTranslation("MSG12");
                    break;
                case 3:
                    $jv_hours_range = getTranslation("MSG13");
                    break;
                case 4:
                    $jv_hours_range = getTranslation("MSG14");
                }
                reply("B01", array("@#jv_mobile"=>$jv_mobile,"@#jv_major"=>$jv_major,"@#jv_city"=>$jv_city,"@#jv_level"=>$jv_level,"@#jv_experience"=>$jv_experience,"@#hours_range"=>$jv_hours_range));
            }
            else
            {
                reply("B02", null);
            }
        }
        else
        {
            reply("B03", null);
        }
    }

    ?>