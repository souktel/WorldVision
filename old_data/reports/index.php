<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($_POST['act']=="1" || $_POST['act'] == 1)
{
    if($_POST['txtusername'] == "reports" && $_POST['txtpassword'] == "repo_@1")
    {
      $_SESSION['skrepo-login-true'] = "skrepo-true";
      header("location: message_report.php?title=1");
      exit;
    }
    else
    {
      $_SESSION['skrepo-login-true'] = "skrepo-false";
      $_GET['ilogin'] = "invalid";
    }
}
else
{
    $_SESSION['skrepo-login-true'] = "skrepo-false";
}

$apath = "../";

//Parameters
require_once($apath."config/parameters/params_main.php");

?>
<html dir="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel Reports - Login</title>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

        <div align="center"><br><br><br><br><br><br><br><br><br><br><br><br>
            <img src="../images/system/header.gif">
            <hr size="0" noshade width="950">
            <table border="0" width="340" cellpadding="0" style="border-collapse: collapse" background="../images/system/body-background.gif">
                <tr>
                    <td width="20" height="20" background="../images/system/body-upper-left.gif">&nbsp;</td>
                    <td height="20" background="../images/system/body-upper.gif">&nbsp;</td>
                    <td width="20" height="20" background="../images/system/body-upper-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="../images/system/body-left.gif">&nbsp;</td>
                    <td><span lang="en-us"><font face="Trebuchet MS" size="4">Login</font></span></td>
                    <td width="20" background="../images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="../images/system/body-left.gif">&nbsp;</td>
                    <td><hr size="0" noshade></td>
                    <td width="20" background="../images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="../images/system/body-left.gif">&nbsp;</td>
                    <td>
                        <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                            <tr>

                                <td><font face="Trebuchet MS" size="2"><span lang="en-us">Please
                                provide your login information</span></font></td>
                            </tr>
                        </table>
                    </td>
                    <td width="20" background="../images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="../images/system/body-left.gif">&nbsp;</td>
                    <td>
                        <form method="POST" action="index.php">
                            <input type="hidden" name="act" value="1">
                            <div align="left">
                                <table border="0" width="300" cellpadding="0" style="border-collapse: collapse">
                                    <tr>
                                        <td>
                                            <div align="left">
                                                <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                                                    <tr>
                                                        <td width="70" align="left">
                                                            <font face="Trebuchet MS" size="2">
                                                        <span lang="en-us">Username:</span></font></td>
                                                        <td><font face="Trebuchet MS">
                                                        <input type="text" name="txtusername" size="30" value="<?php echo urldecode($_GET['mobile'])?>"></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="70" align="left">
                                                            <font face="Trebuchet MS" size="2">
                                                        <span lang="en-us">Password:</span></font></td>
                                                        <td><font face="Trebuchet MS">
                                                        <input type="password" name="txtpassword" size="30"></font></td>
                                                    </tr>
                                                    <?php if($_GET['ilogin']=="invalid"){?>
                                                    <tr><td colspan="2"><font face="Trebuchet MS" style="font-size: 9pt;" color="RED">
                                                    Invalid login information, please make sure you have entered the right mobile number and password.</font></td></tr>
                                                    <?php }?>
                                                    <tr>
                                                        <td width="90" align="right">&nbsp;</td>
                                                        <td><font face="Trebuchet MS">
                                                        <input type="submit" value="Sign In" name="B1" style="font-family: Trebuchet MS; font-weight: bold"></font></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </td>
                    <td width="20" background="../images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" height="20" background="../images/system/body-lower-left.gif">&nbsp;</td>
                    <td height="20" background="../images/system/body-lower.gif">&nbsp;</td>
                    <td width="20" height="20" background="../images/system/body-lower-right.gif">&nbsp;</td>
                </tr>
            </table>
            <hr size="0" noshade width="950">
            <p align="center"><font face="Tahoma" size="2">Copyright 2009 © Souktel. All
            Rights Reserved</font></p>
        </div>

    </body>

</html>

<?php

?>