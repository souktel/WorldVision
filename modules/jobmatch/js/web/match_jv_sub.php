<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}  
?>

<?php

$reference = trim(string_wslashes($_GET['reference']));
$ex = string_wslashes($_GET['ex']);
$wh = string_wslashes($_GET['wh']);
$el = string_wslashes($_GET['el']);
$se = string_wslashes($_GET['se']);
$lc = string_wslashes($_GET['lc']);

//Pages
$pageNum = 1;

if(isset($_GET['page']))
{
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "
SELECT 
v.job_id, 
v.vacancy_title, 
v.reference_code, 
(SELECT name FROM tbl_ref_city_title WHERE city_id = v.city AND language_id = $param_session_sys_language) AS cityname, 
v.addition_date, 
(
ifnull((SELECT $se FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND major = (SELECT major FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND education_level <= (SELECT education_level FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND experience <= (SELECT experience FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND city = (SELECT city FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND hours_range = (SELECT hours_range FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)
) AS wgt 
FROM tbl_jo_job_vacancy v, tbl_sys_user su 
WHERE v.user_id = su.user_id 
AND v.sys_id = su.sys_id 
AND su.sys_id = $param_session_sys_id 
AND su.status >= 1 
AND v.status >= 1 
AND (
ifnull((SELECT $se FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND major = (SELECT major FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $el FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND education_level <= (SELECT education_level FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $ex FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND experience <= (SELECT experience FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $lc FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND city = (SELECT city FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)+
ifnull((SELECT $wh FROM tbl_jo_job_vacancy WHERE job_id = v.job_id AND hours_range = (SELECT hours_range FROM tbl_js_mini_cv WHERE reference_code = '$reference' AND user_id = $param_session_user_user_id)),0)
) >= 7 
ORDER BY wgt DESC, v.addition_date DESC
";


$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="275"><font face="Trebuchet MS" size="2"><b>Job Title</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b>Location</b></font></td>
        <td width="175"><font face="Trebuchet MS" size="2"><b>Creation Date</b></font></td>
    </tr>
    <?php
    //$co = 0;
    while($row = mysql_fetch_array($rs))
    {
        //$co++;
        //$rs_number = $co;
        $rs_job_id = $row['job_id'];
        $rs_vacancy_title = $row['vacancy_title'];
        $rs_reference = $row['reference_code'];
        $rs_city = $row['cityname'];
        $rs_addition_date = $row['addition_date'];
        $rs_wgt = $row['wgt'];
        $rs_wgt = round(($rs_wgt/31), 2) * 100;
        $rs_wgt .= "%";

        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib."view_jv_s.png";?>"></font></td>
        <td width="275" align="left"><font face="Trebuchet MS" size="2"><a href="view_jv.php?jid=<?php echo $rs_job_id;?>"><?php echo $rs_vacancy_title;?><font dir="rtl">&nbsp;<?php echo "($rs_wgt)";?>&nbsp;</font></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><?php echo $rs_city;?></font></td>
        <td width="175"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
    </tr>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php

require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>
