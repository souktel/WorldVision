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

<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel</title>

        <style type="text/css">
            a {
              color: #000000;
            }

            a:link {
              text-decoration: none;
            }
            a:visited {
              text-decoration: none;
            }
            a:hover {
              text-decoration: underline;
            }
            a:active {
              text-decoration: none;
            }
        </style>

        <script LANGUAGE="JavaScript">

            function populate(objForm,selectIndex) {
                timeA = new Date(objForm.year.options[objForm.year.selectedIndex].text, objForm.month.options[objForm.month.selectedIndex].value,1);
                timeDifference = timeA - 86400000;
                timeB = new Date(timeDifference);
                var daysInMonth = timeB.getDate();
                for (var i = 0; i < objForm.day.length; i++) {
                    objForm.day.options[0] = null;
                }
                for (var ij = 0; ij < daysInMonth; ij++) {
                    objForm.day.options[ij] = new Option(ij+1);
                }
                document.f1.day.options[0].selected = true;
            }
            function getYears() {

                // You can easily customize what years can be used
                var years = new Array(1997,1998,1999,2000,2001,2005)

                for (var i = 0; i < document.f1.year.length; i++) {
                    document.f1.year.options[0] = null;
                }
                timeC = new Date();
                currYear = timeC.getFullYear();
                for (var ij = 0; ij < years.length; ij++) {
                    document.f1.year.options[ij] = new Option(years[ij]);
                }
                document.f1.year.options[2].selected=true;
            }
            window.onLoad = getYears;

        </script>

        <script language="JavaScript" src="<?php echo $apath."templates/js/"; ?>gen_validatorv31.js" type="text/javascript"></script>
        <script language="JavaScript" src="<?php echo $apath."templates/js/"; ?>validation.js" type="text/javascript"></script>

    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

        <div align="center">

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
            ?>

            <table border="0" width="100%" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background_w.gif">
                <tr>
                    <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left_w.gif">&nbsp;</td>
                    <td height="20" background="<?php echo $param_abs_path_si;?>body-upper_w.gif">&nbsp;</td>
                    <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right_w.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                    <td><span lang="en-us"><font size="3" face="Trebuchet MS"><?php echo "<b>Survey Results: ".$rs_title." [".$rs_addition_date."]</b>";?></font></span></td>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                    <td><hr size="0" noshade></td>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
                    <td>

                        <?php
                        $col_count = 0;
                        $col_rs = mysql_query("SELECT qt.title, q.question_id, q.qtype FROM tbl_survey_question q, tbl_survey_question_title qt WHERE qt.question_id = q.question_id AND qt.survey_id = q.survey_id AND q.survey_id = $survey_id AND qt.language_id = $param_session_sys_language AND q.qtype <> 2 ORDER BY q.question_id ASC", $dbid);
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

                        <div align="left">
                            <table border="0" width="100%" cellspacing="5" cellpadding="10" style="border-collapse: collapse">
                                <tr>
                                    <?php
                                    echo "<td width=\"".$colwidth."%\" valign=\"top\"><b><font size=\"2\" face=\"Trebuchet MS\">Members</font></b></td>";
                                    for($qi = 0; $qi < $col_count; $qi++)
                                    {
                                        echo "<td width=\"".$colwidth."%\" valign=\"top\"><b><font size=\"2\" face=\"Trebuchet MS\">".$questions[$qi][0]."</font></b></td>";
                                    }
                                    ?>
                                </tr>
                                <?php for($mi = 0; $mi < $row_count; $mi++) {?>
                                <tr>
                                    <td width="<?php echo $colwidth;?>%" valign="top"><b><font size="2" face="Trebuchet MS"><?php echo $smembers[$mi];?></font></b></td>
                                    <?php
                                    for($qi = 0; $qi < $col_count; $qi++)
                                    {
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
                                        if(trim($answer_text) == "") $answer_text = "&nbsp;";
                                        echo "<td width=\"".$colwidth."%\" valign=\"top\"><font size=\"2\" face=\"Trebuchet MS\">".$answer_text."</font></td>";
                                    }
                                    ?>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                        <p>

                    </td>
                    <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-left_w.gif">&nbsp;</td>
                    <td height="20" background="<?php echo $param_abs_path_si;?>body-lower_w.gif">&nbsp;</td>
                    <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-right_w.gif">&nbsp;</td>
                </tr>
            </table>


</div></body></html>

<?php
db_close($dbid);
?>


