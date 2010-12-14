<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}
?>

<?php
//Pages
$pageNum = 1;

if(isset($_GET['page'])) {
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "SELECT ss.survey_id, ss.reference_code, ss.status, ss.addition_date, (SELECT count(1) FROM tbl_survey_question WHERE survey_id = ss.survey_id) AS ques, (SELECT title FROM tbl_survey_title WHERE survey_id = ss.survey_id) AS title FROM tbl_sys_user su, tbl_survey ss WHERE su.sys_id = $param_session_sys_id AND su.user_id = $param_session_user_user_id AND ss.owner_id = su.user_id ORDER BY ss.addition_date DESC";
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b># Of Questions</b></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><b>Creation Date</b></font></td>
        <td width="130">&nbsp;</td>
    </tr>
<?php
    while($row = mysql_fetch_array($rs)) {
	$rs_survey_id = $row['survey_id'];
	$rs_title = $row['title'];
	$rs_reference = $row['reference_code'];
	$rs_ques = $row['ques'];
	$rs_status = $row['status'];
	$rs_addition_date = $row['addition_date'];
	$hash_string = $rs_survey_id."A".$param_session_sys_id."A".$param_session_user_user_id;
	$hash_val1 = $hash_string."-".sha1("125+6BP".$hash_string."+CcX");
	?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib;?>view_survey_s.png"></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><a href="edit_questions.php?sid=<?php echo $rs_survey_id;?>"><?php echo $rs_title;?></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><font face="Trebuchet MS" size="1"><a href="edit_questions.php?sid=<?php echo $rs_survey_id;?>"><?php echo $rs_ques;?></a></font></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
        <td width="130"><table border="0" width="100" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td><font face="Trebuchet MS" size="2"><img border="0" src="<?php echo $param_abs_path_sib.($rs_status=="1"?"on.png":"off.png");?>" width="16" height="16"></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="view_survey.php?sid=<?php echo $rs_survey_id;?>"><img title="Survey Summary" border="0" src="<?php echo $param_abs_path_sib."view_survey_s.png";?>" width="16" height="16"></a></font></td>
		    <td><font face="Trebuchet MS" size="2"><a href="edit_questions.php?sid=<?php echo $rs_survey_id;?>"><img title="Add Questions" border="0" src="<?php echo $param_abs_path_sib."questions_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a target="_blank" href="survey_results.php?act=1&extended=ED455Xx&sid=<?php echo $rs_survey_id;?>"><img title="Survey Results" border="0" src="<?php echo $param_abs_path_sib."result_survey.png";?>" width="16" height="16"></a></font></td>
		    <td><font face="Trebuchet MS" size="2"><a href="ex_survey_results.php?act=1&srv=<?php echo $hash_val1;?>"><img title="XML Survey Results" border="0" src="<?php echo $param_abs_path_sib."excell.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="edit_survey.php?sid=<?php echo $rs_survey_id;?>"><img title="Edit Survey Info" border="0" src="<?php echo $param_abs_path_sib."edit_survey_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_survey.php?sid=<?php echo $rs_survey_id;?>"><img title="Delete Survey" border="0" src="<?php echo $param_abs_path_sib."delete_survey_s.png";?>" width="16" height="16"></a></font></td>
                </tr>
	    </table></td>
    </tr>
<?php
}
?>
    <!--design footer table -->
</table>
    <?php

require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>