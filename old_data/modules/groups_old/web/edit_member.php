<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Modify these variables
 * $apath, $required_login, $module_prefix
 * $design_page, $submit_page, $functions_list_path, $function_list_title, $function_cur_index
 */

//Path
$apath = "../../../"; //e.g. "", "../", "../../"

//File Name
$file_name = $apath."modules/groups/web/edit_member.php";

$file_path = $apath."modules/groups/web/";

//Authentication
$required_login = true; //e.g. true, false

//Module Prefix
//Must equal to module prefix in database, and module prefix in paramerters/params_header_menu.php
$module_prefix = "Groups"; //Module Prefix

//Design Page
$design_page = "modules/groups/web/edit_member_des.php";

//Submit Page
$submit_page = "modules/groups/web/edit_member_sub.php";

//Functions List
$function_list_path = "modules/groups/web/index_fun.php"; //Path of file which contains the function list ["" if no list]
$function_list_title = "Utilities"; //Title of the function box [e.g. "Functions"]
$function_cur_index = 8; //The index of the function we are in [-1 if no function]

//Include the Template Page
require_once($apath."templates/html/template.php");

?>

