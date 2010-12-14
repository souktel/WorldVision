<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$current_sv_rs = mysql_query("SELECT svc.survey_id, svc.question_id, q.qtype, q.next_qid FROM tbl_survey_current svc, tbl_survey_question q WHERE svc.survey_id = q.survey_id AND svc.question_id = q.question_id AND lower(svc.mobile) = lower('$req_mobile')", $sms_dbid);

$answer_text = $req_msg;

if($current_sv_rs)
{
    if($current_sv_row = mysql_fetch_array($current_sv_rs))
    {

        mysql_query("BEGIN", $sms_dbid);

        if(endCMD($answer_text))
        {
            mysql_query("DELETE FROM tbl_survey_current WHERE mobile = '$req_mobile'", $sms_dbid);
            mysql_query("COMMIT", $sms_dbid);
            reply("C45", null);
        }

        $survey_id = $current_sv_row[0];
        $question_id = $current_sv_row[1];
        $qtype = $current_sv_row[2];
        $next_qid = trim($current_sv_row[3]); // We use this if it's a essay question

        if($qtype == 0 || $qtype == "0") //Essay Question :: Free Text
        {

            $answer_rs = mysql_query("INSERT INTO tbl_survey_answer_e VALUES(id, $survey_id, $question_id, '$req_mobile', '$answer_text')", $sms_dbid);
            if($answer_rs)
            {
                if(!is_numeric($next_qid))
                {
                    mysql_query("DELETE FROM tbl_survey_current WHERE mobile = '$req_mobile'", $sms_dbid);
                    mysql_query("COMMIT", $sms_dbid);
                    exit;
                }
                else
                {
                    $ques = getNextQuestion($req_mobile, $survey_id, $next_qid);
                    if($ques == false)
                    {
                        mysql_query("ROLLBACK", $sms_dbid);
                        reply("C46", null);
                    }
                    else
                    {
                        mysql_query("COMMIT", $sms_dbid);
                        reply_static($ques[1]);
                    }
                }
            }
            else
            {
                mysql_query("ROLLBACK", $sms_dbid);
                reply("C47", null);
            }
        }
        else if($qtype == 1 || $qtype == "1") //Multiple Choice Question :: Integers
        {
            $answer_text = convertStr2Nbr($answer_text);
            $answer_rs = mysql_query("INSERT INTO tbl_survey_answer_m VALUES(id, $survey_id, $question_id, $answer_text, '$req_mobile')", $sms_dbid);
            if($answer_rs)
            {
                $select_next_rs = mysql_query("SELECT next_qid FROM tbl_survey_option WHERE survey_id = $survey_id AND question_id = $question_id AND option_id = $answer_text", $sms_dbid);

                if($select_next_rs)
                {
                    if($select_next_rw = mysql_fetch_array($select_next_rs))
                    {
                        $next_qid = trim($select_next_rw[0]);
                        if(!is_numeric($next_qid))
                        {
                            mysql_query("DELETE FROM tbl_survey_current WHERE mobile = '$req_mobile'", $sms_dbid);
                            mysql_query("COMMIT", $sms_dbid);
                            exit;
                        }
                        else
                        {
                            $ques = getNextQuestion($req_mobile, $survey_id, $next_qid);
                            if($ques == false)
                            {
                                mysql_query("ROLLBACK", $sms_dbid);
                                reply("C48", null);
                            }
                            else
                            {
                                mysql_query("COMMIT", $sms_dbid);
                                reply_static($ques[1]);
                            }
                        }
                    }
                    else
                    {
                        mysql_query("ROLLBACK", $sms_dbid);
                        reply("C49", null);
                    }
                }
                else
                {
                    mysql_query("ROLLBACK", $sms_dbid);
                    reply("C50", null);
                }

            }
            else
            {
                mysql_query("ROLLBACK", $sms_dbid);
                reply("C51", null);
            }
        }
        else
        {
            mysql_query("ROLLBACK", $sms_dbid);
            reply("C52", null);
        }
    }
    else
    {
        //Skip Surveys
    }
}
else
{
    //Skip Surveys
}

?>
