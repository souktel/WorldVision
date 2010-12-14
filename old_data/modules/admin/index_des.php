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
$query = "SELECT sys_id, name, reference_code, prefix, addition_date, status FROM tbl_sys";
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><b>Name</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Reference</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b>Prefix</b></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><b>Registration Date</b></font></td>
        <td width="130">&nbsp;</td>
    </tr>
    <?php
    //$co = 0;
    while($row = mysql_fetch_array($rs))
    {
        //$co++;
        //$rs_number = $co;
        $rs_sys_id = $row['sys_id'];
        $rs_name = $row['name'];
        $rs_reference = $row['reference_code'];
        $rs_prefix = $row['prefix'];
        $rs_status = $row['status'];
        $rs_addition_date = $row['addition_date'];
        ?>
    <!--design tr,td table -->
    <?php if(strtoupper($rs_prefix) != "SK" || $rs_sys_id != 1) {?>
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2">&nbsp;</font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><?php echo $rs_name;?></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_reference;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><?php echo $rs_prefix;?></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
        <td width="130"><table border="0" width="80" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td><font face="Trebuchet MS" size="2"><img border="0" src="<?php echo $param_abs_path_sib.($rs_status=="1"?"on.png":"off.png");?>" width="16" height="16"></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="edit_system.php?sid=<?php echo $rs_sys_id;?>"><img title="Edit System Info" border="0" src="<?php echo $param_abs_path_sib."edit_system_s.png";?>" width="16" height="16"></a></font></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_system.php?sid=<?php echo $rs_sys_id;?>"><img title="Delete System" border="0" src="<?php echo $param_abs_path_sib."delete_system_s.png";?>" width="16" height="16"></a></font></td>
                </tr>
        </table></td>
    </tr>
    <?php }?>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php

require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>
