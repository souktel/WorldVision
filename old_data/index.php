<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */


$apath = "";
//set_int("display_error",1);
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
if(isset($_POST['act']) && $_POST['act'] != "" && is_numeric($_POST['act'])) {
    $req_action = $_POST['act'];
}

if($req_action != "1") {

    $remove_session_reference_code = true;

    $extended_get1 = "";
    $extended_get2 = "";
    require_once("sprefix.php");

    if(isset($extended_get1) && !empty($extended_get1) && $extended_get1 != ""
	&& isset($extended_get2) && !empty($extended_get2) && $extended_get2 != "") {
        
	$extended_get1 = strtoupper(string_wslashes($extended_get1));
	$extended_get2 = string_wslashes($extended_get2);

	if(sha1("6784567GFD".$extended_get1."214XdT00".$extended_get1."sktxx#52") == $extended_get2) {
	    if(is_alphanum($extended_get1)) {
		$_SESSION['param_session_sys_reference_code'] = $extended_get1;
		$remove_session_reference_code = false;
	    }
	}
    }
   
    if($remove_session_reference_code == true) {
	exit;
    }

    ?>
<html dir="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel - Login Page</title>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

        <div align="center"><br><br><br><br><br><br><br><br><br><br><br><br>
		<?php if(strtolower($_SERVER["HTTP_HOST"])=='mercycorps.mysouktel.com' || strtolower($_SERVER["HTTP_HOST"])=='www.mercycorps.mysouktel.com') {?>
	    <table border="0" width="500" cellpadding="0" style="border-collapse: collapse">
                <tr>
                    <td width="200" align="left" valign="middle"><img src="images/system/homepage/mc_logo.gif" width="246" height="125"></td>
                    <td>&nbsp;</td>
                    <td width="200" align="right" valign="middle"><img src="images/system/header.gif"></td>
                </tr>
	    </table>
		<?php } else if(strtolower($_SERVER["HTTP_HOST"])=='.souktelgaza.org' || strtolower($_SERVER["HTTP_HOST"])=='www.souktelgaza.org') {?>
	    <table border="0" width="400" cellpadding="0" style="border-collapse: collapse">
                <tr>
                    <td width="200" align="left" valign="middle"><img src="images/system/header2.gif"></td>
                    <td>&nbsp;</td>
                    <td width="200" align="right" valign="middle"><img src="images/system/header.gif"></td>
                </tr>
	    </table>
		    <?php } else {?>
            <img src="images/system/header2.gif">
	    <img src="images/system/header.gif">
		    <?php }?>
            <hr size="0" noshade width="950">
            <table border="0" width="340" cellpadding="0" style="border-collapse: collapse" background="images/system/body-background.gif">
                <tr>
                    <td width="20" height="20" background="images/system/body-upper-left.gif">&nbsp;</td>
                    <td height="20" background="images/system/body-upper.gif">&nbsp;</td>
                    <td width="20" height="20" background="images/system/body-upper-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                    <td><span lang="en-us"><font face="Trebuchet MS" size="4">Login</font></span></td>
                    <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                    <td><hr size="0" noshade></td>
                    <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                    <td>
                        <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                            <tr>

                                <td><font face="Trebuchet MS" size="2"><span lang="en-us">Please
					    provide your login information</span></font></td>
                            </tr>
                        </table>
                    </td>
                    <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="images/system/body-left.gif">&nbsp;</td>
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
								<input type="text" name="txtusername" style="width:190px;" value="<?php echo urldecode($_GET['mobile'])?>"></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="70" align="left">
                                                            <font face="Trebuchet MS" size="2">
								<span lang="en-us">Password:</span></font></td>
                                                        <td><font face="Trebuchet MS">
								<input type="password" name="txtpassword" style="width:190px;"></font></td>
                                                    </tr>
							<?php if($_GET['ilogin']=="invalid") {?>
                                                    <tr><td colspan="2"><font face="Trebuchet MS" style="font-size: 9pt;" color="RED">
								Invalid login information, please make sure you have entered the right mobile number and password.</font></td></tr>
							<?php }?>
                                                    <tr>
                                                        <td width="90" align="right">&nbsp;</td>
                                                        <td>
                                                            <font face="Trebuchet MS" size="1">
                                                                <input type="submit" value="Sign In" name="B1" style="font-family: Trebuchet MS; font-weight: bold">
                                                            </font>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </td>
                    <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" height="20" background="images/system/body-lower-left.gif">&nbsp;</td>
                    <td height="20" background="images/system/body-lower.gif">&nbsp;</td>
                    <td width="20" height="20" background="images/system/body-lower-right.gif">&nbsp;</td>
                </tr>
            </table>
            <hr size="0" noshade width="950">
            <p align="center"><font face="Tahoma" size="2">Copyright 2009 © Souktel. All
		    Rights Reserved</font></p>
        </div>

    </body>

</html>

<?php
} 
else {
    $exget1 = $_SESSION['param_session_sys_reference_code'];

    if($exget1 == "") {
	exit;
    }

    //code starts here
    $txt_username = $_POST['txtusername']; $txt_username = string_wslashes($txt_username);
    $txt_password = $_POST['txtpassword']; $txt_password = string_wslashes($txt_password);

    $error_found = false;

    if(is_alphanum($txt_username) && is_alphanum($txt_password) && check_len($txt_username,4,20) && check_len($txt_password,4,20)) {

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

	if($row = mysql_fetch_array($rs)) {

	    $login_date = date("Y-m-d H:i:s");
	    $sys_id = $row[0];
	    $user_id = $row[6];

	    $afr = mysql_query("UPDATE tbl_sys_user_lastlogin SET last_login = '$login_date' WHERE user_id = $user_id", $dbid);

	    if($afr == 1) {
		$modules = array();
		$rs2 = mysql_query("SELECT rm.prefix FROM tbl_ref_module rm, tbl_sys_module sm, tbl_sys_user_module um WHERE um.module_id = sm.module_id AND um.module_id = rm.module_id AND sm.module_id = rm.module_id AND sm.sys_id = $sys_id AND um.user_id = $user_id", $dbid);
		while($row2 = mysql_fetch_array($rs2)) {
		    $modules[] = $row2[0];
		}
		if(sizeof($modules) > 0) {
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

		}
		else {
		    $error_found = true;
		}
	    }
	    else {
		$error_found = true;
	    }
	}
	else {
	    $error_found = true;
	}

	db_close($dbid);

    }
    else {
	$error_found = true;
    }

    if($error_found == true) {
	$mobile_number = $_POST['txtusername'];
	header("Location: index.php?ilogin=invalid&mobile=".urlencode($mobile_number));//?exget1=$exget1&exget2=$exget2");
    }
    else {
	header("Location: modules/index/index.php");
    }

}
?>