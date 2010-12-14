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

    //New PIN CODE
    rules.push("digits_only,pin,New PIN : Digits only please.");
    rules.push("required,pin,Required : New PIN.");
    rules.push("length=4-4,pin,New PIN : 4 Digits");

    //New Confirm PIN
    rules.push("same_as,confirmpin,pin,New PIN not equal Confirmation PIN");

    //Current PIN CODE
    rules.push("digits_only,currentpin,Current PIN : Digits only please.");
    rules.push("required,currentpin,Required : Current PIN.");
    rules.push("length=4-4,currentpin,Current PIN : 4 Digits");
</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    <span lang="en-us">Please fill out the following form to change your PIN code.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">New PIN Code<font color="#FF0000">
			*</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Confirm New PIN Code<font color="#FF0000">
			*</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="password" name="pin" size="35"></td>
            <td width="49%">
		<input type="password" name="confirmpin" size="35"></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Current PIN Code<font color="#FF0000">
			*</font></font></td>
            <td width="49%">&nbsp</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="password" name="currentpin" size="35"></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Change PIN Code" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo 'index.php';?>')">
	    </td>
        </tr>
    </table>
</form>
