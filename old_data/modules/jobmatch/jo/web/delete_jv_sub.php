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

$error_found = false;

$job_id = string_wslashes($_POST['job_id']);
if(!is_numeric($job_id)) exit;

$dbid = db_connect();

if(mysql_query("DELETE FROM tbl_jo_job_vacancy WHERE job_id = $job_id AND sys_id = $param_session_sys_id AND user_id = $param_session_user_user_id", $dbid))
{
    $error_found = false;
}
else
{
    $error_no = "8102"; //Nothing Deleted
    $error_found = true;
}

db_close($dbid);

if($error_found == false)
{
    $return_url = $_POST["return_url"];
    header("Location: $return_url");
}
else
{
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}

?>
