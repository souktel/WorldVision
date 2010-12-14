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
$param_fun_menu[$fun_menu_count][0] = "Create Group";
$param_fun_menu[$fun_menu_count][1] = $param_server."/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create.gif";

$param_fun_menu[$fun_menu_count][0] = "List Groups";
$param_fun_menu[$fun_menu_count][1] = $param_server."/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list.gif";

$param_fun_menu[$fun_menu_count][0] = "Create Group Ref";
$param_fun_menu[$fun_menu_count][1] = $param_server."/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create.gif";

$param_fun_menu[$fun_menu_count][0] = "List Group Refs";
$param_fun_menu[$fun_menu_count][1] = $param_server."/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list.gif";    
?>
