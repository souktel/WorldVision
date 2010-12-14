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
/*
 * Tamer Qasim
 */

$cv_id = string_wslashes($_POST['cv_id']);
if(!is_numeric($cv_id)) exit;

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$experience = string_wslashes($_POST['experience']);
$education_level = string_wslashes($_POST['education_level']);
$major = string_wslashes($_POST['major']);
$country = string_wslashes($_POST['country']);
$city = string_wslashes($_POST['city']);
$hours_range = string_wslashes($_POST['hours_range']);
$driving_license = string_wslashes($_POST['driving_license']);
$other_info = string_wslashes($_POST['other_info']);
$status = string_wslashes($_POST['status']);


$dbid = db_connect();

if(mysql_query("UPDATE tbl_js_mini_cv SET education_level = $education_level, major = $major, hours_range = $hours_range, driving_license = $driving_license, country = $country, city = $city, experience = $experience, other_info = '$other_info', status = $status WHERE cv_id = $cv_id AND sys_id = $param_session_sys_id AND user_id = $param_session_user_user_id",$dbid))
{
    mysql_query("COMMIT");
}
else
{
    mysql_query("ROLLBACK");
    $error_found = true;
    $error_no = "1601";
}

db_close($dbid);


if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    $return_url = $_POST["return_url"];
    header("Location: $return_url");
}

?>
