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

$survey_id = string_wslashes($_POST['survey_id']);
$question_id = string_wslashes($_POST['question_id']);
if(!is_numeric($survey_id) || !is_numeric($question_id)) exit;

$dbid = db_connect();

if(mysql_fetch_array(mysql_query("SELECT 1 FROM tbl_survey WHERE survey_id = $survey_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)))
{
    if(mysql_query("DELETE FROM tbl_survey_question WHERE (survey_id = $survey_id AND question_id = $question_id)", $dbid))
    {
        $error_found = false;
    }
    else
    {
        $error_no = "8102"; //Nothing Deleted
        $error_found = true;
    }
}    
db_close($dbid);

if($error_found == false)
{
    header("Location: ".$param_server."/modules/surveys/web/edit_questions.php?sid=$survey_id");
}
else
{
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}

?>
