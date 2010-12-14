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

$dbid = db_connect();

if(mysql_query("INSERT INTO tbl_js_mini_cv VALUES(cv_id, $param_session_sys_id, $param_session_user_user_id, '',$education_level, $major, $hours_range, $driving_license, $country, $city, $experience, '$other_info', 1, CURRENT_TIMESTAMP )",$dbid))
{
    $cv_current_id = mysql_insert_id($dbid);
    $cv_reference = "CV".($cv_current_id+101);
    if(mysql_query("UPDATE tbl_js_mini_cv SET reference_code = '$cv_reference' WHERE cv_id = $cv_current_id", $dbid))
    {
        mysql_query("COMMIT");
    }
    else
    {
        mysql_query("ROLLBACK");
        $error_found = true;
        $error_no = "16011";
    }
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
    header("Location: ".$param_server."/modules/jobmatch/js/web/index.php");
}

?>
