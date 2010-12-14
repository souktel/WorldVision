<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(get_process() != "")
{    
    if($sms_process >=5003 && $sms_process <= 5007
        && $sms_process_value1!="" && $sms_process_value2!="" && !moreCMD($req_msg)){
        endprocess();
        $sms_process = "";
    }
    if($sms_process == 5000) //Wecome to Search
    {
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        switch($req_msg)
        {
            case 1:
            $req_msg = 5003;
            set_next_process($req_msg);
            reply_static(get_cities("MSG04B"));
            break;
            case 2:
            $req_msg = 5004;
            set_next_process($req_msg);
            reply_static(get_levels(1));
            break;
            case 3:
            $req_msg = 5005;
            set_next_process($req_msg);
            reply_static(get_majors(1));
            break;
            case 4:
            $req_msg = 5006;
            set_next_process($req_msg);
            reply_process($req_msg,"");
            break;
            case 5:
            $req_msg = 5007;
            set_next_process($req_msg);
            reply_process($req_msg,"");
            break;
            default:
            reply("A49", null);
            break;
        }
    }
    else if($sms_process == 5003)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.city = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_js_mini_cv v, tbl_sys_user su 
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
                reply("A50", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();

                if($nextres < $rowsn) reply("A51", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("A52", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

            }
        }
        else
        {
            reply("A53", null);
        }
        //==
    }
    else if($sms_process == 5004)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.education_level = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_js_mini_cv v, tbl_sys_user su 
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
                reply("A54", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("A55", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("A56", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

            }
        }
        else
        {
            reply("A57", null);
        }
        //==
    }
    else if($sms_process == 5005)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        $req_msg = convertStr2Nbr($req_msg); //::Str2Nbr
        $subquery = "AND v.major = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_js_mini_cv v, tbl_sys_user su 
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
                reply("A58", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("A59", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("A60", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

            }
        }
        else
        {
            reply("A61", null);
        }
        //==
    }
    else if($sms_process == 5006)
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
            reply("A62", null);
        }

        $subquery = "AND v.hours_range = $req_msg";
        $query = "
SELECT v.reference_code FROM 
tbl_js_mini_cv v, tbl_sys_user su 
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
                reply("A63", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("A64", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("A65", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

            }
        }
        else
        {
            reply("A66", null);
        }
        //==
    }
    else if($sms_process == 5007)
    {
        if($sms_process_value1 != $req_msg && !moreCMD($req_msg)) $sms_process_value1 = $req_msg;
        else $req_msg = $sms_process_value1;
        if(is_numeric(convertStr2Nbr($req_msg)) && is_numeric(convertStr2Nbr($req_msg)) && convertStr2Nbr($req_msg) >=0)
        {
            $req_experience = convertStr2Nbr($req_msg);
        }
        else
        {
            reply("A67", null);
        }
        $subquery = "AND v.experience >= $req_experience";
        $query = "
SELECT v.reference_code FROM 
tbl_js_mini_cv v, tbl_sys_user su 
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
                reply("A68", null);
            }else
            {
                $sms_process_value2 = "$nextres-$rowsn";
                $refs = trim($refs);
                $refs = trim($refs, ",");
                set_next_process($sms_process);
                if($nextres >= $rowsn) endprocess();
                if($nextres < $rowsn) reply("A69", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));
                else reply("A70", array("@#start"=>$start, "@#nextres"=>$nextres, "@#rowsn"=>$rowsn, "@#refs"=>$refs));

            }
        }
        else
        {
            reply("A71", null);
        }
        //==
    }
}  
?>
