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

$dbid = db_connect();

if(($_GET['sub'] == 2 || $_GET['sub'] == "2") && isset($_GET['mid']) && is_numeric($_GET['mid']))
{
    $emask_id = $_GET['mid'];
    $emask_keyword = $_GET['mask'];
    $emask_sc = $_GET['sc'];
    mysql_query("DELETE FROM tbl_survey_mask WHERE id = $emask_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid);
    $emask_msg = "Keyword $emask_keyword on $emask_sc deleted successfully.";
}

if($_GET['sub'] == 1 || $_GET['sub'] == "1")
{
    mysql_query("BEGIN", $dbid);
    $sizeSC = sizeof($_POST['shortcode']);
    $arr_SC = array();$arr_SC = $_POST['shortcode'];

    $smask_sys_id = $param_session_sys_id;
    $smask_user_id = $param_session_user_user_id;
    $smask_survey_id = mysql_escape_string($_POST['survey']);
    $smask_keyword = mysql_escape_string(strtolower($_POST['keyword']));
    $smask_language_id = mysql_escape_string($_POST['language']);
    if(!($smask_language_id == 1 || $smask_language_id == "1" || $smask_language_id == 2 || $smask_language_id == "2")) exit;

    for($i_m=0; $i_m<$sizeSC && $smask_keyword!=""; $i_m++)
    {
        $mask_existed = false;

        $smask_shortcode = mysql_escape_string($arr_SC[$i_m]);
    //    if($smask_shortcode == 1 || $smask_shortcode == "1") $smask_shortcode = "37190";
       if($smask_shortcode == 2 || $smask_shortcode == "3") $smask_shortcode = "37190";
        //else if($smask_shortcode == 3 || $smask_shortcode == "3") $smask_shortcode = "45609910303";
        //else if($smask_shortcode == 4 || $smask_shortcode == "4") $smask_shortcode = "37120";
        else exit;

        $rs_masking = mysql_query("SELECT 1 FROM tbl_command WHERE upper(command) = upper('$smask_keyword')", $dbid);
        if($row_masking = mysql_fetch_array($rs_masking))
        {
            $mask_existed = true;
        }
        else
        {
            $rs_masking = mysql_query("SELECT 1 FROM tbl_survey_mask WHERE upper(shortcode) = upper('$smask_shortcode') AND upper(mask) = upper('$smask_keyword')", $dbid);
            if($row_masking = mysql_fetch_array($rs_masking))
            {
                $mask_existed = true;
            }
            else
            {
                $registered_keyword = array();
                $registered_keyword[] = "end";
                $registered_keyword[] = "stop";
                $registered_keyword[] = "more";
                $registered_keyword[] = "skip";
                $registered_keyword[] = "ok";
                $registered_keyword[] = "#";
                $registered_keyword[] = "*";
                $registered_keyword[] = "اكثر";
                $registered_keyword[] = "أكثر";
                $registered_keyword[] = "مزيد";
                $registered_keyword[] = "موافق";
                $registered_keyword[] = "انهاء";
                $registered_keyword[] = "over";

                for($i_r=0; $i_r < sizeof($registered_keyword); $i_r++)
                {
                    if(strtoupper($smask_keyword) == strtoupper($registered_keyword[$i_r]))
                    {
                        $mask_existed = true;
                        break;
                    }
                }

                if($mask_existed == false)
                {
                    if(!mysql_query("INSERT INTO tbl_survey_mask VALUES(id, $smask_sys_id, $smask_user_id, $smask_survey_id, '$smask_shortcode','$smask_keyword', $smask_language_id)", $dbid))
                    {
                        $mask_existed = true;
                    }
                }
            }
        }
        if($mask_existed)
        {
            $err_scds .= $smask_shortcode.", ";
            $err_keys .= $smask_keyword.", ";
            break;
        }
    }

    $err_scds = trim($err_scds);
    $err_scds = trim($err_scds, ",");

    $err_keys = trim($err_keys);
    $err_keys = trim($err_keys, ",");

    if($mask_existed == false)
    {
        mysql_query("COMMIT", $dbid);
    }
    else
    {
        mysql_query("ROLLBACK", $dbid);
    }
}

//Pages
$query = "
SELECT s.survey_id, (SELECT title FROM tbl_survey_title WHERE survey_id = s.survey_id) AS title, s.reference_code, m.id, m.mask, m.shortcode, (SELECT name FROM tbl_ref_language WHERE language_id = m.language_id) AS lang
 FROM tbl_survey s, tbl_survey_mask m, tbl_sys_user u
 WHERE s.sys_id = u.sys_id
 AND s.owner_id = u.user_id
 AND s.sys_id = m.sys_id
 AND s.owner_id = m.owner_id
 AND s.survey_id = m.survey_id
 AND s.sys_id = $param_session_sys_id
 AND s.owner_id = $param_session_user_user_id
 ORDER BY s.addition_date DESC, m.id DESC
";

$rs = mysql_query($query,$dbid);
$total_masks = mysql_num_rows($rs);

//List of Surveys

$rs_survey_id = array();
$rs_survey_reference = array();
$rs_survey_title = array();

$query_survey = "SELECT ss.survey_id, ss.reference_code, (SELECT title FROM tbl_survey_title WHERE survey_id = ss.survey_id) FROM tbl_sys_user su, tbl_survey ss WHERE su.sys_id = $param_session_sys_id AND su.user_id = $param_session_user_user_id AND ss.owner_id = su.user_id AND ss.status >= 1 ORDER BY ss.addition_date DESC";
$rs_survey = mysql_query($query_survey,$dbid);
while($row_survey = mysql_fetch_array($rs_survey))
{
    $rs_survey_id[] = $row_survey[0];
    $rs_survey_reference[] = $row_survey[1];
    $rs_survey_title[] = $row_survey[2];
}
//==

?>

<?php if(sizeof($rs_survey_id)!=0) {?>
<form name="skform" method="POST" action="survey_mask.php?sub=1">
    <table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td colspan="3"><font face="Trebuchet MS" size="2">Keywords are used to help recipients activate a survey.  Keywords can be both alpha and/or numerical. Please ensure that the Keyword you select is easy to identify.</font></td>
        </tr>
	<tr>
            <td width="225"><font face="Trebuchet MS" size="2">Survey Title</font></td>
            <td width="225"><font face="Trebuchet MS" size="2">Keyword</font></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="225">
                <select name="survey" style="width:200px;">
                    <?php
                    for($rs_s_i=0; $rs_s_i<sizeof($rs_survey_id); $rs_s_i++)
                    {
                        $rsi_survey_id = $rs_survey_id[$rs_s_i];
                        $rsi_survey_reference = $rs_survey_reference[$rs_s_i];
                        $rsi_survey_title = $rs_survey_title[$rs_s_i];
                        echo "<option value=\"$rsi_survey_id\">$rsi_survey_reference | $rsi_survey_title</option>";
                    }
                    ?>
                </select>
            </td>
            <td width="225"><input type="text" name="keyword" maxlength="20" style="width:200px;"></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="225"><font face="Trebuchet MS" size="2">Language</font></td>
            <td width="225"><font face="Trebuchet MS" size="2">Shortcode</font></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="225" valign="top">
                <select name="language" style="width:200px;">
                    <option value="1">English</option>
                    <option value="2">Arabic</option>
                </select>
            </td>
            <td width="225">
                <font face="Trebuchet MS" size="2">
                 <!--   <input type="checkbox" name="shortcode[]" value="2">Jawwal 37191<br>-->
                    <input type="checkbox" name="shortcode[]" value="3">Jawwal. 37190<br>
                </font>
            </td>
            <td valign="bottom">
		<input type="submit" value="Assign Keyword">
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo "index.php";?>')">
	    </td>
        </tr>
        <?php if($mask_existed == true) {?>
        <tr>
            <td colspan="3"><font face="Trebuchet MS" size="2" color="RED">Sorry, the keyword that you selected for shortcode <?php echo $err_scds;?> already exists. Please select another one.</font>
        </tr>
        <?php }?>
    <?php if($_GET['sub'] == 2 || $_GET['sub'] == "2") {?>
        <tr>
            <td colspan="3"><font face="Trebuchet MS" size="2" color="RED"><?php echo $emask_msg;?></font></td>
        </tr>
        <?php }?>
    </table>
</form>
<?php } else {?>
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td colspan="3"><font face="Trebuchet MS" size="2" color="RED">You don't have any survey yet.</font></td>
    </tr>
</table>
<?php }?>
<?php if($total_masks > 0) {?>
<hr size="0" noshade>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="120"><font face="Trebuchet MS" size="2"><b>Keyword</b></font></td>
        <td width="120"><font face="Trebuchet MS" size="2"><b>Short Code</b></font></td>
        <td width="70">&nbsp;</td>
    </tr>
    <?php
    while($row = mysql_fetch_array($rs))
    {
        $rs_survey_id = $row['survey_id'];
        $rs_title = $row['title'];
        $rs_reference = $row['reference_code'];
        $rs_mask = $row['mask'];
        $rs_id = $row['id'];
        $rs_shortcode = $row['shortcode'];
        $rs_lang = $row['lang'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib;?>view_survey_s.png"></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><a href="view_survey.php?sid=<?php echo $rs_survey_id;?>"><?php echo $rs_title;?></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="120"><font face="Trebuchet MS" size="2"><?php echo $rs_mask;?></font></td>
        <td width="120"><font face="Trebuchet MS" size="2"><?php echo $rs_shortcode;?></font></td>
        <td width="70"><table border="0" width="100" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr align="left">
                    <td align="left"><font face="Trebuchet MS" size="2"><a href="survey_mask.php?sub=2&mid=<?php echo $rs_id;?>&mask=<?php echo $rs_mask;?>&sc=<?php echo $rs_shortcode;?>">delete</a></font></td>
                </tr>
        </table></td>
    </tr>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php
}
db_close($dbid);
?>