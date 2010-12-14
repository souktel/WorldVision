<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/* 
 * Survey Answering with Reference Masking
 */

$survey_mask = strtolower($req_msg);

if($rs_survey_mask = mysql_query("
SELECT s.reference_code, m.language_id
 FROM tbl_survey s, tbl_survey_mask m, tbl_sys_user u
 WHERE s.sys_id = u.sys_id
 AND s.owner_id = u.user_id
 AND s.sys_id = m.sys_id
 AND s.owner_id = m.owner_id
 AND s.survey_id = m.survey_id
 AND u.status >= 1
 AND s.status >= 1
 AND lower(m.mask) = lower('$survey_mask')
 AND lower(m.shortcode) = lower('$req_senderx')
 LIMIT 0, 1
", $sms_dbid))
{
    if($row_survey_mask = mysql_fetch_array($rs_survey_mask))
    {
        if($row_survey_mask[1] == "2" || $row_survey_mask[1] == 2)
        $req_msg = "اجب ".$row_survey_mask[0];
        else
        $req_msg = "ans ".$row_survey_mask[0];
    }
}
/*
if(strtolower($req_msg) == "survey")
{
    $req_msg = "ans S153";
}

if(strtolower($req_msg) == "no")
{
    $req_msg = "ans S141";
}

if(strtolower($req_msg) == "job" || strtolower($req_msg) == "شغل")
{
    $req_msg = "ans S154";
}

if(strtolower($req_msg) == "team" || strtolower($req_msg) == "فريق")
{
    $req_msg = "ans S120";
}

if(strtolower($req_msg) == "سجل" || strtolower($req_msg) == "ساجل")
{
    $req_msg = "ans S122";
}

if(strtolower($req_msg) == "طعام" || strtolower($req_msg) == "food")
{
    $req_msg = "ans S121";
}

if(strtolower($req_msg) == "راي")
{
    $req_msg = "ans S127";
}

if(strtolower($req_msg) == "راي2")
{
    $req_msg = "ans S128";
}
*/
?>
