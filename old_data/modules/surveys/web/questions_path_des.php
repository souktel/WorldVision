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

function questionList($survey_id, $question_id, $current, $prefix) {
    global $dbid, $param_session_sys_id, $param_session_user_user_id;

    $result = "<select name=\"next_q[]\"><option value=\"$prefix-\"".(""==$current?" selected":"").">No Next Question</option>";

    $query_nq = "SELECT sq.question_id, sqt.title FROM tbl_sys_user su, tbl_survey ss, tbl_survey_question sq, tbl_survey_question_title sqt WHERE su.sys_id = $param_session_sys_id AND su.user_id = $param_session_user_user_id AND ss.survey_id = $survey_id AND ss.owner_id = su.user_id AND sq.survey_id = ss.survey_id AND sqt.survey_id = ss.survey_id AND sqt.question_id = sq.question_id AND sqt.question_id <> $question_id ORDER BY sq.question_id";

    $rs_nq = mysql_query($query_nq,$dbid);
    while($row_nq = mysql_fetch_array($rs_nq)) {
	$nq_title = $row_nq[1];
	$nq_id = $row_nq[0];
	$result .= "<option value=\"$prefix-$nq_id\"".($nq_id==$current?" selected":"").">".strlimit($nq_title)."</option>";
    }

    $result .= "</select>";

    return $result;
}

$query = "SELECT 
ss.survey_id, 
sq.question_id, 
sqt.title, 
sq.qtype,
sq.next_qid,
sq.fst, 
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
<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,startque,Please choose start question!");

</script>

<link rel="stylesheet" href="../../../templates/js/lightbox/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../../../templates/js/lightbox/lightbox.js"></script>

<!--design header table -->
<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="sid" value="<?php echo $survey_id;?>">
    <div align="center">
        <br>
        <table border="0" width="600" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3">
                    <p align="justify">
                        <font face="Trebuchet MS" size="2">
                            Instructions:
                            <ul type="square">
                                <li>Select the first question of the survey by clicking on the radio button (the round button).</li>
                                <li>Select the next question from the dropdown menu.  NOTE: Multiple Choice answers can each be directed to a different next question.</li>
                                <li>Once the question path is determined, click on UPDATE QUESTION PATH to save. </li>
                            </ul>
                        </font>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="50" align="center">&nbsp;</td>
                <td align="center" height="50" colspan="2" valign="middle">
                    <p align="right"><b><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib;?>help.png" border="0">&nbsp;<a href="<?php echo $param_abs_path_sib;?>help_path.gif" rel="lightbox" >HELP</a></font></b></p>
                </td>
            </tr>
        </table>
    </div>
    <?php
    $noq = 0;
    while($row = mysql_fetch_array($rs)) {
	$noq++;
	$rs_survey_id = $row['survey_id'];
	$rs_question_id = $row['question_id'];
	$rs_title = $row['title'];
	$rs_type = $row['qtype'];
	$rs_next = $row['next_qid'];
	$rs_fst = $row['fst'];

	$color = "";
	if($rs_type == 0) $color = "#20A24A"; //Essay Question 20A24A
	else if($rs_type == 1) $color = "#2893C9"; //Multiple Choice Question 2893C9
	    else if($rs_type == 2) $color = "#FFFFFF"; //Final Message FFFFFF

	$qtypedsc = "";
	if($rs_type == 0) $qtypedsc = "Free Text"; //Essay Question
	else if($rs_type == 1) $qtypedsc = "Mutiple Choice Question"; //Multiple Choice Question
	    else if($rs_type == 2) $qtypedsc = "Final Message"; //Final Message

	?>
    <div align="center">
        <br>
        <table border="0" width="600" cellspacing="3" cellpadding="6" style="border-collapse: collapse; border-style: solid; border-width: 1px; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px; border-color:black;" bgcolor="<?php echo $color;?>">
            <tr>
                <td colspan="3">
                    <p align="left">
                        <b>
                            <font face="Trebuchet MS" size="2">
                                Question: <?php echo $rs_title;?>
                            </font>
                        </b>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p align="left">
                        <b>
                            <font face="Trebuchet MS" size="2">
                                Question Type: <?php echo $qtypedsc;?>
                            </font>
                        </b>
                    </p>
                </td>
            </tr>
		<?php if($rs_type != 2) { ?>
            <tr>
                <td colspan="3">
                    <p align="left">
                        <font face="Trebuchet MS" size="2">
                            <b>
                                <input type="radio" value="<?php echo $rs_question_id;?>" name="startque"<?php echo $rs_fst==2?" checked":"";?>>Select to make this the first question in the survey
                            </b>
                        </font>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr size="0" style="border-color:black;"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <b>
                        <font face="Trebuchet MS" size="2">
                            Select Next Question in the Survey:
                        </font>
                    </b>
                </td>
            </tr>
		    <?php if($rs_type == 0) { ?>
            <tr>
                <td align="center" width="50">&nbsp;</td>
                <td width="220">&nbsp;</td>
                <td><?php echo questionList($rs_survey_id, $rs_question_id, $rs_next, $rs_question_id);?></td>
            </tr>
		    <?php } if($rs_type == 1) {
			$query_op = "SELECT ot.option_id, ot.title, o.next_qid FROM tbl_sys_user su, tbl_survey ss, tbl_survey_question sq, tbl_survey_option o, tbl_survey_option_title ot WHERE su.sys_id = $param_session_sys_id AND su.user_id = $param_session_user_user_id AND ss.survey_id = $survey_id AND ss.owner_id = su.user_id AND sq.survey_id = ss.survey_id AND ot.survey_id = sq.survey_id AND ot.question_id = sq.question_id AND o.question_id = sq.question_id AND o.option_id = ot.option_id AND sq.question_id = $rs_question_id ORDER BY ot.option_id";
			$rs_op = mysql_query($query_op,$dbid);
			$opc=0;
			while($row_op = mysql_fetch_array($rs_op)) {
			    $op_title = $row_op[1];
			    $op_id = $row_op[0];
			    $op_next = $row_op[2];
			    $opc++;
			    ?>
            <tr>
                <td align="center" width="50">&nbsp;</td>
                <td width="220"><?php echo $op_title;?></td>
                <td><?php echo questionList($rs_survey_id, $rs_question_id,$op_next , $rs_question_id."-".$op_id);?></td>
            </tr>
			<?php  } } }?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <?php
    }
    db_close($dbid);
    ?>
    <br>
    <table border="0" width="600" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td>
		<?php if($noq>0) {?><input type="submit" value="Update Questions' Path" name="submit"/><?php }?>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo "edit_questions.php?sid=$survey_id";?>')">
	    </td>
        </tr>
    </table>
</form>