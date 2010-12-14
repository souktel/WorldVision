<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZ234vvvdkfgjZSD4352SDdfZz22W") {
    header("Location: index.php");
}
?>

<?php
$error_found = false;

$survey_id = string_wslashes($_GET['sid']);
if(!is_numeric($survey_id)) exit;

$dbid = db_connect();

if($rs = mysql_query("SELECT (SELECT title FROM tbl_survey_title WHERE survey_id = ss.survey_id), (SELECT description FROM tbl_survey_title WHERE survey_id = ss.survey_id), ss.status FROM tbl_survey ss WHERE ss.survey_id = $survey_id AND ss.sys_id = $param_session_sys_id AND ss.owner_id = $param_session_user_user_id", $dbid)) {
    if($row = mysql_fetch_array($rs)) {
	$rs_title = $row[0];
	$rs_desc = $row[1];
	$rs_status = $row[2];
    }
}
else {
    exit;
}

db_close($dbid);  

$referrer = $_SERVER['HTTP_REFERER'];

?>
<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,title,Required : Title.");
    rules.push("length<=100,title,Title : < 100 chars please.");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
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
            <td width="49%"><font face="Trebuchet MS" size="2">Survey Status<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input name="title" size="35" value="<?php echo $rs_title;?>"/></font></span></font></td>
            <td width="49%"><select name="status">
                    <option value="0" <?php if($rs_status == 0) { echo "SELECTED"; }?>>OFF</option>
                    <option value="1" <?php if($rs_status == 1) { echo "SELECTED"; }?>>ON</option>
		</select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
		<textarea rows="4" name="description" cols="60"><?php echo $rs_desc;?></textarea></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt">
			<font face="Trebuchet MS">
			    <input type="submit" value="Edit Survey" name="submit"/>
			    <input type="button" value="Cancel" onclick="javascript:gogo('<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>')">
			</font>
		    </span>
		</font></td>
        </tr>
    </table>
</form>