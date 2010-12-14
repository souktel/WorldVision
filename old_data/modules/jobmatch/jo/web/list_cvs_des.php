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

$rowsPerPage = $param_db_rows_per_page;

$offset = ($pageNum - 1) * $rowsPerPage;
//==

$dbid = db_connect();

//Pages
$query = "SELECT cv_id, reference_code, status, addition_date, (select name from tbl_sys_user where user_id = cv.user_id) name FROM tbl_js_mini_cv cv WHERE sys_id = $param_session_sys_id AND status >= 1 ORDER BY addition_date DESC";
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="323"><font face="Trebuchet MS" size="2"><b>Name</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><b>Creation Date</b></font></td>
        <td width="130">&nbsp;</td>
    </tr>
    <?php
    //$co = 0;
    while($row = mysql_fetch_array($rs))
    {
        //$co++;
        //$rs_number = $co;
        $rs_cv_id = $row['cv_id'];
        $rs_name = $row['name'];
        $rs_reference = $row['reference_code'];
        $rs_status = $row['status'];
        $rs_addition_date = $row['addition_date'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $param_abs_path_sib."view_cv_s.png";?>"></font></td>
        <td width="323"><font face="Trebuchet MS" size="2"><a href="view_cv.php?cid=<?php echo $rs_cv_id;?>"><?php echo $rs_name;?></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
        <td width="130">&nbsp;</td>
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
