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
$param_fun_menu[$fun_menu_count][0] = "Create User";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/create_user.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_user.png";

$param_fun_menu[$fun_menu_count][0] = "List Users";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_users.png";

$param_fun_menu[$fun_menu_count][0] = "View User";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/view_user.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_user.png";

$param_fun_menu[$fun_menu_count][0] = "Edit User";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/edit_user.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_user.png";

$param_fun_menu[$fun_menu_count][0] = "Delete User";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/delete_user.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_user.png";   

$param_fun_menu[$fun_menu_count][0] = "Default Modules";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/system/def_modules.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."def_module.gif";  

?>
