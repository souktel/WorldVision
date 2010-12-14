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

//Retrieve Data
$survey_id = string_wslashes($_POST['sid']);

$startque = string_wslashes($_POST['startque']);

$next_qid_ar = array();
$next_nq_ar = array();

$next_qido_ar = array();
$next_opid_ar = array();
$next_nqo_ar = array();

for($ni = 0; $ni < sizeof($_POST['next_q']); $ni++)
{
    $strsplit = split("-", string_wslashes($_POST['next_q'][$ni]));
    if(sizeof($strsplit)==2)
    {
        $next_qid_ar[] = $strsplit[0];
        $next_nq_ar[] = $strsplit[1]!=""?$strsplit[1]:"null";
    }
    else if(sizeof($strsplit)==3)
    {
        $next_qido_ar[] = $strsplit[0];
        $next_opid_ar[] = $strsplit[1];
        $next_nqo_ar[] = $strsplit[2]!=""?$strsplit[2]:"null";
    }
}

$dbid = db_connect();

mysql_query("BEGIN");

//Essay Question
for($nexti = 0; $nexti < sizeof($next_qid_ar); $nexti++)
{
    $question_id = $next_qid_ar[$nexti];
    $next_que = $next_nq_ar[$nexti];

    //echo "UPDATE tbl_survey_question SET next_que = $next_que WHERE question_id = $question_id AND survey_id = $survey_id"."<br>";

    $next_sid = $next_que=="null"?"null":$survey_id;
    if(!mysql_query("UPDATE tbl_survey_question SET next_sid = $next_sid, next_qid = $next_que WHERE question_id = $question_id AND survey_id = $survey_id",$dbid))
    {
        $error_found = true;
        mysql_query("ROLLBACK");
    }
}

//Multiple Choice Questions
if(!$error_found)
{
    for($nexti = 0; $nexti < sizeof($next_qido_ar); $nexti++)
    {
        $question_id = $next_qido_ar[$nexti];
        $option_id = $next_opid_ar[$nexti];
        $next_que = $next_nqo_ar[$nexti];

        //echo "UPDATE tbl_survey_option SET next_que = $next_que WHERE option_id = $option_id AND question_id = $question_id AND survey_id = $survey_id"."<br>";
        $next_sid = $next_que=="null"?"null":$survey_id;
        if(!mysql_query("UPDATE tbl_survey_option SET next_sid = $next_sid, next_qid = $next_que WHERE option_id = $option_id AND question_id = $question_id AND survey_id = $survey_id",$dbid))
        {
            $error_found = true;
            mysql_query("ROLLBACK");
        }
    }
}

//exit;

//First Question
if(!$error_found)
{
    if(!mysql_query("UPDATE tbl_survey_question SET fst = 1 WHERE survey_id = $survey_id",$dbid))
    {
        $error_found = true;
        mysql_query("ROLLBACK");
    }
    else
    {
        if(!mysql_query("UPDATE tbl_survey_question SET fst = 2 WHERE question_id = $startque AND survey_id = $survey_id",$dbid))
        {
            $error_found = true;
            mysql_query("ROLLBACK");
        }
    }
}

//Commit or NOT
if(!$error_found)
{
    mysql_query("COMMIT");
}

db_close($dbid);

if($error_found)
{
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    header("Location: $param_server"."/modules/surveys/web/questions_path.php?sid=$survey_id");
}
?>