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
$query = "SELECT su.user_id, su.user_type, su.name, su.username, su.mobile, cot.name AS country_name, co.internet_code AS internet, cit.name AS city_name, su.status, su.addition_date FROM tbl_sys_user su, tbl_ref_country co, tbl_ref_country_title cot, tbl_ref_city ci, tbl_ref_city_title cit WHERE su.sys_id = $param_session_sys_id AND su.country = co.country_id AND co.country_id = cot.country_id AND cot.language_id = $param_session_sys_language AND su.city = ci.city_id AND ci.city_id = cit.city_id AND cit.language_id = $param_session_sys_language AND su.registered = 1 ORDER BY su.addition_date DESC";
$numrows = mysql_num_rows(mysql_query($query,$dbid));

$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);

?>
<!--design header table -->
<table border="0" width="680" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><b>&nbsp;</b></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><b>Name</b></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><b>Mobile</b></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><b>Location</b></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><b>Registration Date</b></font></td>
        <td width="130">&nbsp;</td>
    </tr>
    <?php
    //$co = 0;
    while($row = mysql_fetch_array($rs))
    {
        //$co++;
        //$rs_number = $co;
        $rs_user_id = $row['user_id'];
        $rs_user_type = $param_abs_path_si.($row['user_type']==1?"ind.png":"nind.png");
        $rs_name = $row['name'];
        $rs_username = $row['username'];
        $rs_mobile = $row['mobile'];
        //$rs_country_name = $row['country_name'];
        $rs_internet = $row['internet'];
        $rs_city_name = $row['city_name'];
        $rs_status = $row['status'];
        $rs_addition_date = $row['addition_date'];
        ?>
    <!--design tr,td table -->
    <tr>
        <td width="17"><font face="Trebuchet MS" size="2"><img src="<?php echo $rs_user_type;?>"></font></td>
        <td width="190"><font face="Trebuchet MS" size="2"><a href="view_user.php?uid=<?php echo $rs_user_id;?>"><?php echo $rs_name;?></a></font></td>
        <td width="80"><font face="Trebuchet MS" size="2"><?php echo $rs_mobile;?></font></td>
        <td width="133"><font face="Trebuchet MS" size="2"><?php echo $rs_city_name;?>,&nbsp;<?php echo $rs_internet;?></font></td>
        <td width="180"><font face="Trebuchet MS" size="2"><?php echo $rs_addition_date;?></font></td>
        <td width="130"><table border="0" width="80" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td width="17"><font face="Trebuchet MS" size="2"><img border="0" src="<?php echo $param_abs_path_sib.($rs_status=="1"?"on.png":"off.png");?>" width="16" height="16"></font></td>
                    <td width="17"><font face="Trebuchet MS" size="2"><a href="edit_user.php?uid=<?php echo $rs_user_id;?>"><img title="Edit User Info" border="0" src="<?php echo $param_abs_path_sib."edit_user_s.png";?>" width="16" height="16"></a></font></td>
                    <td>
                        <?php if($rs_user_id != $param_session_user_user_id) {?>
                        <font face="Trebuchet MS" size="2"><a href="delete_user.php?uid=<?php echo $rs_user_id;?>"><img title="Delete User" border="0" src="<?php echo $param_abs_path_sib."delete_user_s.png";?>" width="16" height="16"></a></font>
                        <?php } else {?>
                        &nbsp;
                        <?php }?>
                    </td>
                    
                </tr>
        </table></td>
    </tr>
    <?php
}
?>
    <!--design footer table -->
</table>
<?php
echo "<br><font face='Trebuchet MS' size='2'><b>".$numrows." Users Registered.</b>&nbsp;(<a href=\"export.php\">Export</a>)</font>";
require_once($apath."config/functions/show_pages_func.php");

db_close($dbid);
?>
