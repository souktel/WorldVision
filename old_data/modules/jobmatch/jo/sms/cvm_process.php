<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($sms_user_user_type == 2)
{
    if(get_process() != "")
    {
        if($sms_process == 4000)
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
c.reference_code, 
(
ifnull((SELECT $se FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND major = (SELECT major FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND education_level >= (SELECT education_level FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND experience >= (SELECT experience FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND city = (SELECT city FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND hours_range = (SELECT hours_range FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)
) AS wgt 
FROM tbl_js_mini_cv c, tbl_sys_user su 
WHERE c.user_id = su.user_id 
AND c.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND su.status >= 1 
AND c.status >= 1 
AND (
ifnull((SELECT $se FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND major = (SELECT major FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND education_level >= (SELECT education_level FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND experience >= (SELECT experience FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND city = (SELECT city FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_js_mini_cv WHERE cv_id = c.cv_id AND hours_range = (SELECT hours_range FROM tbl_jo_job_vacancy WHERE reference_code = '$reference' AND user_id = $sms_user_user_id)),0)
) >= 7 
ORDER BY wgt DESC, c.addition_date DESC LIMIT $limit1, $limit2
";

                if($cv_rs = mysql_query($query,$sms_dbid))
                {
                    $rowsn = $sizet;

                    $co = 0;
                    $start = $co+1;
                    $nooo = true;
                    $refs = "";
                    while($cv_row = mysql_fetch_array($cv_rs))
                    {
                        $co++;
                        $rs_wgt = $cv_row['wgt'];
                        $rs_wgt = round(($rs_wgt/31), 2) * 100;
                        $rs_wgt .= "%";
                        $refs .= $cv_row[0]." $rs_wgt, ";
                        $nooo = false;
                        if($co%$pagesize == 0) break;
                    }

                    $nextres = $co+$sizef;
                    $start +=$sizef;

                    if($nooo)
                    {
                        mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sms_sys_id AND mobile = '$sms_user_mobile'", $sms_dbid);
                        reply("A72", null);
                    }else
                    {
                        $sms_process_value1 = $reference;
                        $sms_process_value2 = "$nextres-$rowsn";
                        set_next_process(4000);
                        $refs = trim($refs);
                        $refs = trim($refs, ",");
                        if($nextres >= $rowsn) endprocess();
                        if($nextres < $rowsn) reply("A73", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                        else reply("A74", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

                    }
                }
                else
                {
                    reply("A75", null);
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