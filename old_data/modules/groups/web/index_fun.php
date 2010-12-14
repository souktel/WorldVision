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
$param_fun_menu[$fun_menu_count][0] = "Create New Group";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/create_group.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_group.png";

$param_fun_menu[$fun_menu_count][0] = "All Groups";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_groups.png";

$param_fun_menu[$fun_menu_count][0] = "Group Summary";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/view_group.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_group.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Group Information";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/edit_group.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_group.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Group";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/delete_group.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_group.png";  

$param_fun_menu[$fun_menu_count][0] = "Group Members";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/editm_group.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."members.png"; 

$param_fun_menu[$fun_menu_count][0] = "Import/Export";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/export.php";
$param_fun_menu[$fun_menu_count][3] = "0";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."excell.png";

$param_fun_menu[$fun_menu_count][0] = "View Group Member";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/view_member.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_member.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Group Member";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/edit_member.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_member.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Group Member";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/delete_member.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_member.png";

$param_fun_menu[$fun_menu_count][0] = "Add Member";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/groups/web/add_member.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."add_member.png";
?>
