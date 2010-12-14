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
$survey_id = string_wslashes($_GET['sid']);
if(!is_numeric($survey_id)) exit;

$dbid = db_connect();

$query = "SELECT 
ss.survey_id, 
sq.question_id, 
sqt.title, 
sq.qtype, 
(SELECT COUNT(1) FROM tbl_survey_option WHERE survey_id = sq.survey_id AND question_id = sq.question_id) AS noo 
FROM tbl_sys_user su, tbl_survey ss, tbl_survey_question sq, tbl_survey_question_title sqt 
WHERE su.sys_id = $param_session_sys_id 
AND su.user_id = $param_session_user_user_id 
AND ss.survey_id = $survey_id 
AND ss.owner_id = su.user_id 
AND sq.survey_id = ss.survey_id 
AND sqt.survey_id = ss.survey_id 
AND sqt.question_id = sq.question_id 
ORDER BY sq.question_id";

//echo $query;exit;

$rs = mysql_query($query,$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="30"><font face="Trebuchet MS" size="2"><b>#</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b>Question Type</b></font></td>
        <td width="460"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
        <td width="90">&nbsp;</td>
    </tr>
<?php
    $noq = 0;
    while($row = mysql_fetch_array($rs)) {
	$noq++;
	$rs_survey_id = $row['survey_id'];
	$rs_question_id = $row['question_id'];
	$rs_title = $row['title'];
	$rs_type = "";
	if($row['qtype'] == 0) $rs_type = "Free Text";
	else if($row['qtype'] == 1) $rs_type = "Multiple"."(".$row['noo'].")";
	    else if($row['qtype'] == 2) $rs_type = "Final Message";
	?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib;?>view_question_s.png"></font></td>
        <td width="30"><font face="Trebuchet MS" size="2"><?php echo $noq;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><?php echo $rs_type;?></font></td>
        <td width="460"><font face="Trebuchet MS" size="2"><a href="edit_question.php?sid=<?php echo $rs_survey_id;?>&qid=<?php echo $rs_question_id;?>"><?php echo $rs_title;?></a></font></td>
        <td width="90"><table border="0" width="80" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td><font face="Trebuchet MS" size="2"><a href="view_question.php?sid=<?php echo $rs_survey_id;?>&qid=<?php echo $rs_question_id;?>"><img title="Question Summary" border="0" src="<?php echo $param_abs_path_sib."view_question_s.png";?>" width="16" height="16"></a></font></td>
		    <td><font face="Trebuchet MS" size="2"><a href="edit_question.php?sid=<?php echo $rs_survey_id;?>&qid=<?php echo $rs_question_id;?>"><img title="Edit Question" border="0" src="<?php echo $param_abs_path_sib."edit_question_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_question.php?sid=<?php echo $rs_survey_id;?>&qid=<?php echo $rs_question_id;?>"><img title="Delete Question" border="0" src="<?php echo $param_abs_path_sib."delete_question_s.png";?>" width="16" height="16"></a></font></td>
                </tr>
	    </table></td>
    </tr>
<?php
}
    ?>
    <!--design footer table -->
    <?php if($noq==0) { ?>
    <tr>
	<td width="17">&nbsp;</td>
        <td colspan="5"><font face="Trebuchet MS" size="2"><b>No questions currently in the survey.</b></font></td>
    </tr>
<?php }?>
    <tr>
        <td colspan="6">
            <table border="0" width="300" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."create_question_s.png";?>" width="16" height="16"></td>
                    <td><font face="Trebuchet MS" size="2"><a href="create_question.php?sid=<?php echo $survey_id;?>&ru=<?php echo $referrer;?>">Create Question</a></font></td>
                    <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."questions_path_s.png";?>" width="16" height="16"></td>
                    <td><font face="Trebuchet MS" size="2"><a href="questions_path.php?sid=<?php echo $survey_id;?>&ru=<?php echo $referrer;?>">Questions Path</a></font></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="6"><b><font face="Trebuchet MS" size="2"><a href="<?php echo "index.php";?>"><<&nbsp;Return to All Surveys</a></font></b></td>
    </tr>
</table>
<?php

db_close($dbid);
?>