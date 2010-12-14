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
$survey_id = string_wslashes($_POST['survey_id']);
if(!is_numeric($survey_id)) exit;  

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$title = string_wslashes($_POST['title']);
$description = string_wslashes($_POST['description']);
$status = string_wslashes($_POST['status']);

//Name
$rules[] = ("required,title,Required : Title.");
$rules[] = ("length<=100,title,Title : < 100 chars please.");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    mysql_query("BEGIN",$dbid);

    $rs = mysql_query("SELECT 1 FROM tbl_survey WHERE survey_id = $survey_id AND owner_id = $param_session_user_user_id",$dbid);

    if(!$rs)
    {
        $error_found = true;
        $error_no = "1601";
        mysql_query("ROLLBACK",$dbid);
    }
    else
    {
        if(mysql_fetch_array($rs))
        {
            $rs1 = mysql_query("UPDATE tbl_survey SET status = $status WHERE survey_id = $survey_id",$dbid);
            if(!$rs1)
            {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK",$dbid);
            }
            else
            {
                $rs2 = mysql_query("UPDATE tbl_survey_title SET title = '$title', description = '$description' WHERE survey_id = $survey_id AND language_id = $param_session_sys_language", $dbid);
                if(!$rs2)
                {
                    $error_found = true;
                    $error_no = "1602";
                    mysql_query("ROLLBACK",$dbid);
                }
                else
                {
                    mysql_query("COMMIT",$dbid);
                }
            }
        }
    }

    db_close($dbid);

}
else
{
    $error_found = true;
    $error_no = "1501";
}

if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    header("Location: ".$param_server."/modules/surveys/web/index.php");
}

?>
