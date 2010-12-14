<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

require_once("config/parameters/params_db.php");
require_once("config/database/db_mysql.php");
require_once("config/parameters/params_main.php");
require_once("config/functions/validation.php");

$dbid = db_connect();

if(string_wslashes($_POST['act']) == "1") {

    //Validation Data Fields
    $errors = array();
    $rules = array();

    //Error Flag
    $error_found = false; //No Errors at first
    $error_no = "";

    $name = trim(string_wslashes(trim($_POST['name'])));
    $mobile = trim(string_wslashes(trim($_POST['mobile'])));

    $password = string_wslashes($_POST['password']);
    $pin = string_wslashes($_POST['pin']);

    $country = 1;
    $city = string_wslashes($_POST['city']);

    $email = string_wslashes($_POST['email']);
    string_wslashes($_POST['year']);
    $year =
    $month = string_wslashes($_POST['month']);
    $day = string_wslashes($_POST['day']);
    $gender = string_wslashes($_POST['gender']);

    $sector = string_wslashes($_POST['sector']);

    //Name
    $rules[] = ("required,name,Required : Name.");
    $rules[] = ("length<=100,name,Name : < 100 chars please.");

    //Mobile
    $rules[] = ("digits_only,mobile,Mobile : Digits only please.");
    $rules[] = ("required,mobile,Required : Mobile.");
    $rules[] = ("length<=20,mobile,Mobile : < 20 digits please.");

    //PIN CODE
    $rules[] = ("digits_only,pin,PIN : Digits only please.");
    $rules[] = ("required,pin,Required : PIN.");
    $rules[] = ("length=4-4,pin,PIN : 4 Digits");

    //Confirm PIN
    $rules[] = ("same_as,confirmpin,pin,PIN not equal Conformation PIN");

    //Password
    $rules[] = ("is_alpha,password,Password : 0-9, a-Z only please.");
    $rules[] = ("required,password,Required : Password.");
    $rules[] = ("length=4-7,password,Password : 4 - 7 chars");

    //Confirm Password
    $rules[] = ("same_as,confirmpassword,password,Password not equal Conformation Password");

    //City
    $rules[] = ("digits_only,city,City : Digits only please.");
    $rules[] = ("required,city,Required : City.");

    //Gender
    $rules[] = ("digits_only,gender,Gender : Digits only please.");
    $rules[] = ("required,gender,Required : Gender.");

    //Email
    $rules[] = ("valid_email,email,Email : Not Valid Email");

    $errors = validateFields($_POST, $rules);

    $existed_member = false;
    $existed_mobile = "";
    $existed_status = "1";

    if (sizeof($errors)==0) {
        $sys_prefix = "SK";
        $sys_id = "";
        if($regc_rs = mysql_query("SELECT sys_id FROM tbl_sys WHERE lower(prefix) = lower('$sys_prefix')", $dbid)) {
            if($regc_row = mysql_fetch_array($regc_rs)) {
                $sys_id = $regc_row['sys_id'];
            }
        }

        $query = "INSERT INTO tbl_sys_user VALUES(user_id, $sys_id, '$mobile', '$pin', '$mobile', SHA1('$password'), 1 ,1 ,0, CURRENT_TIMESTAMP, '$name', $country, $city, '$email',8)";
        $query_unique_mobile = "SELECT user_id, mobile, registered FROM tbl_sys_user WHERE sys_id = $sys_id AND (mobile = '$mobile' OR username = '$mobile')";

        mysql_query("BEGIN");

        $rs = mysql_query($query_unique_mobile, $dbid);

        if($row = mysql_fetch_array($rs)) {
            $error_found = true;
            $error_no = "10101"; // Mobile number already exists
            $existed_member = true;
            $existed_mobile = $row[1];
            $existed_status = $row[2];
        }

        if($existed_member == false || $existed_status == 0 || $existed_status == "0") {
            mysql_query("DELETE FROM tbl_sys_user WHERE sys_id = $sys_id AND mobile = '$existed_mobile'", $dbid);
            mysql_query("DELETE FROM tbl_user_current_system WHERE sys_id = $sys_id AND mobile = '$existed_mobile'", $dbid);
            mysql_query("DELETE FROM tbl_process_user WHERE sys_id = $sys_id AND mobile = '$existed_mobile'", $dbid);

            if(mysql_query($query,$dbid)) {
                $current_id = mysql_insert_id($dbid);
                $query_insert = "INSERT INTO tbl_sys_user_ind VALUES($current_id, $year, $month, $day, $gender)";
                if(!mysql_query($query_insert,$dbid)) {
                    $error_found = true;
                    $error_no = "1602"; //Internal Error
                    mysql_query("ROLLBACK");
                }
                else {
                    if(!mysql_query("INSERT INTO tbl_sys_user_lastlogin VALUES($current_id, CURRENT_TIMESTAMP)",$dbid)) {
                        $error_found = true;
                        $error_no = "1702";
                        mysql_query("ROLLBACK");
                    }
                    else {
                        if(!mysql_query("INSERT INTO tbl_sys_user_module VALUES($current_id,6)",$dbid)) {
                            $error_found = true;
                            $error_no = "1802";
                            mysql_query("ROLLBACK");
                        }else {
                            $job_chk = trim(string_wslashes($_POST['jobcheck']))==1?1:0;
                            $vol_chk = trim(string_wslashes($_POST['volcheck']))==1?1:0;
                            if(!mysql_query("INSERT INTO tbl_sys_user_extra VALUES($current_id,$job_chk,$vol_chk,$sector)",$dbid)) {
                                $error_found = true;
                                $error_no = "1902";
                                mysql_query("ROLLBACK");
                            }
                        }
                    }
                }
            }
            else {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK");
            }
        }

        if(!$error_found) {
            require_once("config/functions/send_func.php");
            $req_ps = "37190";
            $msgId = generateMsgId();
            sendBulkSMS($msgId, $mobile, "Thank you for registering for JobMatch.  Please reply to this SMS by texting the word ACTIVATE to activate your account.", $dbid, "10001", "KJKJDF845D");

            if((int)$job_chk == 1 || (int)$vol_chk == 1) {
                $rs_select_city_major = mysql_query("SELECT c.name, m.name FROM tbl_ref_city_title c, tbl_ref_major_title m WHERE c.city_id = $city AND c.language_id = 1 AND m.major_id = $sector AND m.language_id = 1", $dbid);
                while($row_select_city_major = mysql_fetch_array($rs_select_city_major))
                {
                    $var_CITY = $row_select_city_major[0];
                    $var_MAJO = $row_select_city_major[1];
                    if((int)$job_chk == 1) mysql_query("INSERT INTO tbl_alerts_group_members VALUES(1045, '$mobile', '$name', '$var_CITY', '$var_MAJO', '')",$dbid);
                    if((int)$vol_chk == 1) mysql_query("INSERT INTO tbl_alerts_group_members VALUES(1046, '$mobile', '$name', '$var_CITY', '$var_MAJO', '')",$dbid);
                }
            }

            mysql_query("COMMIT");
            db_close($dbid);
            header("Location: complete.php");
            break;
        }

    }
    else {
        $error_found = true;
        $error_no = "1501";
    }

    if($error_found) {
        $err_msg = "";
        $err_status = "";
        if($existed_status == "1" || $existed_status == 1) $err_status = "registered";
        else if($existed_status == "8" || $existed_status == 8) $err_status = "registered but not activated";
        if($error_no == "10101") $err_msg = "Mobile number $existed_mobile is already ".$err_status.", please contact Support Team for more information.";
        else if($error_no == "1602") $err_msg = "Internal error during excution, please try again later.";
        else if($error_no == "1501") {
            $err_msg_errors = "";
            for($e=0; $e < sizeof($errors); $e++) $err_msg_errors .= "<br>-&nbsp;".$errors[$e];
            $err_msg = "Information provided is invalid, please make sure you provided valid information.".$err_msg_errors;
        }
    }

}
?>


