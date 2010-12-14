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
//$param_fun_menu[$fun_menu_count][0] = "View Profile";
//$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/profile/index.php";
//$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."profile.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Profile";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/profile/edit.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_user.png";

$param_fun_menu[$fun_menu_count][0] = "Change Password";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/profile/chpwd.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."chpwd.gif";   

$param_fun_menu[$fun_menu_count][0] = "Change PIN Code";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/profile/chpin.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."chpin.gif";  
?>
