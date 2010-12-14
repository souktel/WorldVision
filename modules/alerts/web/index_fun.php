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
$param_fun_menu[$fun_menu_count][0] = "Create Alert";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/create_alert.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."create_alert.png";

$param_fun_menu[$fun_menu_count][0] = "Saved Alerts";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/index.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."list_alerts.png";

$param_fun_menu[$fun_menu_count][0] = "Alert Summary";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/view_alert.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."view_alert.png";

$param_fun_menu[$fun_menu_count][0] = "Edit Alert";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/edit_alert.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."edit_alert.png";

$param_fun_menu[$fun_menu_count][0] = "Delete Alert";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/delete_alert.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."delete_alert.png";

$param_fun_menu[$fun_menu_count][0] = "Scheduled Alerts";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/scheduled.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."scheduled.png";

$param_fun_menu[$fun_menu_count][0] = "Sent Alerts";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/sent.php";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."sent.png";

$param_fun_menu[$fun_menu_count][0] = "Send Alert";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/snd_alert.php";
$param_fun_menu[$fun_menu_count][3] = "1";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."send_alert.png";

$param_fun_menu[$fun_menu_count][0] = "Detailed SMS Log";
$param_fun_menu[$fun_menu_count][1] = $param_server."/modules/alerts/web/detailed_log.php?act=1";
$param_fun_menu[$fun_menu_count][3] = "5";
$param_fun_menu[$fun_menu_count++][2] = $param_abs_path_sib."sms_list.png";
?>
