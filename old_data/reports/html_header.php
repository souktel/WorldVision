<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(!($_SESSION['skrepo-login-true'] == "skrepo-true")) {
    header("location: index.php");
    exit;
}

require_once("../config/parameters/params_db.php");
require_once("../config/database/db_mysql.php");
require_once("../config/parameters/params_main.php");
require_once("../config/functions/send_func.php");

$title = '';

if($_GET['title']=="1") $title = 'Message Report';
else if($_GET['title']=="2") $title = 'Message Status';

$dbid = db_connect();
?>
<html dir="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel Reports</title>

        <style type="text/css">
            a {
		color: #000000;
            }

            a:link {
		text-decoration: none;
            }
            a:visited {
		text-decoration: none;
            }
            a:hover {
		text-decoration: underline;
            }
            a:active {
		text-decoration: none;
            }
        </style>

    </head>
    <body>
	<table border="0" width="100%" cellpadding="6" cellspacing="6" style="border-collapse: collapse">
            <tr>
                <td align="right">
		    <font size="2">
			<a href="message_report.php?title=1">Message Report</a>&nbsp;|&nbsp;
			<a href="message_status.php?title=2">Message Status</a>&nbsp;|&nbsp;
			<a href="logoff.php">Logoff</a>
		    </font>
		</td>
            </tr>
	</table>
        <table border="0" width="100%" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background_w.gif">
            <tr>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left_w.gif">&nbsp;</td>
                <td height="20" background="<?php echo $param_abs_path_si;?>body-upper_w.gif">&nbsp;</td>
                <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td><font size="4"><b><?php echo $title;?></b></font></td>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td><hr size="0" noshade></td>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                <td>