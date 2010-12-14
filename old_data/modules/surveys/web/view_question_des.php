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

$fullmsg = "";
$fullmsg .= $q_title;
for($fqt = 0; $fqt < sizeof($op_title); $fqt++) $fullmsg .= " ".($fqt+1)."-".$op_title[$fqt];
$fullmsg= trim($fullmsg);
$msgsize = strlen($fullmsg);

?>

<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td>
        <font face="Trebuchet MS" style="font-size: 10pt">Message Text</font></td>
    </tr>
    <tr>
        <td>
            <textarea cols="60" rows="5" readonly="true"><?php echo $fullmsg;?></textarea>
        </td>
    </tr>
    <tr>
        <td width="96%" colspan="3">
        <font face="Trebuchet MS" style="font-size: 10pt">Message Size: <b><?php echo $msgsize;?></b> Characters</font></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><b><font face="Trebuchet MS" size="2"><a href="<?php echo "edit_questions.php?sid=$survey_id";?>"><<&nbsp;Return to previous!</a></font></b></td>
    </tr>
</table>