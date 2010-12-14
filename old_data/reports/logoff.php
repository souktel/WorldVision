<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$_SESSION['skrepo-login-true'] = "skrepo-false";

session_destroy();

header("Location: index.php");

?>
