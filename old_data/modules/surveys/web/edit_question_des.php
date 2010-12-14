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
$survey_id = string_wslashes($_GET['sid']);
$question_id = string_wslashes($_GET['qid']);
if(!is_numeric($survey_id) ||!is_numeric($question_id) ) exit;

$dbid = db_connect();

//Globals for usage after executing the following commands
$q_title = "";
$q_type = 0;
$op_count = 0;
$op_title = array();

$continue = false;
$crs = mysql_query("SELECT 1 FROM tbl_survey WHERE survey_id = $survey_id AND owner_id = $param_session_user_user_id",$dbid);
if($crs)
{
    $continue = mysql_num_rows($crs)==1?true:false;
    if($continue)
    {
        $current_id = mysql_insert_id($dbid);
        $rs1 = mysql_query("SELECT q.qtype, qt.title FROM tbl_survey_question q, tbl_survey_question_title qt WHERE qt.question_id = q.question_id AND qt.survey_id = q.survey_id AND q.survey_id = $survey_id AND q.question_id = $question_id AND qt.language_id = $param_session_sys_language",$dbid);
        if(!$rs1)
        {
            exit;
        }
        else
        {
            if($rs1_row = mysql_fetch_array($rs1))
            {
                $q_title = $rs1_row[1];
                $q_type = $rs1_row[0];
                if($q_type==1)
                {
                    $rs2 = mysql_query("SELECT title FROM tbl_survey_option_title WHERE question_id = $question_id AND survey_id = $survey_id AND language_id = $param_session_sys_language ORDER BY option_id ASC", $dbid);
                    if(!$rs2)
                    {
                        exit;
                    }
                    else
                    {
                        $op_count = 0;
                        while($rs2_row = mysql_fetch_array($rs2))
                        {
                            $op_count++;
                            $op_title[] = $rs2_row[0];
                        }
                    }
                }
            }
            else
            {
                exit;
            }
        }
    }
    else
    {
        exit;
    }
}
else
{
    exit;
}

db_close($dbid);

?>

<script language="JavaScript">
    var rules = [];
</script>

<script language="JavaScript">
    function textCounter(field) {
        var maxlimit = 142;
        var fsum = document.skform.title.value.length +
            document.skform.option1.value.length +
            document.skform.option2.value.length +
            document.skform.option3.value.length +
            document.skform.option4.value.length +
            document.skform.option5.value.length +
            document.skform.option6.value.length;
        if (fsum > maxlimit)
        {
            fsum = maxlimit;
            field.value = field.value.substring(0, field.value.length-1);
        }
        else
        {
            document.skform.cnt.value = maxlimit-fsum;
        }
    }
</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="sid" value="<?php echo $survey_id;?>">
    <input type="hidden" name="qid" value="<?php echo $question_id;?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
            <span lang="en-us">Please fill out the following form to edit this question.</span></font></td>
        </tr>
        <tr>
	    <td colspan="3">
		<p align="justify">
		    <font face="Trebuchet MS" size="2">
			<ol>
			    <li>Type in the question in the Question text box. </li>
			    <li>Select the type of question – Free Text, Multiple Choice or Final Question:
				<ul type="disc">
				    <li>Free Text allows respondents to answer open-ended questions</li>
				    <li>Multiple Choice provides up to 6 possible answers</li>
				    <li>Final Question is used to indicate the final question of the survey</li>
				</ul>
			    </li>
			    <li>Click create and repeat for each desired question.</li>
			</ol>

		    </font>
		</p>
	    </td>
	</tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Question<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Question Type<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="title" value="<?php echo $q_title;?>" size="35" onKeyDown="textCounter(document.skform.title)" onKeyUp="textCounter(document.skform.title)"/></td>
            <td width="49%"><select name="qtype">
                    <option value="0" <?php echo ($q_type==0?"selected":"");?>>Free Text</option>
                    <option value="1" <?php echo ($q_type==1?"selected":"");?>>Multiple Choice</option>
                    <option value="2" <?php echo ($q_type==2?"selected":"");?>>Final Message</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #1</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #2</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option1" value="<?php echo $op_title[0];?>" size="35" onKeyDown="textCounter(document.skform.option1)" onKeyUp="textCounter(document.skform.option1)"/></td>
            <td width="49%"><input name="option2" value="<?php echo $op_title[1];?>" size="35" onKeyDown="textCounter(document.skform.option2)" onKeyUp="textCounter(document.skform.option2)"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #3</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #4</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option3" value="<?php echo $op_title[2];?>" size="35" onKeyDown="textCounter(document.skform.option3)" onKeyUp="textCounter(document.skform.option3)"/></td>
            <td width="49%"><input name="option4" value="<?php echo $op_title[3];?>" size="35" onKeyDown="textCounter(document.skform.option4)" onKeyUp="textCounter(document.skform.option4)"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #5</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #6</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option5" value="<?php echo $op_title[4];?>" size="35" onKeyDown="textCounter(document.skform.option5)" onKeyUp="textCounter(document.skform.option5)"/></td>
            <td width="49%"><input name="option6" value="<?php echo $op_title[5];?>" size="35" onKeyDown="textCounter(document.skform.option6)" onKeyUp="textCounter(document.skform.option6)"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" size="2">Character Limit is</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" style="font-size:8pt;"><input readonly type="text" name="cnt" size="3" maxlength="3" value="142">&nbsp;English SMS messages allow for 160 characters. Arabic SMS messages allow for 70 characters. Please Note: Additional content will be sent in a second SMS and will be subject to additional charges.</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="48%" colspan="3"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input type="submit" value="Edit Question" name="submit"/>
	    <input type="button" value="Cancel" onclick="javascript:gogo('<?php echo "edit_questions.php?sid=$survey_id";?>')">
			</font></span></font></td>
        </tr>
    </table>
</form>