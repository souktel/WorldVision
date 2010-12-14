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
$job_id = string_wslashes($_GET['jid']);
if(!is_numeric($job_id)) exit;

$dbid1 = db_connect();

if($job_rs = mysql_query("SELECT * FROM tbl_jo_job_vacancy WHERE job_id = $job_id AND sys_id = $param_session_sys_id AND user_id = $param_session_user_user_id",$dbid1))
{
    if($job_row = mysql_fetch_array($job_rs))
    {

        $job_id = $job_row['job_id'];
        $vacancy_title = $job_row['vacancy_title'];
        $experience = $job_row['experience'];
        $education_level = $job_row['education_level'];
        $major = $job_row['major'];
        $country = $job_row['country'];
        $city = $job_row['city'];
        $hours_range = $job_row['hours_range'];
        $driving_license = $job_row['driving_license'];
        $other_info = $job_row['other_info'];
        $status = $job_row['status'];

        $referrer = $_SERVER['HTTP_REFERER'];
        ?>
<script language="JavaScript">
    var rules = [];

    //Vacancy Title
    rules.push("required,vacancy_title,Required : Vacancy Title.");
    rules.push("length<=100,vacancy_title,Vacancy Title : < 100 chars please.");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="job_id" value="<?php echo $job_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    <span lang="en-us">Please fill out the following form to edit this
            job vacancy.</span></font></td>
        </tr>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">*
            Required<span lang="en-us"> field.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">General Information</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Job Title<font color="#FF0000">
            *</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><input name="vacancy_title" size="75" value="<?php echo $vacancy_title;?>"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Years Of Experience<font color="#FF0000">
            *</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="experience" style="width:200px;">
                    <?php
                    for($years=0; $years <= 25; $years++) {
                        echo "<option value=\"$years\" ".($years==$experience?"selected":"").">".($years==0?"No Experience":$years." Year".($years==1?"":"s"))."</option>";
                    }
                    ?>
                </select>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Educational Level<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Sector<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><select size="1" name="education_level" style="width:200px;">
                    <?php
                    $dbid = db_connect();
                    $rs1 = mysql_query("SELECT c.level_id, ct.name FROM tbl_ref_education_level c, tbl_ref_education_level_title ct WHERE ct.level_id = c.level_id AND ct.language_id = $param_session_sys_language", $dbid);
                    while($row1 = mysql_fetch_array($rs1))
                    {
                        $row_id = $row1[0];
                        $row_name = $row1[1];
                        echo "<option value=\"$row_id\" ".($row_id==$education_level?"selected":"").">$row_name</option>";
                    }
                    ?>
            </select></td>
            <td width="49%"><select size="1" name="major" style="width:200px;">
                    <?php
                    $rs2 = mysql_query("SELECT c.major_id, ct.name FROM tbl_ref_major c, tbl_ref_major_title ct WHERE ct.major_id = c.major_id AND ct.language_id = $param_session_sys_language", $dbid);
                    while($row2 = mysql_fetch_array($rs2))
                    {
                        $row_id = $row2[0];
                        $row_name = $row2[1];
                        echo "<option value=\"$row_id\" ".($row_id==$major?"selected":"").">$row_name</option>";
                    }
                    ?>
            </select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Country<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">City<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><select size="1" name="country" style="width:200px;">
                    <?php
                    $rs3 = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $param_session_sys_country", $dbid);
                    while($row3 = mysql_fetch_array($rs3))
                    {
                        $row_id = $row3[0];
                        $row_name = $row3[1];
                        echo "<option value=\"$row_id\" ".($row_id==$country?"selected":"").">$row_name</option>";
                    }
                    ?>
            </select></td>
            <td width="49%"><select size="1" name="city" style="width:200px;">
                    <?php
                    $rs4 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $country", $dbid);
                    while($row4 = mysql_fetch_array($rs4))
                    {
                        $row_id = $row4[0];
                        $row_name = $row4[1];
                        echo "<option value=\"$row_id\" ".($row_id==$city?"selected":"").">$row_name</option>";
                    }
                    db_close($dbid);
                    ?>
            </select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Work Time Schedule<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Driving License<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="hours_range" style="width:200px;">
                    <option value="1" <?php echo $hours_range==1?"selected":"";?>>Full Time</option>
                    <option value="2" <?php echo $hours_range==2?"selected":"";?>>Part Time - A.M.</option>
                    <option value="3" <?php echo $hours_range==3?"selected":"";?>>Part Time - P.M.</option>
                    <option value="4" <?php echo $hours_range==4?"selected":"";?>>Intern/Training</option>
                </select>
            </td>
            <td width="49%">
                <select size="1" name="driving_license" style="width:200px;">
                    <option value="0" <?php echo  ($driving_license==0?"selected":"");?>>Not Required</option>
                    <option value="1" <?php echo  ($driving_license==1?"selected":"");?>>Required</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Status<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">&nbsp;</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="status" style="width:200px;">
                    <option value="0" <?php echo  ($status==0?"selected":"");?>>OFF</option>
                    <option value="1" <?php echo  ($status==1?"selected":"");?>>ON</option>
                </select>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Other Needed Skills</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <textarea name="other_info" cols="70" rows="6"><?php echo $other_info;?></textarea>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>"><<&nbsp;Return to previous!</a></font></b></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="submit" value="Edit Job Vacancy" name="submit"/>
            </td>
        </tr>
    </table>
</form>
<?php
}
}
db_close($dbid1);
?>