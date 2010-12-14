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
$error_found = false;

$survey_id = string_wslashes($_GET['sid']);
if(!is_numeric($survey_id)) exit;

$dbid = db_connect();

if($rs = mysql_query("SELECT (SELECT title FROM tbl_survey_title WHERE survey_id = ss.survey_id), (SELECT description FROM tbl_survey_title WHERE survey_id = ss.survey_id), ss.status, ss.reference_code, ss.addition_date FROM tbl_survey ss WHERE ss.survey_id = $survey_id AND ss.sys_id = $param_session_sys_id AND ss.owner_id = $param_session_user_user_id", $dbid))
{
    if($row = mysql_fetch_array($rs))
    {
        $rs_title = $row[0];
        $rs_desc = $row[1];
        $rs_status = $row[2];
        $rs_reference = $row[3];
        $rs_addition_date = $row[4];
    }
}
else
{
    exit;
}

db_close($dbid);  

$referrer = $_SERVER['HTTP_REFERER'];

?>
<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Survey Title</font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Survey Status</font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%">
            <input name="title" size="35" value="<?php echo $rs_title;?>" readonly="true"/>
        </td>
        <td width="49%">
            <input name="status" size="35" value="<?php echo $rs_status==0?"OFF":"ON";?>" readonly="true"/>
        </td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Survey Reference</font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Creation Date</font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%">
            <input name="title" size="35" value="<?php echo $rs_reference;?>" readonly="true"/>
        </td>
        <td width="49%">
            <input name="status" size="35" value="<?php echo $rs_addition_date;?>" readonly="true"/>
        </td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2">
        <textarea rows="4" name="description" cols="69" readonly="true"><?php echo $rs_desc;?></textarea></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>"><<&nbsp;Return to previous!</a></font></b></td>
    </tr>
</table>