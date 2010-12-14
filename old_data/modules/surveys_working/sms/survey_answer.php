<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) <= 1)
{
    reply("C39", null);
}
else if(sizeof($command_array) == 2)
{
    $survey_reference = $command_array[1];
    $reference_fc = str_split($survey_reference, 1);
    if(strtoupper($reference_fc[0]) != "S")
    {
        reply("C40", null);
    }
    else
    {
        $survey_rs = mysql_query("SELECT survey_id FROM tbl_survey WHERE upper(reference_code) = upper('$survey_reference') AND status >= 1", $sms_dbid);
        if($survey_rs)
        {
            if($survey_row = mysql_fetch_array($survey_rs))
            {
                $survey_id = $survey_row[0];
                mysql_query("BEGIN", $sms_dbid);
                $insert_current = mysql_query("INSERT INTO tbl_survey_current VALUES(id, null, null, '$req_mobile')", $sms_dbid);
                $ques = getNextQuestion($req_mobile, $survey_id, '');
                if($ques == false)
                {
                    mysql_query("ROLLBACK", $sms_dbid);
                    reply("C41", null);
                }
                else
                {
                    if(mysql_query("INSERT INTO tbl_survey_members VALUES(id,$survey_id , '$req_mobile')", $sms_dbid))
                    {
                        mysql_query("COMMIT", $sms_dbid);
                        reply_static($ques[1]);
                    }
                    else
                    {
                        mysql_query("ROLLBACK", $sms_dbid);
                        reply("C42", null);
                    }
                }
            }
            else
            {
                reply("C43", null);
            }
        }
        else
        {
            reply("C44", null);
        }
    }
}

?>
