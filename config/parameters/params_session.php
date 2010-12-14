<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains session paramerters and variables
 */

 /*
  * System Session
  * tbl_sys
  */

//Provider
$param_session_provider = $_SESSION['param_session_provider'];

//Curl
$param_session_url = $_SESSION['param_session_url'];

//System Database Id
$param_session_sys_id = $_SESSION['param_session_sys_id'];

//System Prefix
$param_session_sys_prefix = $_SESSION['param_session_sys_prefix'];

//System Reference Code
$param_session_sys_reference_code = $_SESSION['param_session_sys_reference_code'];

//System Name
$param_session_sys_name = $_SESSION['param_session_sys_name'];

//Default Language
$param_session_sys_language = $_SESSION['param_session_sys_language'];

//System Country
$param_session_sys_country = $_SESSION['param_session_sys_country'];

//Info Label for ADD  MEMBER INTO A GROUP
$param_session_sys_other_info1 = $_SESSION['param_session_sys_other_info1'];
$param_session_sys_other_info2 = $_SESSION['param_session_sys_other_info2'];
$param_session_sys_api_id = $_SESSION['param_session_sys_api_id'];
$param_session_sys_api_key = $_SESSION['param_session_sys_api_key'];
$param_session_sys_public = $_SESSION['param_session_sys_public'];
  /*
   * System User Session
   * tbl_sys_user
   * tbl_sys_user_lastlogin
   */

//User Database Id
$param_session_user_user_id = $_SESSION['param_session_user_user_id'];

//User Mobile
$param_session_user_mobile = $_SESSION['param_session_user_mobile'];

//User Username
$param_session_user_user_name = $_SESSION['param_session_user_user_name'];

//User Type (Individual, Non Individual)
$param_session_user_user_type = $_SESSION['param_session_user_user_type'];

//User Admin Level
$param_session_user_admin_level = $_SESSION['param_session_user_admin_level'];

//User Name
$param_session_user_name = $_SESSION['param_session_user_name'];

//User Country
$param_session_user_country = $_SESSION['param_session_user_country'];

//User City
$param_session_user_city = $_SESSION['param_session_user_city'];

//User Email
$param_session_user_email = $_SESSION['param_session_user_email'];

/*
 * Session Modules
 */
$param_session_user_modules = $_SESSION['param_session_user_modules']; //seperated by :

/*
* Session Additional Parametars
*/

//Current Login TimeStamp
$param_session_current_login = $_SESSION['param_session_current_login'];

//Extended Design or NOT
$param_session_extended = $_SESSION['param_session_extended']; //"ED455Xx";

//Deny requests directly to the internal files
$param_session_check = "zZZz4332W";

?>
