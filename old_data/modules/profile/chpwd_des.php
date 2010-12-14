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
$referrer = $_SERVER['HTTP_REFERER'];      
?>
<script language="JavaScript">
    var rules = [];

    //New Password
    rules.push("required,password,Required : New Password.");
    rules.push("is_alpha,password,New Password : 0-9 a-Z only please.");
    rules.push("length=4-20,password,New Password : 4 - 15 chars");

    //Confirm New Password
    rules.push("same_as,confirmpassword,password,New Password not equal Confirmation Password");

    //New Password
    rules.push("is_alpha,currentpassword,Current Password : 0-9 a-Z only please.");
    rules.push("required,currentpassword,Required : Current Password.");
    rules.push("length=4-20,currentpassword,Current Password : 4 - 15 chars");
</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <span lang="en-us">Please fill out the following form to change your password.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">New Password<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Confirm New Password<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="password" name="password" size="35"></td>
            <td width="49%">
		<input type="password" name="confirmpassword" size="35"></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Current Password<font color="#FF0000">
			*</font></font></td>
            <td width="49%">&nbsp</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="password" name="currentpassword" size="35"></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Change Password" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo 'index.php';?>')">
	    </td>
        </tr>
    </table>
</form>
