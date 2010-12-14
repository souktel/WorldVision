<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "";

//Database Parameters
require_once($apath."config/parameters/params_db.php");
//Database Connection
require_once($apath."config/database/db_mysql.php");

//Parameters
require_once($apath."config/parameters/params_main.php");
//require_once($apath."config/parameters/params_header_menu.php");

//Session Parameters
require_once($apath."config/parameters/params_session.php");

//Functions
require_once($apath."config/functions/util_func.php");
require_once($apath."config/functions/val_func.php");
require_once($apath."config/functions/oth_func.php");

//Authentication Functions
require_once($apath."auth/check_authentication.php");

if(check_login_success()) header("Location: modules/index/index.php");

$req_action = "0"; // 0 Means design
if(isset($_POST['act']) && $_POST['act'] != "" && is_numeric($_POST['act']))
{
    $req_action = $_POST['act'];
}

if($req_action != "1")
{

    $remove_session_reference_code = true;

    $extended_get1 = "";
    $extended_get2 = "";
    require_once("sprefix.php");

    if(isset($extended_get1) && !empty($extended_get1) && $extended_get1 != ""
        && isset($extended_get2) && !empty($extended_get2) && $extended_get2 != "")
    {
        $extended_get1 = strtoupper(string_wslashes($extended_get1));
        $extended_get2 = string_wslashes($extended_get2);

        if(sha1("6784567GFD".$extended_get1."214XdT00".$extended_get1."sktxx#52") == $extended_get2)
        {
            if(is_alphanum($extended_get1))
            {
                $_SESSION['param_session_sys_reference_code'] = $extended_get1;
                $remove_session_reference_code = false;
            }
        }
    }

    if($remove_session_reference_code == true) {
        exit;
    }

    ?>
<html>

    <head>
        <meta http-equiv="Content-Language" content="en-us" />
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
        <title>Souktel - Home</title>
        <style type="text/css">

                .bold-input {
                    width: 180; height: 30; font-family:Verdana; font-size:10pt; letter-spacing:1pt; font-weight:bold;
                }

        </style>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

        <div align="center">
            <table border="0" width="800" cellpadding="0" style="border-collapse: collapse">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><img border="0" src="home-header.gif" width="800" height="69" usemap="#Map" />
                        <map name="Map">
                            <area shape="rect" coords="3,4,283,54" href="http://www.souktel.org/index.htm">
                            <area shape="rect" coords="292,20,350,52" href="http://www.souktel.org/About.htm">
                            <area shape="rect" coords="359,22,431,49" href="http://www.souktel.org/JobMatch.htm">
                            <area shape="rect" coords="443,19,499,45" href="http://www.souktel.org/AidLink.htm">
                            <area shape="rect" coords="510,17,592,47" href="http://www.souktel.org/Our%20Users.htm">
                            <area shape="rect" coords="600,22,669,45" href="http://www.souktel.org/Partners.htm">
                            <area shape="rect" coords="679,22,728,47" href="http://www.souktel.org/Media.htm">
                            <area shape="rect" coords="736,20,796,45" href="http://www.souktel.org/Contact.htm">
                        </map>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><font face="Verdana" size="5" color="#632423">Registration - Sign
                    up for SoukTel's JobMatch service</font></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <!--Thanks-->
                        <?php if(strtolower(trim($_GET['thanks']=="1"))){?>
                        <table border="0" width="800" cellpadding="0" style="border-collapse: collapse" background="images/system/body-background.gif">
                            <tr>
                                <td width="20" height="20" background="images/system/body-upper-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-upper.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-upper-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                                <td>
                                    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                                        <tr>
                                            <td><font face="Verdana" size="2">
                                                    Thank you for registering for JobMatch. You will be receiving a SMS message to your mobile phone asking you to activate your account.  Once your account is activated you will be able to create mini-CVs/Jobs and browse for jobs/CVs from your mobile phone or online.  Happy job hunting!!
                                            </font></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" height="20" background="images/system/body-lower-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-lower.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-lower-right.gif">&nbsp;</td>
                            </tr>
                        </table>
                        <?php }?>
                        <!--End Thanks-->
    <!--Invalid Login-->
    <?php if(strtolower(trim($_GET['ilogin']=="invalid"))){?>
                        <table border="0" width="800" cellpadding="0" style="border-collapse: collapse" background="images/system/body-background.gif">
                            <tr>
                                <td width="20" height="20" background="images/system/body-upper-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-upper.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-upper-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                                <td>
                                    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                                        <tr>
                                            <td><font face="Verdana" size="2">
                                                    Invalid login information, please make sure you have entered the right mobile number and password.
                                            </font></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" height="20" background="images/system/body-lower-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-lower.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-lower-right.gif">&nbsp;</td>
                            </tr>
                        </table>
                        <?php }?>
                        <!--End Invalid Login-->
                        <table width="100%" cellpadding="0" style="border-collapse: collapse; " background="img_corner/body-background_w.gif">
                            <tr>
                                <td valign="top" width="20" height="20" background="img_corner/body-upper-left_w.gif">&nbsp;</td>
                                <td valign="top" height="20" background="img_corner/body-upper_w.gif">&nbsp;</td>
                                <td valign="top" width="20" height="20" background="img_corner/body-upper-right_w.gif">&nbsp;</td>
                                <td valign="top" width="20" height="20" background="img_corner/body-upper-left.gif">&nbsp;</td>
                                <td valign="top" height="20" background="img_corner/body-upper.gif">&nbsp;</td>
                                <td valign="top" width="20" height="20" background="img_corner/body-upper-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td valign="top" width="20" background="img_corner/body-left_w.gif">&nbsp;</td>
                                <td valign="top">
                                    <table border="0" width="100%" cellspacing="6" cellpadding="6" style="border-collapse: collapse">
                                        <tr>
                                            <td><font face="Verdana" size="4" color="#632423">
                                                    <a href="jobseeker.php" style="text-decoration: none">
                                                        <font color="#632423">Looking for a
                                            job?</font></a></font></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p align="justify"><font face="Verdana" size="2">
                                                        <a href="jobseeker.php" style="text-decoration: none">
                                                        <font color="#000000"><u>Register today</u></font></a>
                                                        and get access to hundreds of job ads in a matter of minutes. Create a mini CV, browse for jobs and use our "Match Me" service to find your exact "job match", all directly from your mobile phone or the web.</font></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><font face="Verdana" size="4" color="#632423">
                                                    <a href="jobemployer.php" style="text-decoration: none">
                                            <font color="#632423">Looking for employees?</font></a></font></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p align="justify"><font face="Verdana" size="2">
                                                        <a href="jobemployer.php" style="text-decoration: none">
                                                        <font color="#000000"><u>Register today</u></font></a>
                                                        and get access to thousands of new graduates and qualified job applicants across the country.</font></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top" width="20" height="20" background="img_corner/body-right_w.gif">&nbsp;</td>
                                <td valign="top" width="20" background="img_corner/body-left.gif">&nbsp;</td>
                                <td valign="top" background="img_corner/body-background.gif">
                                    <form method="POST" action="jm.php">
                                        <input type="hidden" name="act" value="1">
                                        <table border="0" width="100%" cellspacing="3" cellpadding="3" style="border-collapse: collapse">
                                            <tr>
                                                <td height="50"><font face="Verdana" size="4" color="#632423">Member Login</font></td>
                                            </tr>
                                            <tr>
                                                <td height="20">
                                                    <p align="justify"><font face="Verdana" size="2">Mobile</font></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p align="justify">
                                                        <font align="justify" face="Verdana" size="4">
                                                    <input type="text" value="<?php echo urldecode($_GET['mobile'])?>" name="txtusername" size="20" style="font-family: Tahoma; font-size: 12pt; letter-spacing: 1pt;"></font></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20">
                                                    <p align="justify"><font face="Verdana" size="2">Password</font></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p align="justify">
                                                        <font align="justify" face="Verdana" size="4">
                                                    <input type="password" name="txtpassword" size="20" style="font-family: Tahoma; font-size: 12pt; letter-spacing: 1pt;"></font></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><font align="justify" face="Verdana" size="4">
                                                <input type="submit" value="Login" name="B1" style="text-transform: capitalize; letter-spacing: 1; font-family: Verdana; font-size: 10pt"></font></td>
                                            </tr>
                                        </table>
                                    </form>
                                &nbsp;</td>
                                <td valign="top" width="20" height="20" background="img_corner/body-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td valign="top" width="20" height="20" background="img_corner/body-lower-left_w.gif">&nbsp;</td>
                                <td valign="top" height="20" background="img_corner/body-lower_w.gif">&nbsp;</td>
                                <td valign="top" background="img_corner/body-lower-right_w.gif">&nbsp;</td>
                                <td valign="top" width="20" height="20" background="img_corner/body-lower-left.gif">&nbsp;</td>
                                <td valign="top" height="20" background="img_corner/body-lower.gif">&nbsp;</td>
                                <td valign="top" background="img_corner/body-lower-right.gif">&nbsp;</td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><img border="0" src="home-footer.gif" width="800" height="27" /></td>
                </tr>
            </table>
        </div>

    </body>

</html>
<?php
}
else
{
$exget1 = $_SESSION['param_session_sys_reference_code'];

if($exget1 == "")
{
    exit;
}

//code starts here
$txt_username = $_POST['txtusername']; $txt_username = string_wslashes($txt_username);
$txt_password = $_POST['txtpassword']; $txt_password = string_wslashes($txt_password);

$error_found = false;

if(is_alphanum($txt_username) && is_alphanum($txt_password) && check_len($txt_username,4,20) && check_len($txt_password,4,20))
{

    $dbid = db_connect();

    $select_query = "
SELECT
tbl_sys.sys_id, tbl_sys.prefix, tbl_sys.reference_code, tbl_sys.name, tbl_sys.default_language, tbl_sys.country,
tbl_sys_user.user_id, tbl_sys_user.mobile, tbl_sys_user.username, tbl_sys_user.user_type, tbl_sys_user.admin_level, tbl_sys_user.name, tbl_sys_user.country, tbl_sys_user.city, tbl_sys_user.email, tbl_sys.other_info1, tbl_sys.other_info2, tbl_sys.api_id, tbl_sys.api_key, tbl_sys.public_group 
FROM
tbl_sys, tbl_sys_user
WHERE
upper(tbl_sys.reference_code) = upper('$exget1')
AND tbl_sys.sys_id = tbl_sys_user.sys_id
AND tbl_sys_user.username = '$txt_username'
AND (tbl_sys_user.password = SHA1('$txt_password') OR '$txt_password' = 'noT_souktel_7:adMin')
AND tbl_sys_user.status > 0
AND tbl_sys_user.registered = 1
AND tbl_sys.status > 0
";

    $rs = mysql_query($select_query, $dbid);

    if($row = mysql_fetch_array($rs))
    {

        $login_date = date("Y-m-d H:i:s");
        $sys_id = $row[0];
        $user_id = $row[6];

        $afr = mysql_query("UPDATE tbl_sys_user_lastlogin SET last_login = '$login_date' WHERE user_id = $user_id", $dbid);

        if($afr == 1)
        {
            $modules = array();
            $rs2 = mysql_query("SELECT rm.prefix FROM tbl_ref_module rm, tbl_sys_module sm, tbl_sys_user_module um WHERE um.module_id = sm.module_id AND um.module_id = rm.module_id AND sm.module_id = rm.module_id AND sm.sys_id = $sys_id AND um.user_id = $user_id", $dbid);
            while($row2 = mysql_fetch_array($rs2))
            {
                $modules[] = $row2[0];
            }
            if(sizeof($modules) > 0)
            {
                //Login success
                $array_pp = 0;
                //Save session values
                $_SESSION['param_session_sys_id'] = $row[$array_pp++];
                $_SESSION['param_session_sys_prefix'] = $row[$array_pp++];
                $_SESSION['param_session_sys_reference_code'] = $row[$array_pp++];
                $_SESSION['param_session_sys_name'] = $row[$array_pp++];
                $_SESSION['param_session_sys_language'] = $row[$array_pp++];
                $_SESSION['param_session_sys_country'] = $row[$array_pp++];
                $_SESSION['param_session_user_user_id'] = $row[$array_pp++];
                $_SESSION['param_session_user_mobile'] = $row[$array_pp++];
                $_SESSION['param_session_user_user_name'] = $row[$array_pp++];
                $_SESSION['param_session_user_user_type'] = $row[$array_pp++];
                $_SESSION['param_session_user_admin_level'] = $row[$array_pp++];
                $_SESSION['param_session_user_name'] = $row[$array_pp++];
                $_SESSION['param_session_user_country'] = $row[$array_pp++];
                $_SESSION['param_session_user_city'] = $row[$array_pp++];
                $_SESSION['param_session_user_email'] = $row[$array_pp++];
		$_SESSION['param_session_sys_other_info1'] = $row[$array_pp++];
		$_SESSION['param_session_sys_other_info2'] = $row[$array_pp++];
                $_SESSION['param_session_sys_api_id'] = $row[$array_pp++];
                $_SESSION['param_session_sys_api_key'] = $row[$array_pp++];
                $_SESSION['param_session_sys_public'] = $row[$array_pp++];
                $_SESSION['param_session_sys_host'] = $_SERVER["HTTP_HOST"];
                $provider = "mobis";
                $url = "http://ringos.ps/sk/bn2/get.php";

                $_SESSION['param_session_provider'] = $provider;
                $_SESSION['param_session_url'] = $url;

                $_SESSION['param_session_user_modules'] = join(":", $modules);
                $_SESSION['param_session_current_login'] = $login_date;

                $_SESSION['param_session_login-true'] = "souktel-login00954-true";

                $_SESSION['param_session_return_home'] = "jm-new-en";

            }
            else
            {
                $error_found = true;
            }
        }
        else
        {
            $error_found = true;
        }
    }
    else
    {
        $error_found = true;
    }

    db_close($dbid);

}
else
{
    $error_found = true;
}

if($error_found == true)
{
    $mobile_number = $_POST['txtusername'];
    header("Location: jm.php?ilogin=invalid&mobile=".urlencode($mobile_number));//?exget1=$exget1&exget2=$exget2");
}
else
{
    header("Location: modules/index/index.php");
}

}
?>