<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}
?>
<?php
$user_id = string_wslashes($_GET['uid']);
if(!is_numeric($user_id)) exit;

$dbid1 = db_connect();

$query = "SELECT su.user_id, su.user_type, su.name, su.username, su.mobile, su.country, su.city, su.status, su.email FROM tbl_sys_user su WHERE su.sys_id = $param_session_sys_id AND su.user_id = $user_id";

$rs = mysql_query($query,$dbid1);
if($row = mysql_fetch_array($rs)) {
    $rs_user_id = $row['user_id'];
    $rs_user_type = $row['user_type']==1?"Individual":"Non Individual";
    $rs_usertype = $row['user_type'];
    $rs_name = $row['name'];
    $rs_username = $row['username'];
    $rs_mobile = $row['mobile'];
    $rs_country = $row['country'];
    $rs_city = $row['city'];
    $rs_status = $row['status'];
    $rs_email = $row['email'];

    if($rs_usertype=="1") {
	$query = "SELECT * FROM tbl_sys_user_ind WHERE user_id = $rs_user_id";
	$rs2 = mysql_query($query,$dbid1);
	if($row2 = mysql_fetch_array($rs2)) {
	    $rs_dob_y = $row2['dob_y'];
	    $rs_dob_m = $row2['dob_m'];
	    $rs_dob_d = $row2['dob_d'];
	    $rs_gender = $row2['gender'];
	}
    }
    else if($rs_usertype=="2") {
	    $query = "SELECT * FROM tbl_sys_user_nind WHERE user_id = $rs_user_id";
	    $rs2 = mysql_query($query,$dbid1);
	    if($row2 = mysql_fetch_array($rs2)) {
		$rs_phone = $row2['phone'];
		$rs_fax = $row2['fax'];
		$rs_website = $row2['website'];
		$rs_business_field = $row2['business_field'];
		$rs_description = $row2['business_desc'];
	    }
	}
	else {
	    exit;
	}

    $referrer = $_SERVER['HTTP_REFERER'];

    ?>
<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,name,Required : Name.");
    rules.push("length<=100,name,Name : < 100 chars please.");

    //Mobile
    rules.push("digits_only,mobile,Mobile : Digits only please.");
    rules.push("required,mobile,Required : Mobile.");
    rules.push("length<=20,mobile,Mobile : < 20 digits please.");

    //Email
    rules.push("valid_email,email,Email : Not Valid Email");

    <?php if($rs_usertype=="1") {?>
        //DOB
        //rules.push("valid_date,month,day,year,any_date,Date of Birth : Invalid Date.");
    <?php }?>

    <?php if($rs_usertype=="2") {?>
        //Phone
        rules.push("digits_only,phone,Phone : Digits only please.");
        rules.push("length<=20,phone,Phone : < 20 digits please.");

        //Fax
        rules.push("digits_only,fax,Fax : Digits only please.");
        rules.push("length<=20,fax,Fax : < 20 digits please.");
    <?php }?>
</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="usertype" value="<?php echo $rs_usertype;?>">
    <input type="hidden" name="user_id" value="<?php echo $rs_user_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <span lang="en-us">Please fill out the following form to edit the user.</span></font></td>
        </tr>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">*
		    Required<span lang="en-us"> field.</span></font></td>
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
			    <input name="name" size="35" value="<?php echo $rs_name;?>" /></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Mobile<font color="#FF0000">
			*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input name="mobile" size="35" value="<?php echo $rs_mobile;?>" /></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">PIN Code</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Password</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">
		    <input name="pin" value="1234" size="35" type="checkbox" />&nbsp;Reset PIN to 1234</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">
		    <input name="password" value="1234" size="35" type="checkbox" />&nbsp;Reset Password to 1234</font></td>
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
            <td width="48%"><select size="1" name="country" style="width:245px;">
    <?php
    $dbid = db_connect();
    $rs = mysql_query("SELECT c.country_id, ct.name FROM tbl_ref_country c, tbl_ref_country_title ct WHERE ct.country_id = c.country_id AND ct.language_id = $param_session_sys_language AND c.country_id = $param_session_sys_country", $dbid);
    if($row = mysql_fetch_array($rs)) {
	$row_id = $row[0];
	$row_name = $row[1];
	$row_selected = $row_id==$rs_country?"Selected":"";
			    echo "<option value=\"$row_id\" $row_selected>$row_name</option>";
			}
			?>
		</select></td>
            <td width="49%"><select size="1" name="city" style="width:245px;">
			<?php
			$rs1 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $param_session_sys_country", $dbid);
			while($row1 = mysql_fetch_array($rs1)) {
			    $row_id = $row1[0];
			    $row_name = $row1[1];
			    $row_selected = $row_id==$rs_city?"Selected":"";
	echo "<option value=\"$row_id\" $row_selected>$row_name</option>";
    }
			db_close($dbid);
			?>
		</select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Email Address</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Active Status</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="text" name="email" size="35" value="<?php echo $rs_email;?>" ></td>
            <td width="49%">
                <select name="status" style="width:245px;">
                    <option value="1" <?php echo $rs_status==1?"Selected":"";?>>On</option>
                    <option value="0" <?php echo $rs_status==0?"Selected":"";?>>Off</option>
                </select>
            </td>
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
            <td width="48%">
                <select size="1" name="year" onChange="populate(this.form,this.form.month.selectedIndex);">
	<?php
	for($years = Date("Y");$years >= 1910;$years--) {
	    $row_selected = $rs_dob_y==$years?"Selected":"";
	    echo "<option value=\"$years\" $row_selected>$years</option>";
	}
	?>
                </select> <select size="1" name="month" onChange="populate(this.form,this.selectedIndex);">
                    <option value="01" <?php echo $rs_dob_m==1?"Selected":"";?>>January</option>
                    <option value="02" <?php echo $rs_dob_m==2?"Selected":"";?>>February</option>
                    <option value="03" <?php echo $rs_dob_m==3?"Selected":"";?>>March</option>
                    <option value="04" <?php echo $rs_dob_m==4?"Selected":"";?>>April</option>
                    <option value="05" <?php echo $rs_dob_m==5?"Selected":"";?>>May</option>
                    <option value="06" <?php echo $rs_dob_m==6?"Selected":"";?>>June</option>
                    <option value="07" <?php echo $rs_dob_m==7?"Selected":"";?>>July</option>
                    <option value="08" <?php echo $rs_dob_m==8?"Selected":"";?>>August</option>
                    <option value="09" <?php echo $rs_dob_m==9?"Selected":"";?>>September</option>
                    <option value="10" <?php echo $rs_dob_m==10?"Selected":"";?>>October</option>
                    <option value="11" <?php echo $rs_dob_m==11?"Selected":"";?>>November</option>
                    <option value="12" <?php echo $rs_dob_m==12?"Selected":"";?>>December</option>
                </select>
                <select size="1" name="day">
	<?php
	for($days = 1;$days <= 31;$days++) {
	    $row_selected = $rs_dob_d==$days?"Selected":"";
	    echo "<option value=\"$days\" $row_selected>$days</option>";
	}
	?>
                </select>
            </td>
            <td width="49%"><select size="1" name="gender" style="width:245px;">
                    <option value="0" <?php echo $rs_gender==0?"Selected":"";?>>Male</option>
                    <option value="1" <?php echo $rs_gender==1?"Selected":"";?>>Female</option>
		</select></td>
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
			    <input name="phone" size="35" value="<?php echo $rs_phone;?>" /></font></span></font></td>
            <td width="49%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input name="fax" size="35" value="<?php echo $rs_fax;?>" /></font></span></font></td>
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
			    <input name="website" size="35" value="<?php echo $rs_website;?>" /></font></span></font></td>
            <td width="49%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
			    <input name="business_field" size="35" value="<?php echo $rs_business_field;?>" /></font></span></font></td>
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
            <td width="48%" colspan="2"><b><font face="Trebuchet MS" size="2">Current Modules for <?php echo $rs_user_type;?> User <?php echo $rs_name;?></font></b></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><font face="Trebuchet MS" size="2">
    <?php
    $proh_module = $rs_usertype==1?5:6;
    $rs3 = mysql_query("SELECT rm.module_id, rmt.name, (SELECT 1 FROM tbl_sys_user_module um WHERE um.module_id = sm.module_id AND um.module_id = rm.module_id AND um.user_id = $rs_user_id) FROM tbl_ref_module rm, tbl_sys_module sm, tbl_ref_module_title rmt WHERE sm.module_id = rm.module_id AND rmt.module_id = rm.module_id AND rmt.language_id = 1 AND sm.module_id <> $proh_module AND sm.module_id <> 1 AND sm.sys_id = $param_session_sys_id", $dbid1);
	    while($row3 = mysql_fetch_array($rs3)) {
	?>
                    <input type="checkbox" name="av_module[]" value="<?php echo $row3[0];?>" <?php echo $row3[2]==1?"checked":"";?>>&nbsp;<?php echo $row3[1];?><br>
    <?php
    }
    ?>
		</font></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Edit User" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>')">
	    </td>
        </tr>
    </table>
</form>
		    <?php
		    }
db_close($dbid1);
?>
