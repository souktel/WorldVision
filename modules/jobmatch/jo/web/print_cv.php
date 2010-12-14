<?php
session_start();
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$apath = "../../../../";

require_once($apath."auth/check_authentication.php");
require_once($apath."config/parameters/params_db.php");
require_once($apath."config/database/db_mysql.php");
require_once($apath."config/parameters/params_main.php");
require_once($apath."config/parameters/params_session.php");
require_once($apath."config/parameters/params_header_menu.php");
require_once($apath."config/functions/validation.php");
require_once($apath."config/functions/util_func.php");
require_once($apath."config/functions/val_func.php");
require_once($apath."config/functions/oth_func.php");
require_once($apath."config/functions/send_func.php");

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}

check_valid_login();
?>
<?php
$cv_id = string_wslashes($_GET['cid']);
if(!is_numeric($cv_id)) exit;

$dbid1 = db_connect();

if($cv_rs = mysql_query("SELECT v.*,u.name AS uname, u.mobile AS umobile, u.email, u.country AS ucountry, u.city AS ucity, ui.*  FROM tbl_js_mini_cv v, tbl_sys_user u, tbl_sys_user_ind ui WHERE v.cv_id = $cv_id AND v.sys_id = $param_session_sys_id AND v.status > 0 AND v.user_id = u.user_id AND u.status > 0 AND u.user_id = ui.user_id",$dbid1)) {
    if($cv_row = mysql_fetch_array($cv_rs)) {
	$cv_id = $cv_row['cv_id'];
	$uname = $cv_row['uname'];
	$experience = $cv_row['experience'];
	$education_level = $cv_row['education_level'];
	$major = $cv_row['major'];
	$country = $cv_row['country'];
	$city = $cv_row['city'];
	$hours_range = $cv_row['hours_range'];
	$driving_license = $cv_row['driving_license'];
	$other_info = $cv_row['other_info'];
	$status = $cv_row['status'];
	$reference = $cv_row['reference_code'];
	$addition_date = $cv_row['addition_date'];;

	$uname = $cv_row['uname'];
	$email = $cv_row['email'];
	$mobile = $cv_row['umobile'];
	$ucountry = $cv_row['ucountry'];
	$ucity = $cv_row['ucity'];
	$gender = $cv_row['gender']==0?"Male":"Female";
	$dob = $cv_row['dob_y']."-".$cv_row['dob_m']."-".$cv_row['dob_d'];


	$dbid = db_connect();
	$rs00 = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $ucountry", $dbid);
	if($row00 = mysql_fetch_array($rs00)) {
	    $ucountry_n = $row00[1];
	}

	$rs0 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $ucountry AND c.city_id = $ucity", $dbid);
	if($row0 = mysql_fetch_array($rs0)) {
	    $ucity_n = $row0[1];
	}

	if($experience==0) $experience = "No Experience";
	else if($experience==11) $experience = "More than 10 years";
	    else $experience = $experience." Year".($years==1?"":"s");

	$rs1 = mysql_query("SELECT c.level_id, ct.name FROM tbl_ref_education_level c, tbl_ref_education_level_title ct WHERE ct.level_id = c.level_id AND ct.language_id = $param_session_sys_language AND c.level_id = $education_level", $dbid);
	if($row1 = mysql_fetch_array($rs1)) {
	    $education_level = $row1[1];
	}

	$rs2 = mysql_query("SELECT c.major_id, ct.name FROM tbl_ref_major c, tbl_ref_major_title ct WHERE ct.major_id = c.major_id AND ct.language_id = $param_session_sys_language AND c.major_id = $major", $dbid);
	if($row2 = mysql_fetch_array($rs2)) {
	    $major = $row2[1];
	}

	$rs3 = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $country", $dbid);
	if($row3 = mysql_fetch_array($rs3)) {
	    $country_n = $row3[1];
	}

	$rs4 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $country AND c.city_id = $city", $dbid);
	if($row4 = mysql_fetch_array($rs4)) {
	    $city_n = $row4[1];
	}

	switch($hours_range) {
	    case 1: $hours_range = "Full Time";break;
	    case 2: $hours_range = "Part Time - A.M.";break;
	    case 3: $hours_range = "Part Time - P.M.";break;
	    case 4: $hours_range = "Intern/Training";
	}
	?>
<html>

    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Print Mini CV</title>
    </head>

    <body>

	<p align="center"><br>
	    <font size="7"><?php echo $uname;?></font></p>
	<p align="center"><font size="5"><?php echo $ucountry_n;?></font><font size="5">, <?php echo $ucity_n;?></font></p>
	<p align="center"><font size="5"><?php echo $mobile;?></font></p>
	<p>&nbsp;</p>
	<div align="center">
	    <table border="0" width="600" cellspacing="6" cellpadding="6" style="border-collapse: collapse">
		<tr>
		    <td colspan="2"><hr color="#000000" size="1"></td>
		</tr>
		<tr>
		    <td><b><font size="4">Country</font></b></td>
		    <td><b><font size="4">City</font></b></td>
		</tr>
		<tr>
		    <td><?php echo $country_n;?></td>
		    <td><?php echo $city_n;?></td>
		</tr>
		<tr>
		    <td><b><font size="4">Educational Level</font></b></td>
		    <td><b><font size="4">Sector</font></b></td>
		</tr>
		<tr>
		    <td><?php echo $education_level;?></td>
		    <td><?php echo $major;?></td>
		</tr>
		<tr>
		    <td><b><font size="4">Years of Experience</font></b></td>
		    <td><b><font size="4">Availability to Work</font></b></td>
		</tr>
		<tr>
		    <td><?php echo $experience;?></td>
		    <td><?php echo $hours_range;?></td>
		</tr>
		<tr>
		    <td><b><font size="4">Gender</font></b></td>
		    <td><b><font size="4">Date of Birth</font></b></td>
		</tr>
		<tr>
		    <td><?php echo $gender;?></td>
		    <td><?php echo $dob;?></td>
		</tr>
		<tr>
		    <td><b><font size="4">Email</font></b></td>
		    <td><b><font size="4">Driving License</font></b></td>
		</tr>
		<tr>
		    <td><?php echo $email;?></td>
		    <td><?php echo $driving_license==0?"Not Required":"Required";?></td>
		</tr>
		<tr>
		    <td><b><font size="4">Other Skills</font></b></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		    <td colspan="2">
			<p align="justify"><?php echo $other_info;?></p>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><hr color="#000000" size="1"></td>
		</tr>
		<tr>
		    <td>
			<p align="left"><font size="2"><?php echo $reference;?></font></p>
		    </td>
		    <td>
			<p align="right"><font size="2"><?php echo $addition_date;?></font></p>
		    </td>
		</tr>
	    </table>
	    <p>&nbsp;</p>
	</div>

    </body>

</html>
    <?php
    }
}
db_close($dbid1);
?>
