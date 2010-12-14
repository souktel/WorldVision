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
$param_fun_menu[$fun_menu_count][0] = "Create System";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/admin/create_system.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_system.png";

$param_fun_menu[$fun_menu_count][0] = "List Systems";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/admin/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_systems.png";

$param_fun_menu[$fun_menu_count][0] = "Edit System";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/edit_system.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_system.png";

$param_fun_menu[$fun_menu_count][0] = "Delete System";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/delete_system.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_system.png";

?>
