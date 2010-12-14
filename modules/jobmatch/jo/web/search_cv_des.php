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

<form name="skform" method="GET" action="<?php echo $file_name;?>">
    <input type="hidden" name="act" value="2">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    <span lang="en-us">Please fill out the following form to search for
            mini cv.</span></font></td>
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
            <td width="48%"><font face="Trebuchet MS" size="2">Years Of Experience</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="experience" style="width:200px;">
                    <option value="NA"></option>
                    <?php
                    for($years=0; $years <= 25; $years++) {
                        echo "<option value=\"$years\">".($years==0?"No Experience":$years." Year".($years==1?"":"s"))."</option>";
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
                    <option value="NA"></option>
                    <?php
                    $dbid = db_connect();
                    $rs1 = mysql_query("SELECT c.level_id, ct.name FROM tbl_ref_education_level c, tbl_ref_education_level_title ct WHERE ct.level_id = c.level_id AND ct.language_id = $param_session_sys_language", $dbid);
                    while($row1 = mysql_fetch_array($rs1))
                    {
                        $row_id = $row1[0];
                        $row_name = $row1[1];
                        echo "<option value=\"$row_id\">$row_name</option>";
                    }
                    ?>
            </select></td>
            <td width="49%"><select size="1" name="major" style="width:200px;">
                    <option value="NA"></option>
                    <?php
                    $rs2 = mysql_query("SELECT c.major_id, ct.name FROM tbl_ref_major c, tbl_ref_major_title ct WHERE ct.major_id = c.major_id AND ct.language_id = $param_session_sys_language", $dbid);
                    while($row2 = mysql_fetch_array($rs2))
                    {
                        $row_id = $row2[0];
                        $row_name = $row2[1];
                        echo "<option value=\"$row_id\">$row_name</option>";
                    }
                    ?>
            </select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Country<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">City</font></td>
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
                        echo "<option value=\"$row_id\" ".($row_id==$param_session_user_country?"selected":"").">$row_name</option>";
                    }
                    ?>
            </select></td>
            <td width="49%"><select size="1" name="city" style="width:200px;">
                    <option value="NA"></option>
                    <?php
                    $rs4 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $param_session_sys_country", $dbid);
                    while($row4 = mysql_fetch_array($rs4))
                    {
                        $row_id = $row4[0];
                        $row_name = $row4[1];
                        echo "<option value=\"$row_id\">$row_name</option>";
                    }
                    db_close($dbid);
                    ?>
            </select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Availability to Work</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">&nbsp</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="hours_range" style="width:200px;">
                    <option value="NA"></option>
                    <option value="1">Full Time</option>
                    <option value="2">Part Time - A.M.</option>
                    <option value="3">Part Time - P.M.</option>
                    <option value="4">Intern/Training</option>
                </select>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Gender</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select size="1" name="gender" style="width:200px;">
                    <option value="NA"></option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="submit" value="Find Mini CV" name="submit"/>
            </td>
        </tr>
    </table>
</form>
