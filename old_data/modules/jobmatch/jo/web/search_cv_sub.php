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

$experience = string_wslashes($_GET['experience']);
$education_level = string_wslashes($_GET['education_level']);
$major = string_wslashes($_GET['major']);
$country = string_wslashes($_GET['country']);
$city = string_wslashes($_GET['city']);
$hours_range = string_wslashes($_GET['hours_range']);
$gender = string_wslashes($_GET['gender']);
$experience_s = $experience=="NA"?false:true;
$education_level_s = $education_level=="NA"?false:true;
$major_s = $major=="NA"?false:true;
$country_s = $country=="NA"?false:true;
$city_s = $city=="NA"?false:true;
$hours_range_s = $hours_range=="NA"?false:true;
$gender_s = $gender=="NA"?false:true;

$search_array = array();

if($experience_s)
{
    $search_array[] = "("."v.experience >= $experience".")";
}
if($education_level_s)
{
    $search_array[] = "("."v.education_level <= $education_level".")";
}
if($major_s)
{
    $search_array[] = "("."v.major = $major".")";
}
if($country_s)
{
    $search_array[] = "("."v.country = $country".")";
}
if($city_s)
{
    $search_array[] = "("."v.city = $city".")";
}
//Problem
if($hours_range_s)
{
    $search_array[] = "(("."v.hours_range >= $hours_range"."))";
}
if($gender_s)
{
    $search_array[] = "("."ui.gender = $gender".")";
}

$search_string = "";

if(sizeof($search_array) > 0)
{

    $search_string = "AND (".implode(" AND ", $search_array).")";

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
    $query = "SELECT v.cv_id, u.name AS uname, v.reference_code, ct.name AS cityname, v.addition_date FROM tbl_js_mini_cv v, tbl_sys_user u, tbl_ref_city_title ct, tbl_sys_user_ind ui WHERE v.sys_id = $param_session_sys_id AND v.user_id = u.user_id AND u.user_id = ui.user_id AND u.status > 0 AND v.status > 0 AND ct.city_id = v.city AND ct.language_id = $param_session_sys_language $search_string ORDER BY v.addition_date DESC";

    $numrows = mysql_num_rows(mysql_query($query,$dbid));

    $rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

    ?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="275"><font face="Trebuchet MS" size="2"><b>Full Name</b></font></td>
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
        $rs_cv_id = $row['cv_id'];
        $rs_uname = $row['uname'];
        $rs_reference = $row['reference_code'];
        $rs_city = $row['cityname'];
        $rs_addition_date = $row['addition_date'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib."view_cv_s.png";?>"></font></td>
        <td width="275"><font face="Trebuchet MS" size="2"><a href="view_cv.php?cid=<?php echo $rs_cv_id;?>"><?php echo $rs_uname;?></a></font></td>
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
}
db_close($dbid);
?>
