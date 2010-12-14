<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$mobile_no = $_SESSION['param_session_user_user_name'];

$_SESSION['param_session_login-true'] = "";

$_SESSION['param_session_sys_id'] = "";
$_SESSION['param_session_sys_prefix'] = "";
$_SESSION['param_session_sys_reference_code'] = "";
$_SESSION['param_session_sys_name'] = "";
$_SESSION['param_session_sys_language'] = "";
$_SESSION['param_session_sys_country'] = "";
$_SESSION['param_session_user_user_id'] = "";
$_SESSION['param_session_user_mobile'] = "";
$_SESSION['param_session_user_user_name'] = "";
$_SESSION['param_session_user_user_type'] = "";
$_SESSION['param_session_user_admin_level'] = "";
$_SESSION['param_session_user_name'] = "";
$_SESSION['param_session_user_country'] = "";
$_SESSION['param_session_user_city'] = "";
$_SESSION['param_session_user_email'] = "";
$_SESSION['param_session_user_modules'] = "";
$_SESSION['param_session_current_login'] = "";
$_SESSION['param_session_extended'] = "";
$_SESSION['param_session_sys_host'] = "";
$_SESSION['param_session_provider'] = "";
$_SESSION['param_session_url'] = "";

$retutn_home = strtolower($_SESSION['param_session_return_home']);

session_destroy();

if($retutn_home=="jm-new-en")
    header("Location: jm.php?mobile=".urlencode($mobile_no));
else if($retutn_home=="jm-new-ar")
    header("Location: jm_1.php?mobile=".urlencode($mobile_no));
else
    header("Location: index.php?mobile=".urlencode($mobile_no));
?>
