<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZ234vvvdkfgjZSD4352SDdfZz22W")
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

$survey_id = string_wslashes($_POST['sid']);
$question_id = string_wslashes($_POST['qid']);
$title = string_wslashes($_POST['title']);
$option_a = array();

$fieldo = string_wslashes($_POST['option1']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$fieldo = string_wslashes($_POST['option2']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$fieldo = string_wslashes($_POST['option3']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$fieldo = string_wslashes($_POST['option4']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$fieldo = string_wslashes($_POST['option5']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$fieldo = string_wslashes($_POST['option6']);
if(strlen(trim($fieldo))>0) $option_a[] = trim($fieldo);

$qtype = string_wslashes($_POST['qtype']);

if($qtype == "1" && sizeof($option_a)==0) $error_found = true;

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0 && $error_found == false)
{
    $dbid = db_connect();

    mysql_query("BEGIN",$dbid);

    $continue = false;
    $crs = mysql_query("SELECT 1 FROM tbl_survey WHERE survey_id = $survey_id AND owner_id = $param_session_user_user_id",$dbid);
    if($crs)
    {
        $continue = mysql_num_rows($crs)==1?true:false;
        if($continue)
        {
            $rs = mysql_query("UPDATE tbl_survey_question SET qtype = $qtype WHERE question_id = $question_id AND survey_id = $survey_id",$dbid);
            if(!$rs)
            {
                $error_found = true;
                $error_no = "1601";
                mysql_query("ROLLBACK",$dbid);
            }
            else
            {
                $rs1 = mysql_query("UPDATE tbl_survey_question_title SET title = '$title' WHERE question_id = $question_id AND survey_id = $survey_id AND language_id = $param_session_sys_language",$dbid);
                if(!$rs1)
                {
                    $error_found = true;
                    $error_no = "1602";
                    mysql_query("ROLLBACK",$dbid);
                }
                else
                {
                    $rs3 = mysql_query("DELETE FROM tbl_survey_option WHERE question_id = $question_id AND survey_id = $survey_id",$dbid);
                    if(!$rs3)
                    {
                        $error_found = true;
                        $error_no = "1603";
                        mysql_query("ROLLBACK",$dbid);
                    }
                    else
                    {
                        if($qtype==1)
                        {
                            for($oii=0; $oii<sizeof($option_a); $oii++)
                            {
                                $oii1 = $oii+1;
                                $rs2 = mysql_query("INSERT INTO tbl_survey_option VALUES($oii1, $question_id, $survey_id, null, null)", $dbid);
                                if(!$rs2)
                                {
                                    $error_found = true;
                                    $error_no = "1604";
                                    mysql_query("ROLLBACK",$dbid);
                                    break;
                                }
                                else
                                {
                                    $opt_title = $option_a[$oii];
                                    $rs3 = mysql_query("INSERT INTO tbl_survey_option_title VALUES($oii1, $question_id, $survey_id, $param_session_sys_language,'$opt_title')",$dbid);
                                    if(!$rs3)
                                    {
                                        $error_found = true;
                                        $error_no = "1605";
                                        mysql_query("ROLLBACK",$dbid);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                if($error_found==false) mysql_query("COMMIT",$dbid);
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
    header("Location: ".$param_server."/modules/surveys/web/edit_questions.php?sid=$survey_id");
    //for($oii=0; $oii<sizeof($option_a); $oii++) echo $option_a[$oii];
}

?>
