<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{
    if($sms_process >=2002 && $sms_process <= 2007
        && $sms_process_value1!="" && $sms_process_value2!="" && !moreCMD($req_msg)){
        endprocess();
        $sms_process = "";
    }
    if($sms_process == 2000) //Wecome to Search
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        switch($req_msg)
        {
            case 1:
            $req_msg = 2002;
            set_next_process($req_msg);
            reply_process($req_msg,"");
            break;
            case 2:
            $req_msg = 2003;
            set_next_process($req_msg);
            reply_static(get_cities("MSG04B"));
            break;
            case 3:
            $req_msg = 2004;
            set_next_process($req_msg);
            reply_static(get_levels(1));
            break;
            case 4:
            $req_msg = 2005;
            set_next_process($req_msg);
            reply_static(get_majors(1));
            break;
            case 5:
            $req_msg = 2006;
            set_next_process($req_msg);
            reply_process($req_msg,"");
            break;
            case 6:
            $req_msg = 2007;
            set_next_process($req_msg);
            reply_process($req_msg,"");
            break;
            default:
            reply("B53", null);
            break;
        }
    }
    else if($sms_process == 2002)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;

        $subquery = "";
        $vacancy_title_split = split(" ", $req_msg);
        $vacancy_array = array();
        for($vi=0; $vi < sizeof($vacancy_title_split); $vi++)
        {
            $vacancy_title_words = strtolower($vacancy_title_split[$vi]);
            if(strlen($vacancy_title_words) >= 2)
            {
                $vacancy_array[] = "lower(v.vacancy_title) LIKE '%$vacancy_title_words%'";
            }
        }
        if(sizeof($vacancy_array) > 0)
        {
            $subquery = "AND (".implode(" OR ", $vacancy_array).")";
        }

        if($subquery == "") reply("B54", null);
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B55", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B58", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B59", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B56", null);
        }
        //==
    }
    else if($sms_process == 2003)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.city = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B57", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B58", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B59", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B60", null);
        }
        //==
    }
    else if($sms_process == 2004)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.education_level = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B61", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B62", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B63", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B64", null);
        }
        //==
    }
    else if($sms_process == 2005)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.major = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B65", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B66", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B67", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B68", null);
        }
        //==
    }
    else if($sms_process == 2006)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        if($req_msg == "1" || $req_msg == 1 || $req_msg == "2" || $req_msg == 2
            || $req_msg == "3" || $req_msg == 3 || $req_msg == "4" || $req_msg == 4)
        {

        }
        else
        {
            reply("B69", null);
        }

        $subquery = "AND v.hours_range = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B70", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B71", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B72", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B73", null);
        }
        //==
    }
    else if($sms_process == 2007)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        if(is_numeric(convertStr2Nbr($req_msg)) && is_numeric(convertStr2Nbr($req_msg)) && convertStr2Nbr($req_msg) >=0)
        {
            $req_experience = convertStr2Nbr($req_msg);
        }
        else
        {
            reply("B74", null);
        }
        $subquery = "AND v.experience <= $req_experience";
        $query = "
SELECT v.reference_code FROM 
tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $sms_sys_id 
AND v.status >= 1 
AND su.status >= 1 $subquery
";
        $pagesize = 2;
        if($sms_process_value2 != "")
        {
            $size_a = split("-",$sms_process_value2);
            $sizef = $size_a[0];
            $sizet = $size_a[1];
            $query .= " LIMIT $sizef, $sizet";
        }
        //TAMER
        if($jv_rs = mysql_query($query,$sms_dbid))
        {
            $rowsn = $sizet;
            if(!($rowsn >= 1)) $rowsn = mysql_num_rows($jv_rs);

            $co = 0;
            $start = $co+1;
            $nooo = true;
            $refs = "";
            while($jv_row = mysql_fetch_array($jv_rs))
            {
                $co++;
                $refs .= $jv_row[0].", ";
                $nooo = false;
                if($co%$pagesize == 0) break;
            }

            $nextres = $co+$sizef;
            $start +=$sizef;

            if($nooo)
            {
                endprocess();
                reply("B75", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("B76", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("B77", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
            }
        }
        else
        {
            reply("B78", null);
        }
        //==
    }
}  
?>