<html dir="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel - Registration</title>
        <style type="text/css">

            .bold-input {
                width: 180; height: 30; font-family:Verdana; font-size:10pt; letter-spacing:1pt; font-weight:bold;
            }

        </style>
        <script language="JavaScript" src="templates/js/validation.js" type="text/javascript"></script>
        <script language="JavaScript">
            var rules = [];

            //Name
            rules.push("required,name,Required : Name.");
            rules.push("length<=100,name,Name : < 100 chars please.");

            //Mobile
            rules.push("digits_only,mobile,Mobile : Digits only please.");
            rules.push("required,mobile,Required : Mobile.");
            rules.push("length<=20,mobile,Mobile : < 20 digits please.");

            //PIN CODE
            rules.push("digits_only,pin,PIN : Digits only please.");
            rules.push("required,pin,Required : PIN.");
            rules.push("length=4-4,pin,PIN : 4 Digits");

            //Confirm PIN
            rules.push("same_as,confirmpin,pin,PIN not equal Confirmation PIN");

            //Password
            rules.push("is_alpha,password,Password : 0-9, a-Z only please.");
            rules.push("required,password,Required : Password.");
            rules.push("length=4-7,password,Password : 4 - 7 chars");

            //Confirm Password
            rules.push("same_as,confirmpassword,password,Password not equal Confirmation Password");

            //Email
            rules.push("valid_email,email,Email : Not Valid Email");

        </script>
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
                        <table border="0" width="800" cellpadding="0" style="border-collapse: collapse" background="images/system/body-background.gif">
                            <tr>
                                <td width="20" height="20" background="images/system/body-upper-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-upper.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-upper-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                                <td>
                                    <table border="0" width="650" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                                        <tr>

                                            <td><font face="Trebuchet MS" size="2"><span lang="en-us">Thank you for your interest in JobMatch.  Please fill in the following information to register for our service.</span></font></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" background="images/system/body-left.gif">&nbsp;</td>
                                <td>
                                <form name="skform" method="POST" action="jobseeker.php" onsubmit="return validateFields(this, rules)">
                                    <input type="hidden" name="act" value="1">
                                    <table border="0" width="600" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
                                        <?php if($err_msg != "") {?>
                                        <tr>
                                            <td width="96%" colspan="3">
                                                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000"><?php echo $err_msg;?></font>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td width="96%" colspan="3">
                                                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">*
                                            Required<span lang="en-us"> field.</span></font></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%"><font face="Trebuchet MS" size="2">Name<font color="#FF0000">
                                            *</font></font></td>
                                            <td width="49%">
                                                <input name="name" size="35" value="<?php echo $name;?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%" valign="top">
                                                <font face="Trebuchet MS" size="2">
                                                    Mobile<font color="#FF0000"> *</font>
                                                </font>
                                                <p align="justify" style="width: 245px">
                                                    <font face="Verdana" style="font-size: 7pt">
                                                        Enter mobile numbers with country code, area code and the number. Do not use spaces or symbols.
                                                    </font>
                                                </p>
                                            </td>
                                            <td width="49%" valign="top">
                                                <input name="mobile" size="35" value="<?php echo $mobile==""?"972":$mobile;?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%" valign="top">
                                                <font face="Trebuchet MS" size="2">
                                                    Pin Code<font color="#FF0000"> *</font>
                                                </font>
                                                <p align="justify" style="width: 245px"><font face="Verdana" style="font-size: 7pt">This is a 4 digit code that will allow you to access your account from your mobile phone.</font></p>
                                            </td>
                                            <td width="49%" valign="top">
                                                <input name="pin" size="35" type="password"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%" valign="top"><font face="Trebuchet MS" size="2">
                                                    Confirm Pin Code<font color="#FF0000"> *</font>
                                            </font></td>
                                            <td width="49%" valign="top"><font face="Trebuchet MS">
                                                    <span style="font-size: 11pt">
                                                        <font face="Verdana" style="font-size: 11pt">
                                            <input name="confirmpin" size="35" type="password"/></font></span></font></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%" valign="top">
                                                <font face="Trebuchet MS" size="2">
                                                    Password<font color="#FF0000"> *</font>
                                                    <p align="justify" style="width: 245px"><font face="Verdana" style="font-size: 7pt">This is a 4 - 7 alpha-numeric code that will allow you to access your account from the website.</font></p>
                                                </font>
                                            </td>
                                            <td width="49%" valign="top">
                                                <input type="password" name="password" size="35">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%" valign="top">
                                                <font face="Trebuchet MS" size="2">Confirm Password<font color="#FF0000">
                                                *</font></font>
                                            </td>
                                            <td width="49%"  valign="top">
                                            <input type="password" name="confirmpassword" size="35"></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%"><font face="Trebuchet MS" size="2">Email Address (optional)</font></td>
                                            <td width="49%">
                                                <input type="text" name="email" size="35" value="<?php echo $email;?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%">
                                                <font face="Trebuchet MS" size="2">City<font color="#FF0000">
                                                *</font></font>
                                            </td>
                                            <td width="49%"><select size="1" name="city" style="width:245px;">
                                                    <?php
                                                    $rs1 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = 1 AND c.country_id = 1", $dbid);
                                                    while($row1 = mysql_fetch_array($rs1)) {
                                                        $row_id = $row1[0];
                                                        $row_name = $row1[1];
                                                        echo "<option value=\"$row_id\"".($row_id==$city?" selected":"").">$row_name</option>";
                                                    }
                                                    ?>
                                            </select></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%"><font face="Trebuchet MS" size="2">Date Of Birth<font color="#FF0000">
                                            *</font></font></td>
                                            <td width="49%">
                                                <select size="1" name="year" onChange="populate(this.form,this.form.month.selectedIndex);">
                                                    <?php
                                                    for($years = Date("Y");$years >= 1910;$years--) {
                                                        echo "<option value=\"$years\"".($years==$year?" selected":"").">$years</option>";
                                                    }
                                                    ?>
                                                </select> <select size="1" name="month" onChange="populate(this.form,this.selectedIndex);">
                                                    <option value="01"<?php echo $month=="01"?" selected":"";?>>January</option>
                                                    <option value="02"<?php echo $month=="02"?" selected":"";?>>February</option>
                                                    <option value="03"<?php echo $month=="03"?" selected":"";?>>March</option>
                                                    <option value="04"<?php echo $month=="04"?" selected":"";?>>April</option>
                                                    <option value="05"<?php echo $month=="05"?" selected":"";?>>May</option>
                                                    <option value="06"<?php echo $month=="06"?" selected":"";?>>June</option>
                                                    <option value="07"<?php echo $month=="07"?" selected":"";?>>July</option>
                                                    <option value="08"<?php echo $month=="08"?" selected":"";?>>August</option>
                                                    <option value="09"<?php echo $month=="09"?" selected":"";?>>September</option>
                                                    <option value="10"<?php echo $month=="10"?" selected":"";?>>October</option>
                                                    <option value="11"<?php echo $month=="11"?" selected":"";?>>November</option>
                                                    <option value="12"<?php echo $month=="12"?" selected":"";?>>December</option>
                                                </select>
                                                <select size="1" name="day">
                                                    <?php
                                                    for($days = 1;$days <= 31;$days++) {
                                                        echo "<option value=\"$days\"".($days==$day?" selected":"").">$days</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%">
                                                <font face="Trebuchet MS" size="2">Gender<font color="#FF0000">
                                                *</font></font>
                                            </td>
                                            <td width="49%"><select size="1" name="gender" style="width:245px;">
                                                    <option value="0"<?php echo $gender == "0"?" selected":"";?>>Male</option>
                                                    <option value="1"<?php echo $gender == "1"?" selected":"";?>>Female</option>
                                            </select></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="48%">
                                                <font face="Trebuchet MS" size="2">
                                                    Sector<font color="#FF0000"> *</font>
                                                </font>
                                            </td>
                                            <td width="49%">
                                                <select size="1" name="sector" style="width:245px;">
                                                    <?php
                                                    $rs2 = mysql_query("SELECT c.major_id, ct.name FROM tbl_ref_major c, tbl_ref_major_title ct WHERE ct.major_id = c.major_id AND ct.language_id = 1", $dbid);
                                                    while($row2 = mysql_fetch_array($rs2)) {
                                                        $row_id = $row2[0];
                                                        $row_name = $row2[1];
                                                        echo "<option value=\"$row_id\"".($row_id==$sector?" selected":"").">$row_name</option>";
                                                    }
                                                    db_close($dbid);
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48%" colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="48%" colspan="3">
                                                <font face="Verdana" style="font-size: 8pt">
                                                    <input type="checkbox" name="jobcheck" value="1">&nbsp;Receive free SMS messages about jobs in your city/work sector.
                                                </font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48%" colspan="3">
                                                <font face="Verdana" style="font-size: 8pt">
                                                    <input type="checkbox" name="volcheck" value="1">&nbsp;Receive free SMS messages about volunteer opportunities in your area.
                                                </font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48%" colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="48%" colspan="3">
                                                <input type="submit" value="Register >>" name="submit"/>&nbsp;<font face="Verdana" style="font-size: 8pt"><a href="jm.php"><b>Back to Registration/Login Page</b></a></font>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <td width="20" background="images/system/body-right.gif">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20" height="20" background="images/system/body-lower-left.gif">&nbsp;</td>
                                <td height="20" background="images/system/body-lower.gif">&nbsp;</td>
                                <td width="20" height="20" background="images/system/body-lower-right.gif">&nbsp;</td>
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