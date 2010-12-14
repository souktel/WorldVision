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

<script language="JavaScript" type="text/javascript">
    function validatePr()
    {
        var pr_se = document.mtform.se.value;
        var pr_lc = document.mtform.lc.value;
        var pr_el = document.mtform.el.value;
        var pr_wh = document.mtform.wh.value;
        var pr_ex = document.mtform.ex.value;

        if(parseInt(pr_se, 10) + parseInt(pr_lc, 10) + parseInt(pr_el, 10) + parseInt(pr_wh, 10) + parseInt(pr_ex, 10) == 31)
        {
            return true;
        }
        else
        {
            alert("You have duplicates in priorities, please make sure you don't have duplicates in priorities.");
            return false;
        }
    }
</script>

<form name="mtform" method="GET" action="<?php echo $file_name;?>" onsubmit="return validatePr()">
    <input type="hidden" name="act" value="2">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    <span lang="en-us">Please fill out the following form to match
            job vacancy.</span></font></td>
        </tr>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">*
            Required<span lang="en-us"> field.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Curriculum Vitae</b><font color="#FF0000">
            *</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <?php
                $dbid = db_connect();
                $query = "SELECT reference_code, addition_date FROM tbl_js_mini_cv WHERE sys_id = $param_session_sys_id AND user_id = $param_session_user_user_id AND status >= 1 ORDER BY addition_date DESC";
                if($cv_rs = mysql_query($query, $dbid))
                {
                    ?>
                <select size="1" name="reference" style="width:220px;">
                    <?php
                    while($cv_row = mysql_fetch_array($cv_rs))
                    {
                        $reference = $cv_row[0];
                        $cdate = $cv_row[1];
                        echo "<option value=\"$reference\">$reference | $cdate</option>";
                    }
                    ?>
                </select>
                <?php
            }
            db_close($dbid);
            ?>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Matching Priority</b><font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">&nbsp;</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Sector</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Location</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select name="se" style="width:220px;">
                    <option value="16" selected>1st Priority</option>
                    <option value="8">2nd Priority</option>
                    <option value="4">3rd Priority</option>
                    <option value="2">4th Priority</option>
                    <option value="1">5th Priority</option>
                </select>
            </td>
            <td width="49%">
                <select name="lc" style="width:220px;">
                    <option value="16">1st Priority</option>
                    <option value="8" selected>2nd Priority</option>
                    <option value="4">3rd Priority</option>
                    <option value="2">4th Priority</option>
                    <option value="1">5th Priority</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Educational Level</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Work Time Schedule</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select name="el" style="width:220px;">
                    <option value="16">1st Priority</option>
                    <option value="8">2nd Priority</option>
                    <option value="4" selected>3rd Priority</option>
                    <option value="2">4th Priority</option>
                    <option value="1">5th Priority</option>
                </select>
            </td>
            <td width="49%">
                <select name="wh" style="width:220px;">
                    <option value="16">1st Priority</option>
                    <option value="8">2nd Priority</option>
                    <option value="4">3rd Priority</option>
                    <option value="2" selected>4th Priority</option>
                    <option value="1">5th Priority</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Years of Experience</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%">
                <select name="ex" style="width:220px;">
                    <option value="16">1st Priority</option>
                    <option value="8">2nd Priority</option>
                    <option value="4">3rd Priority</option>
                    <option value="2">4th Priority</option>
                    <option value="1" selected>5th Priority</option>
                </select>
            </td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="submit" value="Match Me" name="submit"/>
            </td>
        </tr>
    </table>
</form>
