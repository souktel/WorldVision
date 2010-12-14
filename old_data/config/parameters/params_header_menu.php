<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains the header menu buttons informaion
 */

$menu_count = 0;   

 /*
  * Menu Items
  * Index 0 = Button Title
  * Index 1 = Link
  */
$param_header_menu[$menu_count][0] = "Homepage"; //Title
$param_header_menu[$menu_count][2] = "Homepage"; //Prefix
$param_header_menu[$menu_count][3] = "1"; //Valid or Not
$param_header_menu[$menu_count++][1] = $param_server."/index.php";   

$param_header_menu[$menu_count][0] = "Admin";
$param_header_menu[$menu_count][2] = "Administration";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/admin/index.php";

$param_header_menu[$menu_count][0] = "Groups";
$param_header_menu[$menu_count][2] = "Groups";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/groups/web/index.php";

$param_header_menu[$menu_count][0] = "Alerts";
$param_header_menu[$menu_count][2] = "Alerts";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/alerts/web/index.php";

$param_header_menu[$menu_count][0] = "Surveys";
$param_header_menu[$menu_count][2] = "Surveys";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/surveys/web/index.php";

$param_header_menu[$menu_count][0] = "Job Match";
$param_header_menu[$menu_count][2] = "JobMatchEmployer";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/jobmatch/jo/web/index.php";

$param_header_menu[$menu_count][0] = "Job Match";
$param_header_menu[$menu_count][2] = "JobMatchSeeker";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/jobmatch/js/web/index.php";

$param_header_menu[$menu_count][0] = "System";
$param_header_menu[$menu_count][2] = "System";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/system/index.php";

$param_header_menu[$menu_count][0] = "Gaza";
$param_header_menu[$menu_count][2] = "MiniSurvey";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/ms/web/index.php";

$param_header_menu[$menu_count][0] = "Inbox";
$param_header_menu[$menu_count][2] = "Inbox";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/modules/inbox/web/index.php";

$param_header_menu[$menu_count][0] = "Profile"; //Title
$param_header_menu[$menu_count][2] = "Profile"; //Prefix
$param_header_menu[$menu_count][3] = "1"; //Valid or Not
$param_header_menu[$menu_count][4] = "1"; //Hidden from top menu or Not
$param_header_menu[$menu_count++][1] = $param_server."/modules/profile/index.php";

$param_header_menu[$menu_count][0] = "Help";
$param_header_menu[$menu_count][2] = "Help";
$param_header_menu[$menu_count][3] = "0";
$param_header_menu[$menu_count++][1] = $param_server."/help.php";

$available_modules = split(":",$param_session_user_modules);

for($kl = 0;$kl < sizeof($available_modules);$kl++)
{
    for($kli = 0;$kli < $menu_count;$kli++)
    {
        if(strtoupper($param_header_menu[$kli][2]) == strtoupper($available_modules[$kl]))
        {
            $param_header_menu[$kli][3] = "1";
        }
    }
}

?>
