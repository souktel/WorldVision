<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */
function int_int_divide($x, $y) {
    return ($x - ($x % $y)) / $y;
}

if($sms_user_user_type == 1)
{
    if(get_process() != "")
    {
        if($sms_process == 3000)
        {
            if(moreCMD($req_msg))
            {
                $reference = $sms_process_value1;

                $size_a = split("-",$sms_process_value2);
                $sizef = $size_a[0];
                $sizet = $size_a[1];
                $pagesize = 2;

                //Default WGT
                $ex = 1;
                $wh = 2;
                $el = 4;
                $se = 16;
                $lc = 8;

                $limit1 = $sizef;
                $limit2 = $sizet;
                
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
ORDER BY wgt DESC, v.addition_date DESC LIMIT $limit1, $limit2
";

                if($jv_rs = mysql_query($query,$sms_dbid))
                {
                    $rowsn = $sizet;

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

                    $nextres = $co+$sizef;
                    $start +=$sizef;

                    if($nooo)
                    {
                        mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                        reply("B79", null);
                    }else
                    {
                        $sms_process_value1 = $reference;
                        $sms_process_value2 = "$nextres-$rowsn";
                        set_next_process(3000);
                        $refs = trim($refs);
                        $refs = trim($refs, ",");
                        if($nextres >= $rowsn) endprocess();
                        if($nextres < $rowsn) reply("B80", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                        else reply("B81", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                    }
                }
                else
                {
                    reply("B82", null);
                }
            }
            else
            {
                endprocess();
            }
        }
    }
}
?>