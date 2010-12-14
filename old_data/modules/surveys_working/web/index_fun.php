<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains the function list buttons
 */

$fun_menu_count = 0;   

 /*
  * Menu Items
  * Index 0 = Button Title
  * Index 1 = Link
  */
$param_fun_menu[$fun_menu_count][0] = "Create Survey";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/create_survey.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_survey.png";

$param_fun_menu[$fun_menu_count][0] = "All Surveys";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_surveys.png";

$param_fun_menu[$fun_menu_count][0] = "Survey Summary";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/view_survey.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_survey.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Survey";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/edit_survey.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_survey.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Survey";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/delete_survey.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_survey.png";  

$param_fun_menu[$fun_menu_count][0] = "Survey Questions";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/editm_survey.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."questions.png";

$param_fun_menu[$fun_menu_count][0] = "Survey Summary";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/view_survey.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_survey.png";

$param_fun_menu[$fun_menu_count][0] = "Create Question";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/create_question.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_question.png";

$param_fun_menu[$fun_menu_count][0] = "Questions' Path";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/questions_path.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."questions_path.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Question";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/delete_question.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_question.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Question";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/edit_question.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_question.png";

$param_fun_menu[$fun_menu_count][0] = "Question Summary";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/view_question.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_question.png";

$param_fun_menu[$fun_menu_count][0] = "Survey Results";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/survey_results.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."result_survey.png";

$param_fun_menu[$fun_menu_count][0] = "Survey Results";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/ex_survey_results.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."result_survey.png";

//if($param_session_user_user_id == 1 || $param_session_user_user_id == "1")
//{
    $param_fun_menu[$fun_menu_count][0] = "Assign Keyword";
    $param_fun_menu[$fun_menu_count][1] = $param_server."/modules/surveys/web/survey_mask.php";
    $param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."masking.png";
//}

?>
