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
$param_fun_menu[$fun_menu_count][0] = "Create Job Vacancy";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/create_jv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_jv.png";

$param_fun_menu[$fun_menu_count][0] = "List Job Vacancies";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_jv.png";

$param_fun_menu[$fun_menu_count][0] = "View Job Vacancy";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/view_jv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_jv.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Job Vacancy";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/edit_jv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_jv.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Job Vacancy";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/delete_jv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_jv.png";   

$param_fun_menu[$fun_menu_count][0] = "Match Me";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/match_cv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."match.png"; 

$param_fun_menu[$fun_menu_count][0] = "Search CVs";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/search_cv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."search.png";  

$param_fun_menu[$fun_menu_count][0] = "View Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/view_cv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_cv.png";

$param_fun_menu[$fun_menu_count][0] = "List CVs";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/jo/web/list_cvs.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_cv.png";

?>
