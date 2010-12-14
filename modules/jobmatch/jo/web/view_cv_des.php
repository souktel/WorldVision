<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}
?>
<?php
$cv_id = string_wslashes($_GET['cid']);
if(!is_numeric($cv_id)) exit;

$dbid1 = db_connect();

if($cv_rs = mysql_query("SELECT v.*,u.name AS uname, u.mobile AS umobile, u.email, u.country AS ucountry, u.city AS ucity, ui.*  FROM tbl_js_mini_cv v, tbl_sys_user u, tbl_sys_user_ind ui WHERE v.cv_id = $cv_id AND v.sys_id = $param_session_sys_id AND v.status > 0 AND v.user_id = u.user_id AND u.status > 0 AND u.user_id = ui.user_id",$dbid1))
{
    if($cv_row = mysql_fetch_array($cv_rs))
    {
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

        $referrer = $_SERVER['HTTP_REFERER'];
        ?>

<form>
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">CV Owner Information</font><font face="Trebuchet MS" size="2">&nbsp;<a target="_blank" href="print_cv.php?cid=<?php echo $cv_id;?>">(Print)</a></font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">Full Name</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <input name="uname" size="75" readonly="true" value="<?php echo $uname;?>"/>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Country</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">City</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <?php
                $dbid = db_connect();
                $rs00 = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $ucountry", $dbid);
                if($row00 = mysql_fetch_array($rs00))
                {
                    echo "<input name=\"ucountry\" readonly=\"true\" size=\"30\" value=\"".$row00[1]."\"/>";
                }
                ?>
            </td>
            <td width="49%">
                <?php
                $rs0 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $ucountry AND c.city_id = $ucity", $dbid);
                if($row0 = mysql_fetch_array($rs0))
                {
                    echo "<input name=\"ucity\" readonly=\"true\" size=\"30\" value=\"".$row0[1]."\"/>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Gender</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Date Of Birth</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <input name="gender" size="30" readonly="true" value="<?php echo $gender;?>"/>
            </td>
            <td width="49%">
                <input name="dob" size="30" readonly="true" value="<?php echo $dob;?>"/>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Email</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Mobile</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <input name="email" size="30" readonly="true" value="<?php echo $email;?>"/>
            </td>
            <td width="49%">
                <input name="mobile" size="30" readonly="true" value="<?php echo $mobile;?>"/>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Mini CV Information</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Reference</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Creation Date</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <input name="reference" size="30" readonly="true" value="<?php echo $reference;?>"/>
            </td>
            <td width="49%">
                <input name="addition_date" size="30" readonly="true" value="<?php echo $addition_date;?>"/>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Years Of Experience</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <input name="experience" size="30" readonly="true" value="<?php
                       if($experience==0) echo "No Experience";
                       else if($experience==11) echo "More than 10 years";
                       else echo $experience." Year".($years==1?"":"s");
                       ?>"/>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Educational Level</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Sector</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <?php
                $rs1 = mysql_query("SELECT c.level_id, ct.name FROM tbl_ref_education_level c, tbl_ref_education_level_title ct WHERE ct.level_id = c.level_id AND ct.language_id = $param_session_sys_language AND c.level_id = $education_level", $dbid);
                if($row1 = mysql_fetch_array($rs1))
                {
                    echo "<input name=\"experience\" readonly=\"true\" size=\"30\" value=\"".$row1[1]."\"/>";
                }
                ?>

            </td>
            <td width="49%">
                <?php
                $rs2 = mysql_query("SELECT c.major_id, ct.name FROM tbl_ref_major c, tbl_ref_major_title ct WHERE ct.major_id = c.major_id AND ct.language_id = $param_session_sys_language AND c.major_id = $major", $dbid);
                if($row2 = mysql_fetch_array($rs2))
                {
                    echo "<input name=\"major\" readonly=\"true\" size=\"30\" value=\"".$row2[1]."\"/>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Country</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">City</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <?php
                $rs3 = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $country", $dbid);
                if($row3 = mysql_fetch_array($rs3))
                {
                    echo "<input name=\"country\" readonly=\"true\" size=\"30\" value=\"".$row3[1]."\"/>";
                }
                ?>
            </td>
            <td width="49%">
                <?php
                $rs4 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $country AND c.city_id = $city", $dbid);
                if($row4 = mysql_fetch_array($rs4))
                {
                    echo "<input name=\"city\" readonly=\"true\" size=\"30\" value=\"".$row4[1]."\"/>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Availability to Work</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Driving License</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <?php
                switch($hours_range)
                {
                    case 1: $hours_range = "Full Time";break;
                        case 2: $hours_range = "Part Time - A.M.";break;
                            case 3: $hours_range = "Part Time - P.M.";break;
                                case 4: $hours_range = "Intern/Training";
                                }
                ?>
                <input name="hours_range" size="30" readonly="true" value="<?php echo $hours_range;?>"/>
            </td>
            <td width="49%">
                <input name="driving_license" size="30" readonly="true" value="<?php echo $driving_license==0?"Not Required":"Required";?>"/>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Other Skills</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <textarea name="other_info" cols="70" readonly="true" rows="6"><?php echo $other_info;?></textarea>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>"><<&nbsp;Return to previous!</a></font></b></td>
        </tr>
    </table>
</form>
<?php
}
}
db_close($dbid1);
?>