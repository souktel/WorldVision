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
$user_id = string_wslashes($_GET['uid']);
if(!is_numeric($user_id)) exit;

$dbid1 = db_connect();

$query = "SELECT su.user_id, su.user_type, su.name, su.username, su.mobile, cot.name AS country_name, co.internet_code AS internet, cit.name AS city_name, su.status, su.addition_date, su.email FROM tbl_sys_user su, tbl_ref_country co, tbl_ref_country_title cot, tbl_ref_city ci, tbl_ref_city_title cit WHERE su.sys_id = $param_session_sys_id AND su.country = co.country_id AND co.country_id = cot.country_id AND cot.language_id = $param_session_sys_language AND su.city = ci.city_id AND ci.city_id = cit.city_id AND cit.language_id = $param_session_sys_language AND su.user_id = $user_id";

$rs = mysql_query($query,$dbid1);
if($row = mysql_fetch_array($rs))
{
    $rs_user_id = $row['user_id'];
    $rs_user_type = $row['user_type']==1?"Individual":"Non Individual";
    $rs_usertype = $row['user_type'];
    $rs_name = $row['name'];
    $rs_username = $row['username'];
    $rs_mobile = $row['mobile'];
    $rs_country_name = $row['country_name'];
    $rs_internet = $row['internet'];
    $rs_city_name = $row['city_name'];
    $rs_status = $row['status']==0?"OFF":"ON";
    $rs_addition_date = $row['addition_date'];
    $rs_email = $row['email'];

    if($rs_usertype=="1")
    {
        $query = "SELECT * FROM tbl_sys_user_ind WHERE user_id = $rs_user_id";
        $rs2 = mysql_query($query,$dbid1);
        if($row2 = mysql_fetch_array($rs2))
        {
            $rs_dob = $row2['dob_y']."-".$row2['dob_m']."-".$row2['dob_d'];
            $rs_gender = $row2['gender']=="0"?"Male":"Female";
        }
    }
    else if($rs_usertype=="2")
    {
        $query = "SELECT * FROM tbl_sys_user_nind WHERE user_id = $rs_user_id";
        $rs2 = mysql_query($query,$dbid1);
        if($row2 = mysql_fetch_array($rs2))
        {
            $rs_phone = $row2['phone'];
            $rs_fax = $row2['fax'];
            $rs_website = $row2['website'];
            $rs_business_field = $row2['business_field'];
            $rs_description = $row2['business_desc'];
        }
    }
    else
    {
        exit;
    }

    $referrer = $_SERVER['HTTP_REFERER'];

    ?>
<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <tr>
        <td width="96%" colspan="3">
            <font face="Trebuchet MS" style="font-size: 10pt">
        <span lang="en-us">View <?php echo $rs_user_type;?> User <?php echo $rs_name;?></span></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><b><font face="Trebuchet MS" size="2">General Information</font></b></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Name<font color="#FF0000">
        *</font></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="name" size="35" readonly="true" value="<?php echo $rs_name;?>" /></font></span></font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Username<font color="#FF0000">
        *</font></font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Mobile<font color="#FF0000">
        *</font></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="mobile" size="35" readonly="true" value="<?php echo $rs_username;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="mobile" size="35" readonly="true" value="<?php echo $rs_mobile;?>" /></font></span></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Country<font color="#FF0000">
        *</font></font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">City<font color="#FF0000">
        *</font></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="country" size="35" readonly="true" value="<?php echo $rs_country_name;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="city" size="35" readonly="true" value="<?php echo $rs_city_name;?>" /></font></span></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Email Address</font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><input type="text" name="email" size="35" readonly="true" value="<?php echo $rs_email;?>" ></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Status<font color="#FF0000">
        *</font></font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Registration Date<font color="#FF0000">
        *</font></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="status" size="35" readonly="true" value="<?php echo $rs_status;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="addition_date" size="35" readonly="true" value="<?php echo $rs_addition_date;?>" /></font></span></font></td>
    </tr>
    <?php if($rs_usertype=="1") {?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Date Of Birth<font color="#FF0000">
        *</font></font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Gender<font color="#FF0000">
        *</font></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="dob" size="35" readonly="true" value="<?php echo $rs_dob;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="gender" size="35" readonly="true" value="<?php echo $rs_gender;?>" /></font></span></font></td>
    </tr>
    <?php } else if($rs_usertype=="2") {?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Phone</font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Fax</font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="phone" size="35" readonly="true" value="<?php echo $rs_phone;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="fax" size="35" readonly="true" value="<?php echo $rs_fax;?>" /></font></span></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Website</font></td>
        <td width="49%"><font face="Trebuchet MS" size="2">Business Field</font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="website" size="35" readonly="true" value="<?php echo $rs_website;?>" /></font></span></font></td>
        <td width="49%"><font face="Verdana" style="font-size: 11pt">
                <span style="font-size: 11pt"><font face="Trebuchet MS">
        <input name="business_field" size="35" readonly="true" value="<?php echo $rs_business_field;?>" /></font></span></font></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
        <td width="49%">&nbsp;</td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2">
        <textarea rows="9" name="description" cols="49"><?php echo $rs_description;?></textarea></td>
    </tr>
    <?php }?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2">Available Modules for <?php echo $rs_user_type;?> User <?php echo $rs_name;?></font></b></td>
    </tr>
    <?php
    $mnum = 1;
    $rs3 = mysql_query("SELECT rmt.name FROM tbl_ref_module rm, tbl_sys_module sm, tbl_sys_user_module um, tbl_ref_module_title rmt WHERE um.module_id = sm.module_id AND um.module_id = rm.module_id AND sm.module_id = rm.module_id AND rmt.module_id = rm.module_id AND rmt.language_id = 1 AND sm.sys_id = $param_session_sys_id AND um.user_id = $rs_user_id", $dbid1);
    while($row3 = mysql_fetch_array($rs3))
    {
        ?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><font face="Trebuchet MS" size="2"><?php echo $mnum++;?>)&nbsp;<?php echo $row3[0];?></font></td>
    </tr>
    <?php
}
if($mnum==1)
{
    ?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><font face="Trebuchet MS" size="2">No Modules</font></td>
    </tr>
    <?php
}
?>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2">Tools</font></b></td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2">
            <table border="0" width="130" align="left" cellspacing="3" cellpadding="3" style="border-collapse: collapse" height="25">
                <tr>
                    <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."edit_user_s.png";?>" width="16" height="16"></td>
                    <td><font face="Trebuchet MS" size="2"><a href="edit_user.php?uid=<?php echo $rs_user_id;?>&ru=<?php echo $referrer;?>">Edit</a></font></td>
                    <td width="17"><img border="0" src="<?php echo $param_abs_path_sib."delete_user_s.png";?>" width="16" height="16"></td>
                    <td><font face="Trebuchet MS" size="2"><a href="delete_user.php?uid=<?php echo $rs_user_id;?>&ru=<?php echo $referrer;?>">Delete</a></font></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2"><a href="<?php echo $referrer;?>"><<&nbsp;Return to previous!</a></font></b></td>
    </tr>
</table>
<?php
}
db_close($dbid1);
?>