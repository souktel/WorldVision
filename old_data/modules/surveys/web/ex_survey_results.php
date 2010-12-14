<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=survey_results.xml"); 
require_once("../../../config/parameters/params_db.php");
require_once("../../../config/database/db_mysql.php");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<srdoc>

    <?php
    $error_found = false;

    $get_values = split("-", $_GET['srv']);
    $get_value1 = split("A",$get_values[0]);
    $get_value2 = $get_values[1];

    $hash_val1 = sha1("125+6BP".$get_values[0]."+CcX");

    if($hash_val1 != $get_value2) exit;

    $survey_id = string_wslashes($get_value1[0]);
    if(!is_numeric($survey_id)) exit;

    $sys_id = string_wslashes($get_value1[1]);
    if(!is_numeric($sys_id)) exit;

    $user_id = string_wslashes($get_value1[2]);
    if(!is_numeric($user_id)) exit;

    $dbid = db_connect();

    if($rs = mysql_query("SELECT (SELECT title FROM tbl_survey_title WHERE survey_id = ss.survey_id), (SELECT description FROM tbl_survey_title WHERE survey_id = ss.survey_id), ss.status, ss.reference_code, ss.addition_date FROM tbl_survey ss WHERE ss.survey_id = $survey_id AND ss.sys_id = 1 AND ss.owner_id = 1", $dbid))
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

    ?>

    <?php
    $col_count = 0;
    $col_rs = mysql_query("SELECT qt.title, q.question_id, q.qtype FROM tbl_survey_question q, tbl_survey_question_title qt WHERE qt.question_id = q.question_id AND qt.survey_id = q.survey_id AND q.survey_id = $survey_id AND qt.language_id = 1 AND q.qtype <> 2 ORDER BY q.question_id ASC", $dbid);
    while($col_row = mysql_fetch_array($col_rs))
    {
        $questions[$col_count][0] = $col_row[0]; //Question Title
        $questions[$col_count][1] = $col_row[1]; //Question Id
        $questions[$col_count][2] = $col_row[2]; //Question Type [0 Essaqy, 1 Multiple]
        $col_count++;
    }

    $colwidth = 100/($col_count+1);

    $row_count = 0;

    $row_rs = mysql_query("SELECT DISTINCT mobile FROM tbl_survey_members WHERE survey_id = $survey_id", $dbid);
    while($row_row = mysql_fetch_array($row_rs))
    {
        $smembers[$row_count] = $row_row[0];
        $row_count++;
    }

    ?>
    <srrow id="1">
        <?php
        echo "<mobile>Members</mobile>";
        for($qi = 0; $qi < $col_count; $qi++)
        {
            $data_id = $qi+2;
            echo "<question".$data_id.">".htmlspecialchars($questions[$qi][0])."</question".$data_id.">";
        }
        ?>
    </srrow>
    <?php for($mi = 0; $mi < $row_count; $mi++) {
        $row_id = $mi+2;
        ?>
    <srrow id="<?php echo $row_id;?>">
        <mobile><?php echo htmlspecialchars($smembers[$mi]);?></mobile>
        <?php
        for($qi = 0; $qi < $col_count; $qi++)
        {
            $data_id = $qi+2;
            $answer_text = "";
            if($questions[$qi][2]==0)
            {
                $answer_text = "";
                $answer_rs = mysql_query("SELECT ans_text FROM tbl_survey_answer_e WHERE survey_id = $survey_id AND question_id = ".$questions[$qi][1]." AND mobile = '".$smembers[$mi]."'", $dbid);
                if($answer_rs)
                {
                    while($asnwer_row = mysql_fetch_array($answer_rs))
                    {
                        $answer_text .= $asnwer_row[0].";; ";
                    }
                    $answer_text = trim($answer_text,";; ");
                }
            } else if($questions[$qi][2]==1)
            {
                $answer_text = "";
                $answer_rs = mysql_query("SELECT ot.title FROM tbl_survey_answer_m oa, tbl_survey_option_title ot WHERE ot.survey_id = oa.survey_id AND ot.question_id = oa.question_id AND ot.option_id = oa.option_id AND oa.survey_id = $survey_id AND oa.question_id = ".$questions[$qi][1]." AND oa.mobile = '".$smembers[$mi]."'", $dbid);
                if($answer_rs)
                {
                    while($asnwer_row = mysql_fetch_array($answer_rs))
                    {
                        $answer_text .= $asnwer_row[0].";; ";
                    }
                    $answer_text = trim($answer_text,";; ");
                }
            }
            if(trim($answer_text) == "") $answer_text = "";
            echo "<question".$data_id.">".htmlspecialchars($answer_text)."</question".$data_id.">";
        }
        ?>
    </srrow>
    <?php }?>
</srdoc>

<?php
db_close($dbid);
?>


