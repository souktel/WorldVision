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
$param_fun_menu[$fun_menu_count][0] = "Create Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/create_cv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_cv.png";

$param_fun_menu[$fun_menu_count][0] = "List Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_cv.png";

$param_fun_menu[$fun_menu_count][0] = "View Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/view_cv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_cv.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/edit_cv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_cv.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Mini CV";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/delete_cv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_cv.png";   

$param_fun_menu[$fun_menu_count][0] = "Match Me";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/match_jv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."match.png"; 

$param_fun_menu[$fun_menu_count][0] = "Search Jobs";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/search_jv.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."search.png";  

$param_fun_menu[$fun_menu_count][0] = "View Job Vacancy";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/view_jv.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_jv.png";

$param_fun_menu[$fun_menu_count][0] = "Job Posts";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/jobmatch/js/web/list_jvs.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_jv.png";

?>
