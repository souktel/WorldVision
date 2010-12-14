<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../../";

require_once($apath."config/parameters/params_db.php");
require_once($apath."config/database/db_mysql.php");
require_once($apath."config/parameters/params_main.php");
require_once($apath."config/parameters/params_session.php");
require_once($apath."config/parameters/params_header_menu.php");
require_once($apath."auth/check_authentication.php");

if(!check_login_success()) exit;

$modules_v = split(":", $_SESSION['param_session_user_modules']);

$go_exit = true;

for($iv=0; $iv < sizeof($modules_v); $iv++) if(strtolower($modules_v[$iv])=="system") $go_exit = false;

if($go_exit) exit;

if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}



$dbid = db_connect();

$query = "SELECT su.user_type, su.name, su.mobile, cit.name AS city_name, su.addition_date ";
$query .= "FROM tbl_sys_user su, tbl_ref_city ci, tbl_ref_city_title cit WHERE su.sys_id = $param_session_sys_id";
$query .= " AND su.city = ci.city_id AND ci.city_id = cit.city_id AND cit.language_id = $param_session_sys_language";
$query .= " AND su.registered = 1 ORDER BY su.addition_date DESC";

$rs = mysql_query($query, $dbid);

$csv_tab = "\t,";
$csv_line = "\r\n";

$counter = 0;

while($row = mysql_fetch_array($rs))
{
    $counter++;
    $rs_user_type = $row['user_type']==1?"Individual":"Non-Individual";
    $rs_name = $row['name'];
    $rs_mobile = $row['mobile'];
    $rs_city_name = $row['city_name'];
    $rs_addition_date = $row['addition_date'];
    $csvoutput .= $counter.$csv_tab.$rs_user_type.$csv_tab.$rs_name.$csv_tab.$rs_mobile;
    $csvoutput .= $csv_tab.$rs_city_name.$csv_tab.$rs_addition_date.$csv_line;
}

db_close($dbid);

header("Expires: 0");
header("Cache-control: private");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Description: File Transfer");
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=system_users.csv");
echo $csvoutput;

?>