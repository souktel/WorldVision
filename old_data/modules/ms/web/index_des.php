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

<?php
//Pages
$pageNum = 1;

if(isset($_GET['page']))
{
    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
}

$rowsPerPage = 50;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "SELECT mobile, text, convert_tz(msg_time,'-05:00','+03:00') AS msgt FROM tbl_mini_survey WHERE sys_id = $param_session_sys_id";
$numrows = @mysql_num_rows(mysql_query($query,$dbid));

$rs = @mysql_query($query." ORDER BY id DESC LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td colspan="3"><font face="Trebuchet MS" size="2"><b>Total number of messages is:&nbsp;<?php echo $numrows;?></b></font></td>
    </tr>
    <tr>
        <td width="100"><font face="Trebuchet MS" size="2"><b>Mobile</b></font></td>
        <td width="125"><font face="Trebuchet MS" size="2"><b>Time</b></font></td>
        <td><font face="Trebuchet MS" size="2"><b>Participation Text</b></font></td>
    </tr>
    <?php
    while($row = @mysql_fetch_array($rs))
    {
        $rs_mobile = $row['mobile'];
        $rs_text = stripslashes($row['text']);
        $rs_time = $row['msgt'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="100"><font face="Trebuchet MS" size="2"><?php echo $rs_mobile;?></font></td>
        <td width="125"><font face="Trebuchet MS" size="2"><?php echo $rs_time;?></font></td>
        <td><font face="Trebuchet MS" size="2"><?php echo $rs_text;?></font></td>
    </tr>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php

require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>