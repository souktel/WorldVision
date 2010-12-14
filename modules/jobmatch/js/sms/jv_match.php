<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("B48", null);
}
else
{
    $reference = strtoupper($command_array[1]);

    //Default WGT
    $ex = 1;
    $wh = 2;
    $el = 4;
    $se = 16;
    $lc = 8;


    $query = "
SELECT 
v.reference_code, 
(
ifnull((SELECT $se FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND major = (SELECT major FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND education_level <= (SELECT education_level FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND experience <= (SELECT experience FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND city = (SELECT city FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND hours_range = (SELECT hours_range FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)
) AS wgt 
FROM tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND su.status >= 1 
AND v.status >= 1 
AND (
ifnull((SELECT $se FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND major = (SELECT major FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND education_level <= (SELECT education_level FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND experience <= (SELECT experience FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND city = (SELECT city FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND hours_range = (SELECT hours_range FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)
) >= 7 
ORDER BY wgt DESC, v.addition_date DESC
";

    if($jv_rs = mysql_query($query,$sms_dbid))
    {
        $rowsn = mysql_num_rows($jv_rs);
        $pagesize = 2;

        $co = 0;
        $start = $co+1;
        $nooo = true;
        $refs = "";
        while($jv_row = mysql_fetch_array($jv_rs))
        {
            $co++;
            $rs_wgt = $jv_row['wgt'];
            $rs_wgt = round(($rs_wgt/31), 2) * 100;
            $rs_wgt .= "%";
            $refs .= $jv_row[0]." $rs_wgt, ";
            $nooo = false;
            if($co%$pagesize == 0) break;
        }

        $nextres = $co;

        if($nooo)
        {
            reply("B49", null);
        }else
        {
            mysql_query("INSERT INTO tbl_process_user VALUES($sms_sys_id, '$sms_user_mobile', 3000, '$reference', '$nextres-$rowsn')",$sms_dbid);
            $refs = trim($refs);
            $refs = trim($refs, ",");
            if($co < $rowsn) {
                reply("B50", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
            else {
                endprocess();
                reply("B51", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
    }
    else
    {
        reply("B52", null);
    }
}

?>