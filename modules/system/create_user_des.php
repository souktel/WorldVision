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
<script language="JavaScript">
    var rules = [];

    //Name
    rules.push("required,name,Required : Name.");
    rules.push("length<=100,name,Name : < 100 chars please.");

    //Mobile
    rules.push("digits_only,mobile,Mobile : Digits only please.");
    rules.push("required,mobile,Required : Mobile.");
    rules.push("length<=20,mobile,Mobile : < 20 digits please.");

    //PIN CODE
    rules.push("digits_only,pin,PIN : Digits only please.");
    rules.push("required,pin,Required : PIN.");
    rules.push("length=4-4,pin,PIN : 4 Digits");

    //Confirm PIN
    rules.push("same_as,confirmpin,pin,PIN not equal Confirmation PIN");

    //Password
    rules.push("is_alpha,password,Password : 0-9, a-Z only please.");
    rules.push("required,password,Required : Password.");
    rules.push("length=4-20,password,Password : 4 - 15 chars");

    //Confirm Password
    rules.push("same_as,confirmpassword,password,Password not equal Confirmation Password");

    //Email
    rules.push("valid_email,email,Email : Not Valid Email");

    //DOB
    //rules.push("valid_date,month,day,year,any_date,Date of Birth : Invalid Date.");

    //Phone
    rules.push("digits_only,phone,Phone : Digits only please.");
    rules.push("length<=20,phone,Phone : < 20 digits please.");

    //Fax
    rules.push("digits_only,fax,Fax : Digits only please.");
    rules.push("length<=20,fax,Fax : < 20 digits please.");
</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
                    <span lang="en-us">Please fill out the following form to create a new
            user.</span></font></td>
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
            <input name="name" size="35" /></font></span></font></td>
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
            <input name="mobile" size="35"  value="972"/></font></span></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Pin Code<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Confirm Pin Code<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS">
                    <span style="font-size: 11pt">
                        <font face="Verdana" style="font-size: 11pt">
            <input name="pin" size="35" type="password" value="1234"/></font></span></font></td>
            <td width="49%"><font face="Trebuchet MS">
                    <span style="font-size: 11pt">
                        <font face="Verdana" style="font-size: 11pt">
            <input name="confirmpin" size="35" type="password"  value="1234"/></font></span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Password<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Confirm Password<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="password" name="password" size="35" value="1234"></td>
            <td width="49%">
            <input type="password" name="confirmpassword" size="35" value="1234"></td>
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
                    if($row = mysql_fetch_array($rs))
                    {
                        $row_id = $row[0];
                        $row_name = $row[1];
                        echo "<option value=\"$row_id\">$row_name</option>";
                    }
                    ?>
            </select></td>
            <td width="49%"><select size="1" name="city" style="width:245px;">
                    <?php
                    $rs1 = mysql_query("SELECT c.city_id, ct.name FROM tbl_ref_city c, tbl_ref_city_title ct WHERE ct.city_id = c.city_id AND ct.language_id = $param_session_sys_language AND c.country_id = $param_session_sys_country", $dbid);
                    while($row1 = mysql_fetch_array($rs1))
                    {
                        $row_id = $row1[0];
                        $row_name = $row1[1];
                        echo "<option value=\"$row_id\">$row_name</option>";
                    }
                    db_close($dbid);
                    ?>
            </select></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Email Address</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="text" name="email" size="35"></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">
                <p align="right">
                <input type="radio" value="1" name="usertype" checked /></p>
            </td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Individual</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
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
                    for($years = Date("Y");$years >= 1910;$years--)
                    {
                        echo "<option value=\"$years\">$years</option>";
                    }
                    ?>
                </select> <select size="1" name="month" onChange="populate(this.form,this.selectedIndex);">
                    <option value=01>January</option>
                    <option value=02>February</option>
                    <option value=03>March</option>
                    <option value=04>April</option>
                    <option value=05>May</option>
                    <option value=06>June</option>
                    <option value=07>July</option>
                    <option value=08>August</option>
                    <option value=09>September</option>
                    <option value=10>October</option>
                    <option value=11>November</option>
                    <option value=12>December</option>
                </select>
                <select size="1" name="day">
                    <?php
                    for($days = 1;$days <= 31;$days++)
                    {
                        echo "<option value=\"$days\">$days</option>";
                    }
                    ?>
                </select>
            </td>
            <td width="49%"><select size="1" name="gender" style="width:245px;">
                    <option selected value="0">Male</option>
                    <option value="1">Female</option>
            </select></td>
        </tr>
        <tr>
            <td width="3%">
                <p align="right"><input type="radio" value="2" name="usertype" /></p>
            </td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Non Individual</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Phone</font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Fax</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input name="phone" size="35" /></font></span></font></td>
            <td width="49%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input name="fax" size="35" /></font></span></font></td>
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
            <input name="website" size="35" /></font></span></font></td>
            <td width="49%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input name="business_field" size="35" /></font></span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
            <textarea rows="9" name="description" cols="49"></textarea></td>
        </tr>
        <tr>
            <td width="48%" colspan="3"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
                            <font color="RED"><div id="skform_errorloc"></div></font>
            <input type="submit" value="Create User" name="submit"/></font></span></font></td>
        </tr>
    </table>
</form>

<script language="JavaScript">

    /*/var frmvalidator  = new Validator("skform");

frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();

//Name
rules.push("name","alpha_s");
rules.push("name","req","Please enter the name");
rules.push("name","maxlen=100","Max length for name is 100");

//Mobile
rules.push("mobile","num");
rules.push("mobile","req","Please enter the mobile");
rules.push("mobile","maxlen=20","Max length for mobile is 20");

//PIN
rules.push("pin","num");
rules.push("pin","req","Please enter the PIN Code");
rules.push("pin","maxlen=4","Max length for PIN Code is 4");
rules.push("pin","minlen=4","Min length for PIN Code is 4");

//Confirm PIN
rules.push("confirmpin","num");
rules.push("confirmpin","req","Please enter the confirm PIN Code");
rules.push("confirmpin","maxlen=4","Max length for confirm PIN Code is 4");
rules.push("confirmpin","minlen=4","Min length for confirm PIN Code is 4");

//Password
rules.push("password","alnum");
rules.push("password","req","Please enter the password");
rules.push("password","maxlen=20","Max length for password is 20");
rules.push("password","minlen=4","Min length for password is 4");

//Confirm Password
rules.push("confirmpassword","alnum");
rules.push("confirmpassword","req","Please enter the confirm password");
rules.push("confirmpassword","maxlen=20","Max length for confirm password is 20");
rules.push("confirmpassword","minlen=4","Min length for confirm password is 4");

function DoCustomValidation()
{
var frm = document.forms["skform"];
if(frm.pin.value != frm.confirmpin.value)
{
alert('The PIN and confirmed PIN don not match!');
return false;
}
else
{
if(frm.password.value != frm.confirmpassword.value)
{
alert('The Password and confirmed password don not match!');
return false;
}
else
{
return true;
}
}
}

frmvalidator.setAddnlValidationFunction("DoCustomValidation");

//Email
rules.push("email","maxlen=255","Max length for email address is 255");
rules.push("email","email","Enter a valid email address");

//Phone
rules.push("phone","num");
rules.push("phone","maxlen=20","Max length for phone is 20");

//Fax
rules.push("fax","num");
rules.push("fax","maxlen=20","Max length for fax is 20");
     */

</script>
