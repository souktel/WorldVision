<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZ234vvvdkfgjZSD4352SDdfZz22W")
{
    header("Location: index.php");
}
?>

<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,title,Required : Title.");
    rules.push("length<=100,title,Title : < 100 chars please.");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    Fill in the Survey Name and Description fields. This information will help you identify each survey, but does not appear publicly.
		</font>
	    </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Survey Title<font color="#FF0000">
            *</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input name="title" size="35" /></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
            <textarea rows="4" name="description" cols="60"></textarea></td>
        </tr>
        <tr>
            <td width="48%" colspan="3"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input type="submit" value="Create Survey" name="submit"/></font></span></font></td>
        </tr>
    </table>
</form>