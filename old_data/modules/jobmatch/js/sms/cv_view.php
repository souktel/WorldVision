<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("B36", null);
}
else
{
    $reference = strtoupper($command_array[1]);

    if($cv_rs = mysql_query("SELECT su.mobile,
(SELECT gender FROM tbl_sys_user_ind WHERE user_id = su.user_id) AS gender, 
(SELECT name FROM tbl_ref_major_title WHERE major_id = cv.major AND language_id = $sms_user_language) AS sector, 
(SELECT name FROM tbl_ref_education_level_title WHERE level_id = cv.education_level AND language_id = $sms_user_language) AS level, 
(SELECT name FROM tbl_ref_city_title WHERE city_id = cv.city AND language_id = $sms_user_language) AS location, 
cv.experience, 
cv.hours_range
FROM tbl_js_mini_cv cv, tbl_sys_user su WHERE lower(cv.reference_code) = lower('$reference') 
AND su.sys_id = $sms_sys_id AND su.user_id = cv.user_id AND su.status >= 1 AND cv.status >= 1",$sms_dbid))
    {
        if($cv_row = mysql_fetch_array($cv_rs))
        {
            $cv_mobile = $cv_row[0];
            $cv_gender = $cv_row[1]==0?getTranslation("MSG08"):getTranslation("MSG09");
            $cv_major = $cv_row[2];
            $cv_level = $cv_row[3];
            $cv_city = $cv_row[4];
            $cv_experience = $cv_row[5];
            if($cv_experience == 0) $cv_experience = getTranslation("MSG05");
            else if($cv_experience == 1) $cv_experience = getTranslation("MSG06");
            else $cv_experience = $cv_experience." ".getTranslation("MSG07");
            $cv_hours_range = $cv_row[6];
            switch($cv_hours_range)
            {
                case 1:
                    $cv_hours_range = getTranslation("MSG11");
                    break;
                case 2:
                    $cv_hours_range = getTranslation("MSG12");
                    break;
                case 3:
                    $cv_hours_range = getTranslation("MSG13");
                    break;
                case 4:
                    $cv_hours_range = getTranslation("MSG14");
                }
            reply("B37", array("@#cv_mobile"=>$cv_mobile,"@#cv_gender"=>$cv_gender,"@#cv_major"=>$cv_major,"@#cv_city"=>$cv_city,"@#cv_level"=>$cv_level,"@#cv_experience"=>$cv_experience,"@#hours_range"=>$cv_hours_range));
        }
        else
        {
            reply("B38", null);
        }
    }
    else
    {
        reply("B39", null);
    }
}

?>