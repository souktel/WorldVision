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
$survey_id = string_wslashes($_GET['sid']);
if(!is_numeric($survey_id)) exit;
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
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
	    <td colspan="3">
		<p align="justify">
		    <font face="Trebuchet MS" size="2">
			<p>To create a question:</p>
			<ol>
			    <li>Type in the question in the Question text box.</li>
			    <li>Select the type of question:<ul type="disc">
				    <li>Free Text allows respondents to answer open-ended questions.</li>
				    <li>Multiple Choice provides up to 6 possible answers.</li>
				    <li>Final Question is used to indicate the final question of the survey.</li>
				</ul>
			    </li>
			    <li>Create the next question by clicking on Save + Next Question. Click on Save to view all survey questions.</li>
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
            <td width="48%"><input name="title" size="35" onKeyDown="textCounter(document.skform.title)" onKeyUp="textCounter(document.skform.title)"/></td>
            <td width="49%"><select name="qtype">
                    <option value="0">Free Text</option>
                    <option value="1" selected>Multiple Choice</option>
                    <option value="2">Final Message</option>
		</select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #1</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #2</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option1" size="35" onKeyDown="textCounter(document.skform.option1)" onKeyUp="textCounter(document.skform.option1)"/></td>
            <td width="49%"><input name="option2" size="35" onKeyDown="textCounter(document.skform.option2)" onKeyUp="textCounter(document.skform.option2)"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #3</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #4</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option3" size="35" onKeyDown="textCounter(document.skform.option3)" onKeyUp="textCounter(document.skform.option3)"/></td>
            <td width="49%"><input name="option4" size="35" onKeyDown="textCounter(document.skform.option4)" onKeyUp="textCounter(document.skform.option4)"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Answer Option #5</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Answer Option #6</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input name="option5" size="35" onKeyDown="textCounter(document.skform.option5)" onKeyUp="textCounter(document.skform.option5)"/></td>
            <td width="49%"><input name="option6" size="35" onKeyDown="textCounter(document.skform.option6)" onKeyUp="textCounter(document.skform.option6)"/></td>
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
            <td width="48%" colspan="3">
		<font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input type="submit" value="Save + Next Question" name="submit"/>
			    <input type="submit" value="Save" name="submit"/>
			    <input type="button" value="Cancel" onclick="javascript:gogo('<?php echo "edit_questions.php?sid=$survey_id";?>')">
			</font>
		    </span>
		</font>
	    </td>
        </tr>
    </table>
</form>